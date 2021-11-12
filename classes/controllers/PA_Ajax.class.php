<?php



class PAAjax {

  public function __construct() {
    add_action('wp_ajax_nopriv_send_report', [$this, 'sendReport']); 
  }

  function sendReport() {
    $secret = '6LfdTS0dAAAAAJAYh8XhzssK5-ENZGMJ-oLPsNJz';
    $token = $_POST['token'];
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $params = "secret={$secret}&response={$token}";
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    
    $response = json_decode(curl_exec($ch), true);

    // var_dump($response);

    wp_send_json_success();
  }

}

new PAAjax();
