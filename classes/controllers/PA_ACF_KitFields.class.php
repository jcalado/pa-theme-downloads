<?php
use Extended\LocalData;
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
      'show_in_rest' => true,
      'fields' => [
        LocalData::make(__('List', 'iasd'), 'downloads_kits')
          ->postTypes(['post'])
          ->filterTaxonomies([
            'xtt-pa-projetos',
            'xtt-pa-departamentos',
            'xtt-pa-sedes'
          ])
          ->initialLimit(10)
      ],
      'location' => [
          Location::if('post_type', 'kit'),
      ]
    ]);
  }

}

$PaAcfKitFields = new PaAcfKitFields();
