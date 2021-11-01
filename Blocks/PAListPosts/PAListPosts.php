<?php

namespace Blocks\PAListPosts;

use Blocks\Block;
use Extended\LocalData;
use Fields\MoreContent;
use WordPlate\Acf\Fields\Text;

/**
 * Class PAListPosts
 * @package Blocks\PAListPosts
 */
class PAListPosts extends Block {

    public function __construct() {
		// Set block settings
        parent::__construct([
            'title' 	  => __('IASD - Posts list', 'iasd'),
            'description' => __('Posts list', 'iasd'),
            'category' 	  => 'pa-adventista',
			'keywords' 	  => ['list', 'posts'],
			'icon' 		  => 'megaphone',
        ]);
    }
	
	/**
	 * setFields Register ACF fields with WordPlate/Acf lib
	 *
	 * @return array Fields array
	 */
	protected function setFields(): array {
		return array_merge(
			[
				Text::make(__('Title', 'iasd'), 'title')
					->defaultValue('IASD - Lista posts'),

				LocalData::make('Posts', 'items')
					->postTypes(['post'])
					->manualItems(false)
					->initialLimit(4)
					->filterTaxonomies(['xtt-pa-sedes', 'xtt-pa-editorias', 'xtt-pa-projetos'])
			],
			MoreContent::make()
		);
	}
	    
    /**
     * with Inject fields values into template
     *
     * @return array
     */
    public function with(): array {
        return [
            'title'  	   => get_field('title'),
			'items' 	   => array_column(get_field('items')['data'], 'id'),
			'enable_link'  => get_field('enable_link'),
			'link'    	   => get_field('link'),
        ];
    }

}