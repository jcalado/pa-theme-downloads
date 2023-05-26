<?php

use Extended\ACF\Fields\Number;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Url;
use Extended\ACF\Location;

class PaAcfPostFields
{

  public function __construct()
  {
    add_action('init', [$this, 'createACFFields']);
  }

  function createACFFields()
  {
    register_extended_field_group([
      'title' => __('Downloads', 'iasd'),
      'key'   => 'downloads',
      'style' => 'default',
      'show_in_rest' => true,
      'fields' => [
        Repeater::make(__('List', 'iasd'), 'downloads')
          ->min(1)
          ->layout('block')
          ->collapsed('name')
          ->required()
          ->fields([
            Text::make(__('Name', 'iasd'), 'name')
              ->required(),
            Text::make(__('Format', 'iasd'), 'format')
              ->required()
              ->wrapper([
                'width' => 33,
              ]),
            Number::make(__('Size', 'iasd'), 'size')
              ->min(0)
              ->required()
              ->append('MB')
              ->wrapper([
                'width' => 33,
              ]),
            Url::make(__('Link', 'iasd'), 'link')
              ->required()
              ->wrapper([
                'width' => 33,
              ])
          ])
      ],
      'location' => [
        Location::if('post_type', 'post'),
      ]
    ]);
  }
}

$PaAcfPostFields = new PaAcfPostFields();
