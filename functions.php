<?php

if (file_exists($composer = __DIR__ . '/vendor/autoload.php'))
  require_once $composer;

define('PARENT_THEME_URI', get_template_directory_uri() . '/');
define('THEME_URI', get_stylesheet_directory_uri() . '/');
define('THEME_DIR', get_stylesheet_directory() . '/');
define('THEME_CSS', THEME_URI . 'assets/css/');
define('THEME_JS', THEME_URI . 'assets/js/');
define('THEME_IMGS', THEME_URI . 'assets/images/');
define('ACF_TO_REST_API_REQUEST_VERSION', 2);

$ChildBlocks = new \Blocks\ChildBlocks;

add_filter('popular-posts/settings/url', function () {
  return THEME_URI . 'vendor/lordealeister/popular-posts/';
});

//add_action('init', array('ACF_To_REST_API', 'init'));

require_once(dirname(__FILE__) . '/vendor/lordealeister/popular-posts/popular-posts.php');
require_once(dirname(__FILE__) . '/core/PA_Theme_Downloads_Install.php');
require_once(dirname(__FILE__) . '/classes/controllers/PA_ACF_PostFields.class.php');
require_once(dirname(__FILE__) . '/classes/controllers/PA_ACF_Site_Downloads-settings.class.php');
require_once(dirname(__FILE__) . '/classes/controllers/PA_ACF_KitFields.class.php');
require_once(dirname(__FILE__) . '/classes/controllers/PA_Ajax.class.php');
require_once(dirname(__FILE__) . '/classes/controllers/PA_EnqueueFiles.class.php');
require_once(dirname(__FILE__) . '/classes/controllers/PA_Util.class.php');
require_once(dirname(__FILE__) . '/classes/controllers/PA_RewriteRules.class.php');
require_once(dirname(__FILE__) . '/classes/PA_Helpers.php');

add_filter('blade/view/paths', function ($paths) {
  $paths = (array)$paths;

  $paths[] = get_stylesheet_directory();

  return $paths;
});

add_filter('template_include', function ($template) {
  if (is_singular('kit') && file_exists(dirname(__FILE__) . '/single-kit.blade.php')) :
    blade('single-kit');
    return '';
  endif;

  $path = explode('/', $template);
  $template_chosen = basename(end($path), '.php');
  $template_chosen = str_replace('.blade', '', $template_chosen);
  $grandchild_template = dirname(__FILE__) . '/' . $template_chosen . '.blade.php';

  if (file_exists($grandchild_template)) :
    blade($template_chosen);
    return '';
  endif;

  return $template;
});

/**
 * Modify category query
 */
add_action('pre_get_posts', function ($query) {
  if (is_admin() || !$query->is_main_query() || !$query->is_archive)
    return $query;

  $query->set('posts_per_page', 10);

  return $query;
}, 11);

add_filter('acf/fields/relationship/query', 'my_acf_fields_relationship_query', 10, 3);
function my_acf_fields_relationship_query($args)
{

  $args['post_status'] = 'publish';

  return $args;
}

/**
 * Remove unused taxonomies
 */
add_action('after_setup_theme', function () {
  // unregister_taxonomy_for_object_type('xtt-pa-colecoes', 'post');
  unregister_taxonomy_for_object_type('post_tag', 'post');
  unregister_taxonomy_for_object_type('category', 'post');
  unregister_taxonomy_for_object_type('xtt-pa-regiao', 'post');

  load_theme_textdomain('iasd', get_stylesheet_directory() . '/language/');
}, 9);


add_action('acf/save_post', 'set_post_default_category');

function set_post_default_category($post_id)
{

  //Only set for post_type = post!
  if (get_post_type($post_id) == 'post') {
    if (have_rows('downloads', $post_id)) {
      while (have_rows('downloads', $post_id)) {
        the_row();

        $download = get_sub_field('link');
        //Isso foi preciso porque o link "http://deptos.adventistas.org.s3.amazonaws.com..." não valida o certificado e não efetua o download em uma nova aba. 
        if (strpos($download, 'http://deptos.adventistas.org.s3.amazonaws.com') !== false) {
          $link = str_replace('http://deptos.adventistas.org.s3.amazonaws.com', 'https://deptos.adventistas.org', $download);
          update_sub_field('link', $link);
        }

        if (strpos($download, 'http://deptos.adventistas.org.s3.us-east-1.amazonaws.com') !== false) {
          $link = str_replace('http://deptos.adventistas.org.s3.us-east-1.amazonaws.com', 'https://deptos.adventistas.org', $download);
          update_sub_field('link', $link);
        }
      }
    }
  }
}
