<?php

use WordPlate\Acf\Fields\Number;
use WordPlate\Acf\Fields\Oembed;
use WordPlate\Acf\Fields\Text;
use WordPlate\Acf\Location;

class PaAcfPostFields {

    public function __construct() {
        add_action('init', [$this, 'createACFFields']);
    }

    function createACFFields() {
        register_extended_field_group([
            'title' => 'Informações do vídeo',
            'style' => 'default',
            'fields' => [
                Oembed::make('Vídeo', 'video_url')
                    ->required(),
                Number::make('Duração', 'video_length')
                    ->instructions('Será obtido ao salvar o post')
                    ->readOnly(),
            ],
            'location' => [
                Location::if('post_taxonomy', 'xtt-pa-format:video'),
            ]
        ]);

        register_extended_field_group([
            'title'      => 'Informações de autor',
            'style'      => 'default',
            'position'   => 'side',
            'fields'     => [
                Text::make('Autor', 'custom_author'),
            ],
            'location'   => [
                Location::if('post_type', 'post'),
            ]
        ]);
    }

}

new PaAcfPostFields();
