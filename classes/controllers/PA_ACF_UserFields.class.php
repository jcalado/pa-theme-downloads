<?php

use WordPlate\Acf\Location;
use WordPlate\Acf\Fields\Image;
use WordPlate\Acf\Fields\Text;
use WordPlate\Acf\Fields\Textarea;
use WordPlate\Acf\Fields\Url;

class PaAcfUserFields {

    public function __construct() {
        add_action('init', [$this, 'createACFFields']);
    }

    function createACFFields() {
        register_extended_field_group([
            'title'  => 'Informações adicionais',
            'style'  => 'default',
            'fields' => [
                Image::make('Avatar', 'user_avatar')
                    ->returnFormat('id')
                    ->required(),
                Url::make('Facebook', 'facebook'),
                Url::make('Twitter', 'twitter'),
                Url::make('Instagram', 'instagram'),
            ],
            'location' => [
                Location::if('user_form', 'edit'),
            ]
        ]);

        register_extended_field_group([
            'title'  => 'Informações de coluna',
            'style'  => 'default',
            'fields' => [
                Text::make('Nome', 'column_name')
                    ->required(),
                Textarea::make('Resumo', 'column_excerpt')
                    ->required(),
            ],
            'location' => [
                Location::if('user_form', 'edit')->and('user_role', 'columnist')->and('user_role', '!=', 'administrator'),
            ]
        ]);
    }

}

$PaAcfUserFields = new PaAcfUserFields();
