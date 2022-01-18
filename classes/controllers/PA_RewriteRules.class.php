<?php

class PaRewriteRules
{
  public function __construct()
  {
    add_action('init', [$this, 'rewritePost'], 100);
    add_filter('pre_post_link', [$this, 'PrePostLink'], 10, 3);
  }

  public static function rewritePost()
  {
    $permalink = '%xtt-pa-departamentos%/%xtt-pa-materiais%/%postname%/';
    $permalink = str_replace('%xtt-pa-departamentos%', '([^/]+)', $permalink);
    $permalink = str_replace('%xtt-pa-materiais%', '([^/]+)', $permalink);
    $permalink = str_replace('%postname%', '([^/]+)', $permalink);
    $permalink .= '?$';
    $rewrite_redirect = 'index.php?name=$matches[3]&post_type=post&xtt-pa-departamentos=$matches[1]&xtt-pa-materiais=$matches[2]';
    $permalink = add_rewrite_rule($permalink, $rewrite_redirect, 'top');
    flush_rewrite_rules();
  }

  public static function PrePostLink($permalink, $post)
  {
    if (is_object($post) && $post->post_type == 'post') {
      $original = get_option('permalink_structure');
      if ($permalink == $original) {
        $material = get_the_terms($post->ID, 'xtt-pa-materiais');
        if (!is_wp_error($material)) {
          $material = $material[0]->slug;
          $departamento = get_the_terms($post->ID, 'xtt-pa-departamentos');
          $departamento = $departamento[0]->slug;
          $permalink = str_replace('/%postname%/', $departamento . '/' . $material . '/%postname%/', $permalink);
          // die(var_dump($permalink));
        }
      }
    }

    return $permalink;
  }
}
$PaRewriteRules = new PaRewriteRules();
