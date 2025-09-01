<?php

namespace Blocks\PACarouselPosts;

use Blocks\Block;
use ExtendedLocal\LocalData;
use Extended\ACF\ConditionalLogic;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\Text;

/**
 * Class PACarouselPosts
 * @package Blocks\PACarouselPosts
 */
class PACarouselPosts extends Block {

  public function __construct() {
    // Set block settings
    parent::__construct([
      'title' 	  => __('IASD - Carousel - Posts', 'downloads'),
      'description' => __('Block from downloads content on carousel format.', 'downloads'),
      'category' 	  => 'pa-adventista',
      'keywords' 	  => ['app', 'posts'],
      'icon' 		  => 'download',
    ]);

    add_filter('acf/fields/localposts_data/query/name=items_popular', array($this, 'filter'));
  }
	
	/**
	 * setFields Register ACF fields with WordPlate/Acf lib
	 *
	 * @return array Fields array
	 */
	protected function setFields(): array {
		return [
			Text::make(__('Title', 'downloads'), 'title')
        ->defaultValue('IASD - Carrosel de posts'),

			ButtonGroup::make('Modo', 'mode')
				->choices([
					'latest' => __('Recents', 'downloads'),
					'popular' => __('Popular', 'downloads'),
				])
				->defaultValue('latest'),

      LocalData::make(__('Posts', 'downloads'), 'items_latest')
        ->instructions(__('Select posts', 'downloads'))
        ->postTypes(['post'])
        ->initialLimit(10)
        ->manualItems(false)
        ->filterTaxonomies([
          'xtt-pa-sedes',
          'xtt-pa-projetos',
          'xtt-pa-departamentos',
          'xtt-pa-colecoes',
          'xtt-pa-editorias',  
        ])
        ->conditionalLogic([
          ConditionalLogic::where('mode', '==', 'latest')
        ]),

      LocalData::make(__('Posts', 'downloads'), 'items_popular')
        ->instructions(__('Select posts', 'downloads'))
        ->postTypes(['post'])
        ->initialLimit(10)
        ->manualItems(false)
        ->filterTaxonomies([
          'xtt-pa-sedes',
          'xtt-pa-projetos',
          'xtt-pa-departamentos',
          'xtt-pa-colecoes',
          'xtt-pa-editorias', 
        ])
        ->conditionalLogic([
          ConditionalLogic::where('mode', '==', 'popular')
        ]),
		];
	}
	    
  /**
	 * with Inject fields values into template
	 *
	 * @return array
	 */
	public function with(): array {
    $mode = get_field('mode');

    return [
      'title'	=> get_field('title'),
      'items'	=> !empty($items = get_field("items_{$mode}")) && array_key_exists('data', $items) ? array_column($items['data'], 'id') : null,
    ];
  }

  function filter(array $args): array {
    $args['meta_key'] = 'views_count';
    $args['orderby']  = 'meta_value_num';
    $args['order']    = 'DESC';

    return $args;
  }
}
