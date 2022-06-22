<?php 

class PaEnqueueFiles {
	public function __construct(){
		add_action('wp_enqueue_scripts', [$this, 'RegisterChildAssets']);
		add_action('admin_enqueue_scripts', [$this, 'enqueueAssets'], 15);
	}

	public function RegisterChildAssets() {
		wp_enqueue_style('pa-child-style', get_stylesheet_uri());
    wp_enqueue_script('pa-child-script', get_stylesheet_directory_uri() . '/assets/js/script.js', ['scripts'], null, true);

    if(!empty($site_key = get_field('report_recaptcha_site_key', 'pa_settings'))):
      wp_enqueue_script('recaptcha', "https://www.google.com/recaptcha/api.js?render={$site_key}", ['scripts'], null, true);

      wp_localize_script(
        'recaptcha',
        'recaptcha',
        array(
          'site_key' => $site_key,
        )
      );
    endif;

    wp_localize_script(
			'pa-child-script',
			'pa',
			array(
				'url' => admin_url('admin-ajax.php'),
			)
		);
	}

	function enqueueAssets() {
    wp_localize_script(
      'adventistas-admin', 
      'iasd',
      array(
        'requiredTaxonomies' => [
          [
            'post_type'    => 'post',
            'taxonomies'   => [
              'xtt-pa-departamentos',
              'xtt-pa-owner',
              'xtt-pa-sedes',
              'xtt-pa-materiais'
            ],
          ],
          [
            'post_type'    => 'kit',
            'taxonomies'   => [
              'xtt-pa-departamentos',
              'xtt-pa-owner',
            ],
          ]
        ],
        'unregisterBlocks' => [
          'acf/p-a-magazines', 
          'acf/p-a-list-news',
          'acf/p-a-carousel-downloads',
          'acf/p-a-list-downloads',
          'acf/p-a-carousel-ministry',
          'acf/p-a-list-buttons',
          'acf/p-a-list-items',
          'acf/p-a-list-icons',
          'acf/p-a-carousel-feature',
          'acf/p-a-list-videos'
        ],
      )
    );
	}
}
$PaEnqueueFiles = new PaEnqueueFiles();
