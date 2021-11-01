<?php

use WordPlate\Acf\Fields\Image;
use WordPlate\Acf\Fields\Url;
use WordPlate\Acf\Fields\Text;
use WordPlate\Acf\Fields\ColorPicker;
use WordPlate\Acf\Location;

class PaCptSliderHome {

	public function __construct(){
		add_action('init', [$this, 'CreatePostType']);
		add_action('init', [$this, 'CreateACFFields']);
	}

	function CreatePostType() {
		$labels = array(
			'name'                  => _x( 'Sliders', 'Post Type General Name', 'pa_iasd' ),
			'singular_name'         => _x( 'Slider', 'Post Type Singular Name', 'pa_iasd' ),
			'menu_name'             => __( 'Sliders', 'pa_iasd' ),
			'name_admin_bar'        => __( 'Sliders', 'pa_iasd' ),
			'archives'              => __( 'Sliders', 'pa_iasd' ),
			'attributes'            => __( 'Item Attributes', 'pa_iasd' ),
			'parent_item_colon'     => __( '', 'pa_iasd' ),
			'all_items'             => __( 'Todos os Sliders', 'pa_iasd' ),
			'add_new_item'          => __( 'Adicionar novo Slider', 'pa_iasd' ),
			'add_new'               => __( 'Adicionar Novo', 'pa_iasd' ),
			'new_item'              => __( 'Novo', 'pa_iasd' ),
			'edit_item'             => __( 'Editar', 'pa_iasd' ),
			'update_item'           => __( 'Atualizar', 'pa_iasd' ),
			'view_item'             => __( 'Visualizar Slider', 'pa_iasd' ),
			'view_items'            => __( 'Visualizar Sliders', 'pa_iasd' ),
			'search_items'          => __( 'Buscar Sliders', 'pa_iasd' ),
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
			'label'                 => __( 'Slider', 'pa_iasd' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'revisions' ),
			'hierarchical'          => false,
			'public'                => false,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => false,
			'exclude_from_search'   => true,
			'publicly_queryable'    => false,
			'capability_type'       => 'page',
			'show_in_rest'          => true,
		);
		register_post_type( 'sliders', $args );
	}

	function CreateACFFields(){
		register_extended_field_group([
			'title' => 'Slider-home',
			'style' => 'default',
			'fields' => [
				Image::make('Imagem Desktop', 'slider_img_desktop')
					->mimeTypes(['jpg', 'jpeg', 'png'])
					->library('all') // all or uploadedTo
					->returnFormat('url') // id, url or array (default)
					->previewSize('medium'), // thumbnail, medium or large
				Image::make('Imagem Mobile', 'slider_img_mobile')
					->mimeTypes(['jpg', 'jpeg', 'png'])
					->library('all') // all or uploadedTo
					->returnFormat('url') // id, url or array (default)
					->previewSize('medium'), // thumbnail, medium or large
				Text::make('Linha 1 - Texto', 'slider_text_01'),
				Text::make('Linha 2 - Texto', 'slider_text_02'),
				Text::make('Linha 3 - Texto', 'slider_text_03'),
				ColorPicker::make('Botão - Texto - Color', 'slider_button_text_color')
					->defaultValue('#ffffff'),
				ColorPicker::make('Botão - Cor', 'slider_button_color')
					->defaultValue('#003366'),
				Url::make('Botão - URL', 'slider_button_url'),
			],
			'location' => [
				Location::if('post_type', 'sliders'),
			],
		]);
	}
}

$PaCptSliderHome = new PaCptSliderHome();
