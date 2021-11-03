<?php

if(file_exists($composer = __DIR__ . '/vendor/autoload.php'))
    require_once $composer;

define('PARENT_THEME_URI', get_template_directory_uri() . '/');
define('THEME_URI', get_stylesheet_directory_uri() . '/');
define('THEME_DIR', get_stylesheet_directory() . '/');
define('THEME_CSS', THEME_URI . 'assets/css/');
define('THEME_JS', THEME_URI . 'assets/js/');
define('THEME_IMGS', THEME_URI . 'assets/images/');

$ChildBlocks = new \Blocks\ChildBlocks;

add_filter('popular-posts/settings/url', function() {
    return THEME_URI . 'vendor/lordealeister/popular-posts/';
});

require_once(dirname(__FILE__) . '/classes/controllers/PA_ACF_PostFields.class.php');
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
    $path = explode('/', $template);
    $template_chosen = basename(end($path), '.php');
    $template_chosen = str_replace('.blade', '', $template_chosen);
    $grandchild_template = dirname(__FILE__) . '/' . $template_chosen . '.blade.php';

    if(file_exists($grandchild_template)):
        blade($template_chosen);
        return '';
    endif;

    return $template;
});

/**
* Modify category query
*/
add_action('pre_get_posts', function($query) {
    if(is_admin() || !is_tax() || !$query->is_main_query())
        return $query;

    global $queryFeatured;
    $object = get_queried_object();
    
    $queryFeatured = new WP_Query(
        array(
            'posts_per_page' => 1,
            'post_status'	 => 'publish',
            'post__in'       => get_option('sticky_posts'),
            'tax_query'      => array(
                array(
                    'taxonomy' => $object->taxonomy,
                    'terms'    => array($object->term_id),
                ),
            ),
        )
    );

    if(empty($queryFeatured->found_posts)):
        $queryFeatured = new WP_Query(
            array(
                'posts_per_page' 	   => 1,
                'post_status'	 	   => 'publish',
                'ignore_sticky_posts ' => true,
                'tax_query'            => array(
                    array(
                        'taxonomy' => $object->taxonomy,
                        'terms'    => array($object->term_id),
                    ),
                ),
            )
        );
    endif;

    $query->set('posts_per_page', 15);
    $query->set('ignore_sticky_posts', true);
    $query->set('post__not_in', !empty($queryFeatured->found_posts) ? array($queryFeatured->posts[0]->ID) : null);

    return $query;
});

/**
* Filter save post to get video length
*/
add_action('acf/save_post', function($post_id) {
    if(get_post_type($post_id) != 'post')
        return;

    $url = parse_url(get_field('video_url', $post_id, false));
    $host = '';
    $id = '';

    if(empty($url))
        return;

    if(str_contains($url['host'], 'youtube') || str_contains($url['host'], 'youtu.be')):
        $host = 'youtube';

        if(array_key_exists('query', $url)):
            parse_str($url['query'], $params);
            $id = $params['v'];
        else:
            $id = str_replace('/', '', $url['path']);
        endif;
    elseif(str_contains($url['host'], 'vimeo')):
        $host = 'vimeo';
        $parts = explode('/', $url['path']);
        $id = $parts[count($parts) - 1];
    endif;

    if(!empty($host) && !empty($id))
        getVideoLength($post_id, $host, $id);
});

add_filter('acf/fields/relationship/query', 'my_acf_fields_relationship_query', 10, 3);
function my_acf_fields_relationship_query( $args ) {

    $args['post_status'] = 'publish';

    return $args;
}

/**
* Remove unused taxonomies
*/
add_action('after_setup_theme', function() {
    // unregister_taxonomy_for_object_type('xtt-pa-colecoes', 'post');
    unregister_taxonomy_for_object_type('post_tag', 'post');
    unregister_taxonomy_for_object_type('category', 'post');
    unregister_taxonomy_for_object_type('xtt-pa-regiao', 'post');
    
    load_theme_textdomain('iasd', get_stylesheet_directory() . '/language/');
}, 9);

