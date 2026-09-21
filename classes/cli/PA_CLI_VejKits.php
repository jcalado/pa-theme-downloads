<?php

/**
 * Quarterly "Vivos em Jesus" (VEJ) kit rollover.
 *
 * Each quarter the four VEJ kits (Primeiros Passos, Iniciantes, Jardim de Infância,
 * Primários) get a new copy of every member post, with the quarter swapped in the
 * title, slug and B2 download links. This command does that copy.
 *
 *   wp vej-kits clone --from=3T --to=4T [--dry-run]
 *
 * - Target kits must already exist, titled like the source kit with the quarter
 *   swapped, e.g. "Iniciantes (Ano A - 3T)" -> "Iniciantes (Ano A - 4T)".
 * - New posts are created as drafts; editors publish them once the files are on B2.
 * - Member posts keep their featured image; the kit's own image is left to the editor,
 *   since its artwork changes every quarter.
 * - Re-running is safe: posts already cloned into the target kit are skipped.
 * - Prints every expected B2 file path so uploads can match the links exactly.
 */
class PaCliVejKits {

  const KIT_TITLES = ['Primeiros Passos', 'Iniciantes', 'Jardim de Infância', 'Primários'];
  const CLONED_FROM = '_vej_cloned_from';

  // Meta that belongs to the source post only.
  const SKIP_META = ['_edit_lock', '_edit_last', '_wp_old_slug', '_wp_old_date', self::CLONED_FROM];

  private $from;
  private $to;
  private $dryRun;

  /**
   * Clone the VEJ kit member posts from one quarter to the next.
   *
   * ## OPTIONS
   *
   * --from=<quarter>
   * : Source quarter, e.g. 3T.
   *
   * --to=<quarter>
   * : Target quarter, e.g. 4T.
   *
   * [--dry-run]
   * : Show what would be created without writing anything.
   *
   * @when after_wp_load
   */
  public function clone($args, $assoc) {
    $this->from   = $this->quarterNumber($assoc['from']);
    $this->to     = $this->quarterNumber($assoc['to']);
    $this->dryRun = \WP_CLI\Utils\get_flag_value($assoc, 'dry-run', false);

    if ($this->from === $this->to)
      \WP_CLI::error('--from and --to must differ.');

    if ($this->dryRun)
      \WP_CLI::log('DRY RUN: nothing will be written.');

    $b2Paths = [];

    foreach (self::KIT_TITLES as $group) {
      $sourceKit = $this->findKit($group, $this->from);
      $targetKit = $this->findKit($group, $this->to);

      if (!$sourceKit || !$targetKit) {
        \WP_CLI::warning(sprintf('%s: kit missing (source %s, target %s), skipping.', $group, $sourceKit ? $sourceKit->ID : '-', $targetKit ? $targetKit->ID : '-'));
        continue;
      }

      \WP_CLI::log(sprintf("\n== %s: kit %d -> kit %d", $group, $sourceKit->ID, $targetKit->ID));

      $targetValue = get_field('downloads_kits', $targetKit->ID, false) ?: [];
      $targetIds   = array_filter(explode(',', $targetValue['sticky'] ?? ''));
      $existing    = $this->clonedSources($targetIds);

      foreach ($this->kitPostIds($sourceKit->ID) as $sourceId) {
        $source = get_post($sourceId);

        if (!$source) {
          \WP_CLI::warning("  source post $sourceId not found, skipping.");
          continue;
        }

        $title = $this->swapQuarter($source->post_title);
        $links = $this->newLinks($sourceId);

        foreach ($links as $link)
          $b2Paths[] = rawurldecode(preg_replace('#^https://[^/]+/(upasd-recursos/)?#', '', $link));

        if (isset($existing[$sourceId])) {
          \WP_CLI::log(sprintf('  = %s (already cloned as %d)', $title, $existing[$sourceId]));
          continue;
        }

        if ($title === $source->post_title)
          \WP_CLI::warning("  title of $sourceId has no {$this->from}T marker: \"$title\"");

        \WP_CLI::log(sprintf('  + %s (%d files, from %d)', $title, count($links), $sourceId));

        if ($this->dryRun)
          continue;

        $targetIds[] = $this->clonePost($source, $title);
      }

      if (!$this->dryRun) {
        $targetValue['sticky'] = implode(',', array_unique($targetIds));
        update_field('downloads_kits', $targetValue, $targetKit->ID);
      }
    }

    \WP_CLI::log("\n== Files expected on B2 (bucket upasd-recursos):");
    foreach (array_unique($b2Paths) as $path)
      \WP_CLI::log('  ' . $path);

    \WP_CLI::success($this->dryRun ? 'Dry run finished.' : 'Done. New posts are drafts; publish them once the files are uploaded.');
  }

  private function clonePost($source, $title) {
    $newId = wp_insert_post([
      'post_type'    => $source->post_type,
      'post_status'  => 'draft',
      'post_title'   => $title,
      'post_name'    => sanitize_title($title),
      'post_content' => $source->post_content,
      'post_excerpt' => $source->post_excerpt,
      'post_author'  => $source->post_author,
    ], true);

    if (is_wp_error($newId))
      \WP_CLI::error($newId);

    foreach (get_object_taxonomies($source->post_type) as $taxonomy)
      wp_set_object_terms($newId, wp_get_object_terms($source->ID, $taxonomy, ['fields' => 'ids']), $taxonomy);

    // Copies featured image, Yoast primary terms and the ACF downloads repeater as-is.
    foreach (get_post_meta($source->ID) as $key => $values) {
      if (in_array($key, self::SKIP_META, true))
        continue;

      foreach ($values as $value) {
        $value = maybe_unserialize($value);

        if (preg_match('/^downloads_\d+_link$/', $key))
          $value = $this->swapQuarterInLink($value);

        add_post_meta($newId, $key, wp_slash($value));
      }
    }

    add_post_meta($newId, self::CLONED_FROM, $source->ID);

    return $newId;
  }

  private function findKit($group, $quarter) {
    foreach (get_posts(['post_type' => 'kit', 'post_status' => 'any', 'posts_per_page' => -1]) as $kit) {
      if (strpos($kit->post_title, $group) === 0 && preg_match('/\b' . $quarter . 'T\)$/', $kit->post_title))
        return $kit;
    }

    return null;
  }

  private function kitPostIds($kitId) {
    $value = get_field('downloads_kits', $kitId, false);

    return array_map('intval', array_filter(explode(',', $value['sticky'] ?? '')));
  }

  // source post ID => clone ID, for posts already in the target kit.
  private function clonedSources(array $ids) {
    $map = [];

    foreach ($ids as $id) {
      if ($from = get_post_meta($id, self::CLONED_FROM, true))
        $map[(int) $from] = (int) $id;
    }

    return $map;
  }

  private function newLinks($sourceId) {
    $rows = get_field('downloads', $sourceId, false) ?: [];

    return array_map(function ($row) {
      return $this->swapQuarterInLink($row['field_cec51b2d'] ?? '');
    }, $rows);
  }

  // "3T", "3.ºT", "3ºT" -> same form with the target quarter.
  private function swapQuarter($text) {
    return preg_replace('/(?<!\d)' . $this->from . '(\.º|º)?T(?![a-z])/u', $this->to . '$1T', $text);
  }

  // Folder segment "/3T/" plus "3T" / "3º" / "3_T" in the file name.
  private function swapQuarterInLink($url) {
    $url = str_replace('/' . $this->from . 'T/', '/' . $this->to . 'T/', $url);

    $dir  = substr($url, 0, strrpos($url, '/') + 1);
    $file = substr($url, strlen($dir));
    $name = preg_replace('/(?<!\d)' . $this->from . '(T|º|_T)/u', $this->to . '$1', rawurldecode($file));

    // Re-encode only when the name changed, so untouched links stay byte-identical.
    if ($name !== rawurldecode($file))
      $file = rawurlencode($name);

    return $dir . $file;
  }

  private function quarterNumber($quarter) {
    if (!preg_match('/^([1-4])T$/i', trim($quarter), $m))
      \WP_CLI::error("Invalid quarter \"$quarter\", expected 1T-4T.");

    return $m[1];
  }

}

\WP_CLI::add_command('vej-kits', 'PaCliVejKits');
