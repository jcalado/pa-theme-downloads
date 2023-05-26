<?php

namespace Blocks\PAFeaturePost;

use Blocks\Block;
use Extended\ACF\Fields\Text;
use Extended\LocalData;

/**
 * Class PAFeaturePost
 * @package Blocks\PAFeaturePost
 */
class PAFeaturePost extends Block {

	public function __construct() {
		parent::__construct([
			'title' 	    => __('IASD - Downloads - Feature', 'iasd'),
			'description' => __('Block to show a single post content on feature format.', 'iasd'),
			'category' 	  => 'pa-adventista',
			'post_types'  => ['post', 'page'],
			'keywords' 	  => ['featured'],
			'icon' 		    => '<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="thumbtack" 
                          class="svg-inline--fa fa-thumbtack fa-w-12" role="img" xmlns="http://www.w3.org/2000/svg" 
                          viewBox="0 0 384 512"><path fill="currentColor" d="M298.028 214.267L285.793 96H328c13.255 0 24-10.745 24-24V24c0-13.255-10.745-24-24-24H56C42.745 
                          0 32 10.745 32 24v48c0 13.255 10.745 24 24 24h42.207L85.972 214.267C37.465 236.82 0 277.261 0 328c0 13.255 10.745 24 24 24h136v104.007c0 1.242.289 
                          2.467.845 3.578l24 48c2.941 5.882 11.364 5.893 14.311 0l24-48a8.008 8.008 0 0 0 .845-3.578V352h136c13.255 0 24-10.745 24-24-.001-51.183-37.983-91.42-85.973-113.733z"></path></svg>',
		]);
	}

	/**
	 * set ACF Field
	 *
	 * @return array Fields array
	 */
	protected function setFields(): array {
		return [
      Text::make(__('Title', 'iasd'), 'title')
        ->defaultValue(__('Feature', 'iasd')),

      LocalData::make(__('Posts', 'iasd'), 'items')
				->instructions(__('Select posts', 'iasd'))
        ->postTypes(['post'])
        ->initialLimit(10)
        ->manualItems(false)
        ->limitFilter(false)
        ->canSticky(true)
        ->filterTaxonomies([
					'xtt-pa-sedes',
					'xtt-pa-projetos',
					'xtt-pa-departamentos',
					'xtt-pa-colecoes',
					'xtt-pa-editorias', 
        ]),
		];
	}

	/**
	 * with Inject fields values into template
	 *
	 * @return array
	 */
	public function with(): array {
		return [
			'title'	=> get_field('title'),
			'id'	=> !empty($items = get_field('items')) && array_key_exists('data', $items) ? $items['data'][0]['id'] : null,
		];
	}
}
