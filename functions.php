<?php

if(file_exists($composer = __DIR__ . '/vendor/autoload.php'))
    require_once $composer;

define('PARENT_THEME_URI', get_template_directory_uri() . '/');
define('THEME_URI', get_stylesheet_directory_uri() . '/');
define('THEME_DIR', get_stylesheet_directory() . '/');
define('THEME_CSS', THEME_URI . 'assets/css/');
define('THEME_JS', THEME_URI . 'assets/js/');
define('THEME_IMGS', THEME_URI . 'assets/images/');

new \Blocks\ChildBlocks;

require_once(dirname(__FILE__) . '/classes/controllers/PA_ACF_Leaders.class.php');
require_once(dirname(__FILE__) . '/classes/controllers/PA_ACF_HomeFields.class.php');
require_once(dirname(__FILE__) . '/classes/controllers/PA_ACF_PostFields.class.php');
require_once(dirname(__FILE__) . '/classes/controllers/PA_ACF_UserFields.class.php');
require_once(dirname(__FILE__) . '/classes/controllers/PA_ACF_Site-ministries.class.php');
require_once(dirname(__FILE__) . '/classes/controllers/PA_CPT_Projects.class.php');
require_once(dirname(__FILE__) . '/classes/controllers/PA_CPT_Leaders.class.php');
require_once(dirname(__FILE__) . '/classes/controllers/PA_CPT_SliderHome.class.php');
require_once(dirname(__FILE__) . '/classes/controllers/PA_Enqueue_Files.class.php');
require_once(dirname(__FILE__) . '/classes/controllers/PA_Page_Lideres.php');
require_once(dirname(__FILE__) . '/classes/controllers/PA_Util.class.php');
require_once(dirname(__FILE__) . '/classes/controllers/PA_wp_rest_columnists_controller.class.php');
require_once(dirname(__FILE__) . '/classes/PA_Helpers.php');

// CORE INSTALL
require_once (dirname(__FILE__) . '/core/PA_Theme_Downloads_Install.php');

/**
* Remove unused taxonomies
*/
add_action('wp_loaded', function() {
    unregister_taxonomy_for_object_type('xtt-pa-colecoes', 'post');
    unregister_taxonomy_for_object_type('post_tag', 'post');
    unregister_taxonomy_for_object_type('category', 'post');
});

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
        $id = str_replace('/', '', $url['path']);
    endif;

    if(!empty($host) && !empty($id))
        getVideoLength($post_id, $host, $id);
});

// Make JavaScript Asynchronous in Wordpress
add_filter('script_loader_tag', function($tag, $handle) {
    $include = array('pa-child-script');

    if(is_admin() || !in_array($handle, $include))
        return $tag;

    $tag = str_replace(' src', ' defer src', $tag);

    return $tag;
}, 10, 2);


add_action('rest_api_init', function() {
	register_rest_field(
        array('post', 'press'), 
        'featured_media_url', array(
			'get_callback'    => 'featured_media_url_callback',
			'update_callback' => null,
			'schema'          => null,
		)
	);

    register_rest_field(
        array('post', 'press'),
        'terms', array(
            'get_callback'    => 'terms_callback',
            'update_callback' => null,
            'schema'          => null,
        )
    );

    register_rest_field('user', 'avatar', array(
            'get_callback'    => 'avatar_callback',
            'update_callback' => null,
            'schema'          => null,
        )
    );

    register_rest_field('user', 'column', array(
            'get_callback'    => 'column_callback',
            'update_callback' => null,
            'schema'          => null,
        )
    );
});

function featured_media_url_callback($post) {
	$img_id = get_post_thumbnail_id($post['id']);

	$img_scr = Array(
		'full'             => !empty($full    = wp_get_attachment_image_src($img_id, ''))             ? $full[0]    : '',
		'medium'           => !empty($medium  = wp_get_attachment_image_src($img_id, 'medium_large')) ? $medium[0]  : '',
		'small'            => !empty($small   = wp_get_attachment_image_src($img_id, 'thumbnail'))    ? $small[0]   : '',
		'pa-block-preview' => !empty($preview = wp_get_attachment_image_src($img_id, 'medium_large')) ? $preview[0] : '',
		'pa-block-render'  => !empty($render  = wp_get_attachment_image_src($img_id, 'medium_large')) ? $render[0]  : '',
	);

    return $img_scr;
}

function terms_callback($post) {
    return [
        'editorial' => !empty($editorial = getPostEditorial($post['id'])) ? $editorial->name : '',
        'format'    => !empty($format    = getPostFormat($post['id']))    ? $format->name    : '',
    ];
}

function avatar_callback($user) {
    $img_id = get_field('user_avatar', 'user_' . $user['id']);

    $img_scr = Array(
		'full'             => !empty($full    = wp_get_attachment_image_src($img_id, ''))             ? $full[0]    : '',
		'medium'           => !empty($medium  = wp_get_attachment_image_src($img_id, 'medium_large')) ? $medium[0]  : '',
		'small'            => !empty($small   = wp_get_attachment_image_src($img_id, 'thumbnail'))    ? $small[0]   : '',
		'pa-block-preview' => !empty($preview = wp_get_attachment_image_src($img_id, 'medium_large')) ? $preview[0] : '',
		'pa-block-render'  => !empty($render  = wp_get_attachment_image_src($img_id, 'medium_large')) ? $render[0]  : '',
	);

    return $img_scr;
}

function column_callback($user) {
    return [
        'name'    => !empty($name    = get_field('column_name',    'user_' . $user['id'])) ? $name    : '',
        'excerpt' => !empty($excerpt = get_field('column_excerpt', 'user_' . $user['id'])) ? $excerpt : '',
    ]; 
}

function filter_rest_post_query( $args, $request ) { 
    $params = $request->get_params(); 

    if(isset($params['pa-owner'])){
        $args['tax_query'][] = array(
            array(
                'taxonomy' => 'xtt-pa-owner',
                'field' => 'slug',
                'terms' => explode(',', $params['pa-owner']),
                'include_children' => false
            )
        );
    }
    
	if(isset($params['pa-departamento'])){
        $args['tax_query'][] = array(
            array(
                'taxonomy' => 'xtt-pa-departamentos',
                'field' => 'slug',
                'terms' => explode(',', $params['pa-departamento'])
            )
        );
    }
    
	if(isset($params['pa-projeto'])){
        $args['tax_query'][] = array(
            array(
                'taxonomy' => 'xtt-pa-projetos',
                'field' => 'slug',
                'terms' => explode(',', $params['pa-projeto'])
            )
        );
    }

	if(isset($params['pa-sede'])){
        $args['tax_query'][] = array(
            array(
                'taxonomy' => 'xtt-pa-sedes',
                'field' => 'slug',
                'terms' => explode(',', $params['pa-sede']),
                'include_children' => false
            )
        );
    }

	if(isset($params['pa-editoria'])){
        $args['tax_query'][] = array(
            array(
                'taxonomy' => 'xtt-pa-editorias',
                'field' => 'slug',
                'terms' => explode(',', $params['pa-editoria'])
            )
        );
    }

    return $args; 
}   
// add the filter 
add_filter('rest_post_query', 'filter_rest_post_query', 10, 2 );

add_filter('option_show_avatars', '__return_false');