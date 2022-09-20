<?php

/**
 * 
 * Bootloader Install
 * 
 */

class PAThemeDownloadsInstall
{

  public function __construct()
  {
    add_action('after_setup_theme', array($this, 'installRoutines'), 11);
    add_action('widgets_init', array($this, 'setWidgets'), 11);
    add_action('rest_api_init', array($this, 'adding_rest_field'));
  }

  function installRoutines()
  {
    /**
     * 
     * KITS
     * 
     */
    $labels = array(
      'singular_name'         => __('Kit', 'iasd'),
      'name'                  => __('Kits', 'iasd'),
      'menu_name'             => __('Kits', 'Admin Menu text', 'iasd'),
      'name_admin_bar'        => __('Add kit', 'iasd'),
      'add_new'               => __('Add New', 'iasd'),
      'add_new_item'          => __('Add New kit', 'iasd'),
      'new_item'              => __('New kit', 'iasd'),
      'edit_item'             => __('Edit kit', 'iasd'),
      'view_item'             => __('View kit', 'iasd'),
      'all_items'             => __('All kits', 'iasd'),
      'search_items'          => __('Search kit', 'iasd'),
      'not_found'             => __('No kit found.', 'iasd'),
      'not_found_in_trash'    => __('No kit found in Trash.', 'iasd'),
    );

    $args = array(
      'labels'             => $labels,
      'public'             => true,
      'publicly_queryable' => true,
      'show_ui'            => true,
      'show_in_menu'       => true,
      'query_var'          => true,
      'rewrite'            => array('slug' => 'kits'),
      'capability_type'    => 'post',
      'has_archive'        => true,
      'hierarchical'       => false,
      'menu_position'      => 4,
      'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt'),
      'show_in_rest'       => true,
    );

    register_post_type('kit', $args);

    register_taxonomy_for_object_type('xtt-pa-projetos', 'kit');
    register_taxonomy_for_object_type('xtt-pa-departamentos', 'kit');
    register_taxonomy_for_object_type('xtt-pa-owner', 'kit');
  }

  function setWidgets()
  {
    unregister_sidebar('front-page');
    unregister_sidebar('index');
    unregister_sidebar('single');
  }

  function adding_rest_field()
  {

    register_rest_field(
      'kit',
      'featured_media_url',
      array(
        'get_callback' => function ($post) {
          $img_id = get_post_thumbnail_id($post['id']);

          return array(
            'pa-block-render' => wp_get_attachment_image_src($img_id, 'medium')[0]
          );
        },
        'update_callback'   => null,
        'schema'            => null,
      )
    );
  }
}

$PAThemeDownloadsInstall = new PAThemeDownloadsInstall();
