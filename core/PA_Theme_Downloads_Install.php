<?php

use Log1x\AcfPhoneNumber\PhoneNumberField;

/**
 * 
 * Bootloader Install
 * 
 */

class PAThemeNoticiasInstall {

	public function __construct() {
		add_action('after_setup_theme', array($this, 'installRoutines'), 11);
		add_action('admin_enqueue_scripts', array($this, 'enqueueAssets'));
		add_action('after_setup_theme', array($this, 'removePostFormats'), 100);
		add_filter('manage_edit-press_columns', array($this, 'removeFakeColumn'));
		add_action('init', array($this, 'addCustomRoles'));
		add_action('widgets_init', array($this, 'setWidgets'), 11);
	}

	function installRoutines() {
		/**
		 * 
		 * SALA DE IMPRENSA
		 * 
		 */
		$labels = array(
			'name'                  => __( 'Press', 'iasd' ),
			'singular_name'         => __( 'Press', 'iasd' ),
			'menu_name'             => __( 'Press', 'Admin Menu text', 'iasd' ),
			'name_admin_bar'        => __( 'Add press', 'iasd' ),
			'add_new'               => __( 'Add New', 'iasd' ),
			'add_new_item'          => __( 'Add New press', 'iasd' ),
			'new_item'              => __( 'New press', 'iasd' ),
			'edit_item'             => __( 'Edit press', 'iasd' ),
			'view_item'             => __( 'View press', 'iasd' ),
			'all_items'             => __( 'All press', 'iasd' ),
			'search_items'          => __( 'Search press', 'iasd' ),
			'not_found'             => __( 'No press found.', 'iasd' ),
			'not_found_in_trash'    => __( 'No press found in Trash.', 'iasd' ),
		); 
			
		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array('slug' => 'press'),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => 4,
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt' ),
			// 'taxonomies'         => array( 'category', 'post_tag' ),
			'show_in_rest'       => true,
		);
			
		register_post_type(__('Press', 'iasd'), $args );

		/**
		 * 
		 * FORMATO DE POST
		 * 
		 */

		$labels = array(
		'name'              => __('Formatos de post'),
		'singular_name'     => __('Formato de post'),
		'search_items'      => __('Procurar formatos de post'),
		'all_items'         => __('Todas os formatos'),
		'edit_item'         => __('Editar formato de post'),
		'update_item'       => __('Atualizar formato de post'),
		'add_new_item'      => __('Adicionar novo formato de post'),
		'new_item_name'     => __('Novo formato de post'),
		'menu_name'         => __('Formatos de post'),
		);
		$args   = array(
			'hierarchical'       => true, // make it hierarchical (like categories)
			'labels'             => $labels,
			'show_ui'            => true,
			'show_admin_column'  => true,
			'show_in_quick_edit' => false,
			'query_var'          => true,
			'show_in_rest'       => true, // add support for Gutenberg editor
			'rewrite'            => ['slug' => 'xtt-pa-format'],
			'capabilities' 		  => array(
				'edit_terms' 	  => false,
				'delete_terms'    => false,
			),
		);

		register_taxonomy('xtt-pa-format', ['post', 'press'], $args);

		/**
		 * 
		 * FORMATO DE POST
		 * 
		 */

		$labels = array(
			'name'              => __('Press type'),
			'singular_name'     => __('Press type'),
			'search_items'      => __('Search items'),
			'all_items'         => __('All items'),
			'edit_item'         => __('Edit items'),
			'update_item'       => __('Update item'),
			'add_new_item'      => __('Add new item'),
			'new_item_name'     => __('New item'),
			'menu_name'         => __('Press type'),
		);
		$args = array(
			'hierarchical'       => true, // make it hierarchical (like categories)
			'labels'             => $labels,
			'show_ui'            => true,
			'show_admin_column'  => true,
			'show_in_quick_edit' => false,
			'query_var'          => true,
			'show_in_rest'       => true, // add support for Gutenberg editor
			'rewrite'            => ['slug' => 'xtt-pa-press-type'],
			'capabilities' 		  => array(
				'edit_terms' 	  => false,
				'delete_terms'    => false,
			),
		);
	
		register_taxonomy('xtt-pa-press-type', ['press'], $args);

		/**
		 * 
		 * REGIÃO
		 * 
		 */

		$labels = array(
			'name'          => __('Região'),
			'singular_name' => __('Região'),
			'search_items'  => __('Procurar regiões'),
			'all_items'     => __('Todas as região'),
			'edit_item'     => __('Editar região'),
			'update_item'   => __('Atualizar região'),
			'add_new_item'  => __('Adicionar nova região'),
			'new_item_name' => __('Nova região'),
			'menu_name'     => __('Regiões'),
		);

		$args   = array(
			'hierarchical'       => true, // make it hierarchical (like categories)
			'labels'             => $labels,
			'show_ui'            => true,
			'show_admin_column'  => true,
			'show_in_quick_edit' => false,
			'query_var'          => true,
			'show_in_rest'       => true, // add support for Gutenberg editor
			'rewrite'            => ['slug' => 'xtt-pa-regiao'],
			// 'capabilities' 		 => array(
			// 	'edit_terms' 	 => false,
			// 	'delete_terms'   => false,
			// ),
		);
	
		register_taxonomy('xtt-pa-regiao', ['post'], $args);

		register_taxonomy_for_object_type('xtt-pa-editorias', 'press');
	}

  	function enqueueAssets() {
		global $current_screen;

		if($current_screen->id != 'post' && $current_screen->id != 'edit-post')
			return;

		wp_enqueue_script(
			'adventistas-noticias-admin', 
			get_stylesheet_directory_uri() . '/assets/scripts/admin.js', 
			array('wp-i18n', 'wp-blocks', 'wp-edit-post', 'wp-element', 'wp-editor', 'wp-components', 'wp-data', 'wp-plugins', 'wp-edit-post', 'lodash'), 
			null, 
			false
		);
	}

	function removePostFormats() {
		remove_theme_support('post-formats');
	}

	function addCustomRoles() {
		if($GLOBALS['wp_roles']->is_role('columnist'))
			return;

		add_role(
			'columnist', 
			__('Colunista'), 
			array(
				'read' => true, // true allows this capability
			)
		);
	}

	function setWidgets() {
		register_sidebar(array(
			'name'          => __('Archive columnists', 'iasd'),
			'id'            => 'archive-authors',
			'before_widget' => '<div>',
			'after_widget'  => '</div>',
		));

		register_sidebar(array(
			'name'          => __('Columnist', 'iasd'),
			'id'            => 'author',
			'before_widget' => '<div>',
			'after_widget'  => '</div>',
		));

		register_sidebar(array(
			'name'          => __('Front press', 'iasd'),
			'id'            => 'front-press',
			'before_widget' => '<div>',
			'after_widget'  => '</div>',
		));

		unregister_sidebar('index');
		unregister_sidebar('single');
	}

	function removeFakeColumn($posts_columns) {
		unset($posts_columns['fake']);

		return $posts_columns;
	}

}

new PAThemeNoticiasInstall();
