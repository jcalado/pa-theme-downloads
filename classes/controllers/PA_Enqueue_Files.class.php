<?php 

class PA_Enqueue_Files {
	public function __construct(){
		add_action('wp_enqueue_scripts', [$this, 'RegisterChildAssets']);
	}

	public function RegisterChildAssets() {
		wp_enqueue_style( 'pa-child-style', get_stylesheet_uri());
		wp_enqueue_script('pa-child-script', get_stylesheet_directory_uri() . '/assets/js/script.js', array(), false, false);

		wp_localize_script(
			'pa-child-script',
			'pa',
			array(
				'url'   => get_rest_url(null, 'wp/v2/'),
				'nonce' => wp_create_nonce('wp_rest'),
			)
		);
	}
}
new PA_Enqueue_Files();