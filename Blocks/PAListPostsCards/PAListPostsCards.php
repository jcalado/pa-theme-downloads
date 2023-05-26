<?php

namespace Blocks\PAListPostsCards;

use Blocks\Block;
use ExtendedLocal\LocalData;
use Fields\MoreContent;
use Extended\ACF\ConditionalLogic;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\Text;

/**
 * Class PAListPostsCards
 * @package Blocks\PAListPostsCards
 */
class PAListPostsCards extends Block {

	public function __construct() {
		// Set block settings
		parent::__construct([
			'title'       => __('IASD - Posts - Cards', 'iasd'),
			'description' => __('Block to show posts contents in card list format.', 'iasd'),
			'category'    => 'pa-adventista',
			'keywords'    => ['list', 'posts', 'card'],
			'icon'        => 'list-view',
		]);

		add_filter('acf/fields/localposts_data/query/name=items_popular', array($this, 'filter'));
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
					->defaultValue(__('IASD - Posts - Cards', 'iasd'))
					->required(),

				ButtonGroup::make('Modo', 'mode')
					->choices([
						'latest' => __('Recents', 'iasd'),
						'popular' => __('Popular', 'iasd'),
					])
					->defaultValue('latest'),

        LocalData::make(__('Posts', 'iasd'), 'items_latest')
					->instructions(__('Select posts', 'iasd'))
					->postTypes(['post', 'kit'])
					->initialLimit(5)
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

        LocalData::make(__('Posts', 'iasd'), 'items_popular')
					->instructions(__('Select posts', 'iasd'))
					->postTypes(['post', 'kit'])
					->initialLimit(5)
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
		$mode = get_field('mode');

		return [
			'title'        => get_field('title'),
			'items'        => array_column(get_field("items_{$mode}")['data'], 'id'),
			'enable_link'  => get_field('enable_link'),
			'link'         => get_field('link'),
		];
	}
	
	function filter(array $args): array {
		$args['meta_key'] = 'views_count';
		$args['orderby']  = 'meta_value_num';
		$args['order']    = 'DESC';

		return $args;
	}

}
