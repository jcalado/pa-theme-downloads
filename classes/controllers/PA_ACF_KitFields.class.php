<?php

use WordPlate\Acf\Fields\Relationship;
use WordPlate\Acf\Location;

class PaAcfKitFields {

  public function __construct() {
    add_action('init', [$this, 'createACFFields']);
  }

  function createACFFields() {
    register_extended_field_group([
      'title' => __('Downloads', 'iasd'),
      'key'   => 'downloads_kits',
      'style' => 'default',
      'fields' => [
        Relationship::make(__('List', 'iasd'), 'downloads')
          ->min(1)
          ->required()
          ->returnFormat('id')
          ->postTypes(['post'])
          ->elements(['featured_image'])
          ->filters([
            'search', 
            'taxonomy'
          ])
      ],
      'location' => [
          Location::if('post_type', 'kit'),
      ]
    ]);
  }

}

$PaAcfKitFields = new PaAcfKitFields();
