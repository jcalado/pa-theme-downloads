<?php

class PaCptProjects {

	public function __construct(){
		add_action('init', [$this, 'CreatePostType']);
		add_action('init', [$this, 'RegisterSidebars']);
	}

	function CreatePostType() {
		$labels = array(
			'name'                  => _x( 'Projetos', 'Post Type General Name', 'pa_iasd' ),
			'singular_name'         => _x( 'Projeto', 'Post Type Singular Name', 'pa_iasd' ),
			'menu_name'             => __( 'Projetos', 'pa_iasd' ),
			'name_admin_bar'        => __( 'Projetos', 'pa_iasd' ),
			'archives'              => __( 'Projetos', 'pa_iasd' ),
			'attributes'            => __( 'Item Attributes', 'pa_iasd' ),
			'parent_item_colon'     => __( '', 'pa_iasd' ),
			'all_items'             => __( 'Todos os projetos', 'pa_iasd' ),
			'add_new_item'          => __( 'Adicionar novo projeto', 'pa_iasd' ),
			'add_new'               => __( 'Adicionar Novo', 'pa_iasd' ),
			'new_item'              => __( 'Novo', 'pa_iasd' ),
			'edit_item'             => __( 'Editar', 'pa_iasd' ),
			'update_item'           => __( 'Atualizar', 'pa_iasd' ),
			'view_item'             => __( 'Visualizar projeto', 'pa_iasd' ),
			'view_items'            => __( 'Visualizar projetos', 'pa_iasd' ),
			'search_items'          => __( 'Buscar projetos', 'pa_iasd' ),
			'not_found'             => __( 'Não encontrado', 'pa_iasd' ),
			'not_found_in_trash'    => __( 'Não encontrado na lixeira', 'pa_iasd' ),
			'featured_image'        => __( 'Imagem destacada', 'pa_iasd' ),
			'set_featured_image'    => __( 'Adicionar imagem destacada', 'pa_iasd' ),
			'remove_featured_image' => __( 'Remover imagem destacada', 'pa_iasd' ),
			'use_featured_image'    => __( 'Usar como imagem destacada', 'pa_iasd' ),
			'insert_into_item'      => __( 'Inserir no item', 'pa_iasd' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'pa_iasd' ),
			'items_list'            => __( 'Items list', 'pa_iasd' ),
			'items_list_navigation' => __( 'Items list navigation', 'pa_iasd' ),
			'filter_items_list'     => __( 'Filter items list', 'pa_iasd' ),
		);
		$args = array(
			'label'                 => __( 'Projeto', 'pa_iasd' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'page',
			'show_in_rest'          => true,
		);
		register_post_type( 'projetos', $args );
	}


	function RegisterSidebars() {
		$projetos = query_posts( array('post_type' => 'projetos') );
		foreach($projetos as $projeto) {
			$slug = $projeto->post_name;
			register_sidebar( array(
				'name'	=> __('Projeto - '.$projeto->post_title.'', 'pa_iasd'),
				'id'	=> 'projeto-'.$slug,
				'before_widget' => '<div class="pa-widget %2$s col">',
				'after_widget'  => '</div>',
				'before_title'  => '<h2>',
				'after_title'   => '</h2>',
			) );
		}
		wp_reset_query();
	}
}

$PaCptProjects = new PaCptProjects();
