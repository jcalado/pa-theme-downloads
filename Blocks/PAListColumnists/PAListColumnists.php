<?php

namespace Blocks\PAListColumnists;

use Blocks\Block;
use Fields\MoreContent;
use WordPlate\Acf\Fields\Number;
use WordPlate\Acf\Fields\Text;

/**
 * Class PAListColumnists
 * @package Blocks\PAListColumnists
 */
class PAListColumnists extends Block {

    public function __construct() {
		// Set block settings
        parent::__construct([
            'title' 	  => __('IASD - List columnists', 'iasd'),
            'description' => __('List columnists', 'iasd'),
            'category' 	  => 'pa-adventista',
			'keywords' 	  => ['list', 'posts'],
			'icon' 		  => 'admin-users',
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
				Text::make('Título', 'title')
					->defaultValue(__('IASD - List columnists', 'iasd')),

				Number::make(__('Quantity', 'iasd'), 'count')
					->min(1)
					->defaultValue(4)
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
		add_action('pre_user_query', function($query) {
			if($query->get('id') == 'pa-list-columnists' && $query->query_vars['orderby'] == 'rand')
				$query->query_orderby = str_replace('user_login', 'RAND()', $query->query_orderby);
		});

		$query = new \WP_User_Query(
			array(
				'id'				  => 'pa-list-columnists',
				'role' 				  => 'columnist',
				'number' 			  => get_field('count'),
				'has_published_posts' => ['post'],
				'orderby'        	  => 'rand',
				'fields' 			  => 'ID',
			) 
		);

        return [
            'title'  	   => get_field('title'),
			'items' 	   => $query->results,
			'enable_link'  => get_field('enable_link'),
			'link'    	   => get_field('link'),
        ];
    }

}