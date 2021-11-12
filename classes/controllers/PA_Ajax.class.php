<?php



class PAAjax {

  public function __construct() {
    add_action('wp_ajax_nopriv_send_report', [$this, 'sendReport']); 
  }

  function sendReport() {
    wp_send_json_success();
  }

}

new PAAjax();
