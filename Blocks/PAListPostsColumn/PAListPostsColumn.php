<?php

namespace Blocks\PAListPostsColumn;

use Blocks\Block;
use ExtendedLocal\LocalData;
use Fields\MoreContent;
use Extended\ACF\ConditionalLogic;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\Text;

/**
 * Class PAListPostsColumn
 * @package Blocks\PAListPostsColumn
 */
class PAListPostsColumn extends Block {

	public function __construct() {
		// Set block settings
		parent::__construct([
			'title'       => __('IASD - Posts - List(B)', 'downloads'),
			'description' => __('Block to show posts contents in list format.', 'downloads'),
			'category'    => 'pa-adventista',
			'keywords'    => ['list', 'posts'],
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
				Text::make(__('Title', 'downloads'), 'title')
					->defaultValue(__('IASD - Posts - List(B)', 'downloads'))
					->required(),

				ButtonGroup::make('Modo', 'mode')
					->choices([
						'latest' => __('Recents', 'downloads'),
						'popular' => __('Popular', 'downloads'),
					])
					->defaultValue('latest'),

					LocalData::make(__('Posts', 'downloads'), 'items_latest')
					->instructions(__('Select posts', 'downloads'))
					->postTypes(['post'])
					->initialLimit(4)
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
					->initialLimit(4)
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
			'items'        => !empty($items = get_field("items_{$mode}")) && array_key_exists('data', $items) ? array_column($items['data'], 'id') : null,
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
