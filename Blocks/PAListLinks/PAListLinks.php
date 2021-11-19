<?php

namespace Blocks\PAListLinks;

use Blocks\Block;
use WordPlate\Acf\Fields\Link;
use WordPlate\Acf\Fields\Repeater;
use WordPlate\Acf\Fields\Text;

/**
 * Class PAListLinks
 * @package Blocks\PAListLinks
 */
class PAListLinks extends Block {

	public function __construct() {
		// Set block settings
		parent::__construct([
			'title'       => __('IASD - List - Links', 'iasd'),
			'description' => __('Block to show links in list format.', 'iasd'),
			'category'    => 'pa-adventista',
			'keywords'    => ['list', 'links'],
			'icon'        => 'list-view',
		]);
	}

	/**
	 * setFields Register ACF fields with WordPlate/Acf lib
	 *
	 * @return array Fields array
	 */
	protected function setFields(): array {
		return [
      Text::make(__('Title', 'iasd'), 'title')
        ->defaultValue(__('IASD - List - Links', 'iasd'))
        ->required(),

      Repeater::make(__('Links', 'iasd'), 'items')
        ->min(1)
        ->buttonLabel(__('Add link', 'iasd'))
        ->layout('block')
        ->fields([
          Link::make('', 'link')
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
			'title'        => get_field('title'),
			'items'        => get_field('items'),
		];
	}

}
