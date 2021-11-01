<?php

use WordPlate\Acf\Fields\Text;
use WordPlate\Acf\Fields\Textarea;
use WordPlate\Acf\Fields\Group;
use WordPlate\Acf\Fields\Url;
use WordPlate\Acf\Fields\Email;
use WordPlate\Acf\Fields\Image;
use WordPlate\Acf\Fields\Repeater;
use WordPlate\Acf\Location;


class PaCptLideres {

	public function __construct(){
		add_action('init', [$this, 'CreatePostType']);
		add_action('init', [$this, 'CreateACFFields']);
	}

	function CreatePostType() {
		$labels = array(
			'name'                  => _x( 'Líderes', 'Post Type General Name', 'pa_iasd' ),
			'singular_name'         => _x( 'Líder', 'Post Type Singular Name', 'pa_iasd' ),
			'menu_name'             => __( 'Líderes', 'pa_iasd' ),
			'name_admin_bar'        => __( 'Líderes', 'pa_iasd' ),
			'archives'              => __( 'Líderes', 'pa_iasd' ),
			'attributes'            => __( 'Item Attributes', 'pa_iasd' ),
			'parent_item_colon'     => __( '', 'pa_iasd' ),
			'all_items'             => __( 'Todos os lideres', 'pa_iasd' ),
			'add_new_item'          => __( 'Adicionar novo líder', 'pa_iasd' ),
			'add_new'               => __( 'Adicionar Novo', 'pa_iasd' ),
			'new_item'              => __( 'Novo', 'pa_iasd' ),
			'edit_item'             => __( 'Editar', 'pa_iasd' ),
			'update_item'           => __( 'Atualizar', 'pa_iasd' ),
			'view_item'             => __( 'Visualizar líder', 'pa_iasd' ),
			'view_items'            => __( 'Visualizar lideres', 'pa_iasd' ),
			'search_items'          => __( 'Buscar lideres', 'pa_iasd' ),
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
			'label'                 => __( 'Líder', 'pa_iasd' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'thumbnail', 'revisions' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => false,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'page',
			'show_in_rest'          => true,
		);
		register_post_type( 'lideres', $args );
	}

	function CreateACFFields(){
		register_extended_field_group([
			'title' => 'Leaders',
			'style' => 'default',
			'fields' => [
				Text::make('Cargo/Campo', 'lider_cargo'),
				Textarea::make('Bibliografia', 'lider_bibliografia')
					->newLines('br') // br or wpautop
					->rows(8),
				Group::make('Redes Sociais', 'lider_redes_sociais')
					->fields([
						Url::make('Facebook', 'lider_facebook'),
						Url::make('Twitter', 'lider_twitter'),
						Url::make('Instagram', 'lider_instagram'),
						Email::make('E-mail', 'lider_email')
					])
					->layout('block'),
				Repeater::make('Equipe', 'lider_equipe')
					->fields([
						Text::make('Nome', 'lider_equipe_nome'),
						Text::make('Cargo', 'lider_equipe_cargo'),
						Image::make('Foto', 'lider_equipe_foto')
							->library('all') // all or uploadedTo
							->height(300)
    						->width(300)
							->returnFormat('array') // id, url or array (default)
							->previewSize('medium'), // thumbnail, medium or large
						Email::make('E-mail', 'lider_equipe_email'),
						Text::make('Telefone', 'lider_equipe_telefone'),
					])
					->buttonLabel('Adicionar membro')
					->layout('table') // block, row or table
			],
			'location' => [
				Location::if('post_type', 'lideres'),
			],
		]);
	}
}

$PaCptLideres = new PaCptLideres();
