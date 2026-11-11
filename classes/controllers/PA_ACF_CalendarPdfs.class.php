<?php

use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Url;
use Extended\ACF\Location;

/**
 * Editable list of PDF links shown in the "PDF" dropdown of the events calendar bar
 * (tribe/events/v2/components/events-bar/views/list.php).
 */
class PaAcfCalendarPdfs
{
  const PAGE_SLUG = 'calendar_pdfs';
  const FIELD     = 'calendar_pdfs';

  /**
   * Used while the option has no rows (e.g. right after deploy).
   */
  const FALLBACK = [
    ['label' => 'Atividades',           'url' => 'https://s3.eu-central-003.backblazeb2.com/upasd-recursos/comunicacao/calendarios/2026/Datas%20e%20Plano%20Ac%CC%A7a%CC%83o%20UPASD%20%202026.pdf'],
    ['label' => 'Datas Sugestivas',     'url' => 'https://s3.eu-central-003.backblazeb2.com/upasd-recursos/comunicacao/calendarios/2026/Datas%20Sugestivas%20UPASD%202026.pdf'],
    ['label' => 'RTP 2 / RTP Antena 1', 'url' => 'https://s3.eu-central-003.backblazeb2.com/upasd-recursos/comunicacao/calendarios/2026/RTP.pdf'],
    ['label' => 'Oração',               'url' => 'https://s3.eu-central-003.backblazeb2.com/upasd-recursos/ministerial/calendarios/2026/Ora%C3%A7%C3%A3o.pdf'],
  ];

  public function __construct()
  {
    add_action('acf/init', [$this, 'addOptionsPage']);
    add_action('acf/init', [$this, 'createAcfFields']);
  }

  function addOptionsPage()
  {
    acf_add_options_sub_page([
      'page_title'  => __('Calendar PDFs', 'downloads'),
      'menu_title'  => __('Calendar PDFs', 'downloads'),
      'menu_slug'   => self::PAGE_SLUG,
      'parent_slug' => 'edit.php?post_type=tribe_events',
      'capability'  => 'edit_others_posts',
    ]);
  }

  function createAcfFields()
  {
    register_extended_field_group([
      'title'  => __('Calendar PDFs', 'downloads'),
      'key'    => 'calendar_pdfs_settings',
      'style'  => 'default',
      'fields' => [
        Repeater::make(__('Links', 'downloads'), self::FIELD)
          ->instructions(__('Links shown in the "PDF" menu of the events calendar. If empty, the built-in 2026 links are shown.', 'downloads'))
          ->buttonLabel(__('Add PDF', 'downloads'))
          ->layout('table')
          ->fields([
            Text::make(__('Label', 'downloads'), 'label')->required(),
            Url::make(__('URL', 'downloads'), 'url')->required(),
          ]),
      ],
      'location' => [
        Location::where('options_page', self::PAGE_SLUG),
      ],
    ]);
  }

  /**
   * @return array<int, array{label: string, url: string}>
   */
  public static function getLinks(): array
  {
    $rows = function_exists('get_field') ? get_field(self::FIELD, 'option') : null;

    $links = array_values(array_filter((array) $rows, function ($row) {
      return is_array($row) && !empty($row['label']) && !empty($row['url']);
    }));

    return $links ?: self::FALLBACK;
  }
}

$PaAcfCalendarPdfs = new PaAcfCalendarPdfs();
