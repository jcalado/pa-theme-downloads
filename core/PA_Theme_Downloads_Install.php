<?php

/**
 * 
 * Bootloader Install
 * 
 */

class PAThemeDownloadsInstall {

	public function __construct() {
		add_action('after_setup_theme', array($this, 'installRoutines'), 11);
		add_action('widgets_init', array($this, 'setWidgets'), 11);
	}

	function installRoutines() {
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

    $labels = array(
			'name'                => __( 'Tipos de Materiais', 'iasd'),
			'singular_name'       => __( 'Tipo de Material', 'iasd'),
			'search_items'        => __( 'Buscar Tipo de Material', 'iasd'),
			'all_items'           => __( 'Todos os Tipos de Materiais', 'iasd'),
			'parent_item'         => __( 'Tipo Superior', 'iasd'),
			'parent_item_colon'   => __( 'Tipo Superior:', 'iasd'),
			'edit_item'           => __( 'Editar Tipo de Material', 'iasd' ),
			'update_item'         => __( 'Atualizar Tipo de Material', 'iasd'),
			'add_new_item'        => __( 'Adicionar Novo Tipo de Material', 'iasd'),
			'new_item_name'       => __( 'Nome do Tipo de Material', 'iasd'),
			'menu_name'           => __( 'Tipos de Materiais', 'iasd')
		);

		$args = array(
			'hierarchical'        => true,
			'labels'              => $labels,
			'show_ui'             => true,
			'show_admin_column'   => false,
			'query_var'           => true,
			'rewrite'             => array( 'slug' => __('tipo-material', 'iasd') ),
			'public'              => true,
		);

    register_taxonomy( 'xtt-pa-materiais', array('post'), $args );
	}

	function setWidgets() {
    unregister_sidebar('front-page');
		unregister_sidebar('index');
		unregister_sidebar('single');
	}
}

$PAThemeDownloadsInstall = new PAThemeDownloadsInstall();
