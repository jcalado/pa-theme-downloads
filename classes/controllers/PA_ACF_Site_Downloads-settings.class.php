<?php

use WordPlate\Acf\Fields\Email;
use WordPlate\Acf\Fields\TrueFalse;
use WordPlate\Acf\Location;


class PaAcfSiteDownloadsSettings {

	public function __construct(){
		add_action('after_setup_theme', [$this, 'createAcfFields']);
	}

  function createAcfFields() {
    register_extended_field_group([
      'title'  => __('Report settings', 'iasd'),
			'key'    => 'site_settings_report',
      'style'  => 'default',
      'fields' => [
        TrueFalse::make(__('Enable report', 'iasd'), 'report_enabled')
          ->stylisedUi()
          ->wrapper([
            'width' => 50,
          ]),
        Email::make(__('Sender email', 'iasd'))
          ->wrapper([
            'width' => 50,
          ]),
      ],
      'location' => [
        Location::if('options_page', 'iasd_custom_settings'),
      ],
    ]);
  }

}

new PaAcfSiteDownloadsSettings();
