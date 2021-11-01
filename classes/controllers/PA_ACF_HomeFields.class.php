<?php

use Extended\LocalData;
use WordPlate\Acf\Location;
use WordPlate\Acf\ConditionalLogic;
use WordPlate\Acf\Fields\ButtonGroup;

class PaAcfHomeFields {

    public function __construct() {
        add_action('init', [$this, 'init']);
    }

    function init() {
        $this->createACFFields('page-front-page.blade.php', 'post', ['xtt-pa-sedes', 'xtt-pa-editorias', 'xtt-pa-projetos']);
        $this->createACFFields('page-press-room.blade.php', 'press', []);
    }

    function createACFFields($template, $postType, $taxonomies) {
        register_extended_field_group([
            'title' => 'Destaques',
            'key'   => "featured_{$postType}",
            'style' => 'default',
            'fields' => [
                ButtonGroup::make('Modelo', 'featured_layout')
                    ->choices([
                        1 => '1 post',
                        2 => '2 posts',
                        3 => '3 posts',
                    ])
                    ->defaultValue(1),
                $this->relationshipField(1, $postType, $taxonomies),
                $this->relationshipField(2, $postType, $taxonomies),
                $this->relationshipField(3, $postType, $taxonomies),
            ],
            'location' => [
                Location::if('page_template', $template),
            ]
        ]);
    }

    protected function relationshipField($count = 1, $postType, $taxonomies) {
		$count = !empty($count) ? $count : 1;

		return
            LocalData::make(__('Featured posts', 'iasd'), "featured_items_{$count}")
                ->instructions("Selecione até {$count} post" . ($count > 1 ? 's' : '') ." de destaque")
                ->postTypes([$postType])
                ->initialLimit($count)
                ->filterTaxonomies($taxonomies)
                ->manualItems(false)
                ->limitFilter(false)
                ->conditionalLogic([
					ConditionalLogic::if('featured_layout')->equals($count)
				]);
	}

}

$PaAcfHomeFields = new PaAcfHomeFields();
