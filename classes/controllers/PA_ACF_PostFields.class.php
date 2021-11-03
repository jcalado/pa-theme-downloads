<?php

use WordPlate\Acf\Location;

class PaAcfPostFields {

    public function __construct() {
        add_action('init', [$this, 'createACFFields']);
    }

    function createACFFields() {
        register_extended_field_group([
            'title' => __('Video info', 'iasd'),
            'key'   => 'video_info',
            'style' => 'default',
            'fields' => [
                
            ],
            'location' => [
                Location::if('post_type', 'post'),
            ]
        ]);
    }

}

$PaAcfPostFields = new PaAcfPostFields();
