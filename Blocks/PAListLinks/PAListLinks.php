<?php

namespace Blocks\PAListLinks;

use Blocks\Block;
use Extended\ACF\Fields\Link;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Text;

/**
 * Class PAListLinks
 * @package Blocks\PAListLinks
 */
class PAListLinks extends Block {

	public function __construct() {
		// Set block settings
		parent::__construct([
			'title'       => __('IASD - List - Links', 'downloads'),
			'description' => __('Block to show links in list format.', 'downloads'),
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
      Text::make(__('Title', 'downloads'), 'title')
        ->defaultValue(__('IASD - List - Links', 'downloads'))
        ->required(),

      Repeater::make(__('Links', 'downloads'), 'items')
        ->min(1)
        ->buttonLabel(__('Add link', 'downloads'))
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
