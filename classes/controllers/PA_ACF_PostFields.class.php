<?php

use Extended\ACF\Fields\Number;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\TrueFalse;
use Extended\ACF\Fields\Url;
use Extended\ACF\Location;

class PaAcfPostFields
{

  public function __construct()
  {
    add_action('acf/init', [$this, 'createACFFields']);
  }

  function createACFFields()
  {
    register_extended_field_group([
      'title' => __('Downloads', 'downloads'),
      'key'   => 'downloads',
      'style' => 'default',
      'show_in_rest' => true,
      'fields' => [
        Repeater::make(__('List', 'downloads'), 'downloads')
          ->min(1)
          ->layout('table')
          ->required()
          ->fields([
            TrueFalse::make(__('Active', 'downloads'), 'active')
              ->defaultValue(true)
              ->stylisedUi()
              ->wrapper([
                'width' => 8,
              ]),
            Text::make(__('Name', 'downloads'), 'name')
              ->required()
              ->wrapper([
                'width' => 35,
              ]),
            Text::make(__('Format', 'downloads'), 'format')
              ->required()
              ->wrapper([
                'width' => 10,
              ]),
            Number::make(__('Size', 'downloads'), 'size')
              ->min(0)
              ->required()
              ->append('MB')
              ->wrapper([
                'width' => 17,
              ]),
            Url::make(__('Link', 'downloads'), 'link')
              ->required()
              ->wrapper([
                'width' => 30,
              ])
          ])
      ],
      'location' => [
        Location::where('post_type', 'post'),
      ]
    ]);
  }
}

$PaAcfPostFields = new PaAcfPostFields();
