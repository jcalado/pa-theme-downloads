<?php

use WordPlate\Acf\Fields\Email;
use WordPlate\Acf\Fields\Password;
use WordPlate\Acf\Fields\TrueFalse;
use WordPlate\Acf\Location;

class PaAcfSiteDownloadsSettings {

	public function __construct() {
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
          ->defaultValue(true)
          ->wrapper([
            'width' => 50,
          ]),
        Email::make(__('Send email to', 'iasd'), 'report_email')
          ->wrapper([
            'width' => 50,
          ]),
        Password::make(__('reCAPTCHA site key', 'iasd'), 'report_recaptcha_site_key')
          ->instructions(__('Se não configurada, o site não ativará o captcha, podendo assim ficar vulnerável a spam.', 'iasd'))
          ->wrapper([
            'width' => 50,
          ]),
        Password::make(__('reCAPTCHA secret key', 'iasd'), 'report_recaptcha_secret_key')
          ->instructions(__('Se não configurada, o site não ativará o captcha, podendo assim ficar vulnerável a spam.', 'iasd'))
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

$PaAcfSiteDownloadsSettings = new PaAcfSiteDownloadsSettings();
