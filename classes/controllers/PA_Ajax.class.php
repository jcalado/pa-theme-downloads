<?php

class PAAjax {

  public function __construct() {
    add_action('wp_ajax_send_report', [$this, 'sendReport']); 
    add_action('wp_ajax_nopriv_send_report', [$this, 'sendReport']); 
  }

  function sendReport() {
    $secret = get_field('report_recaptcha_secret_key', 'option');
    $token = sanitize_text_field(array_key_exists('token', $_POST) ? $_POST['token'] : '');

    if(!empty($secret) && !empty($token)):
      $url = 'https://www.google.com/recaptcha/api/siteverify';
      $params = "secret={$secret}&response={$token}";
      
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      
      $response = json_decode(curl_exec($ch), true);

      if(!is_array($response) || 
        !array_key_exists('success', $response) || 
        empty($response['success']) || 
        $response['score'] < 0.5)
        wp_send_json_error();
    endif;

    $mail = wp_mail(
      get_field('report_email', 'option'), 
      __('Novo problema reportado: ') . sanitize_text_field($_POST['report-title']),
      '<strong>' . __('Título', 'iasd') .': </strong>' . sanitize_text_field($_POST['report-title']) .
      '<br /><strong>' . __('Url', 'iasd') .': </strong>' . sanitize_text_field($_POST['report-permalink']) .
      '<br /><strong>' . __('Mensagem', 'iasd') .': </strong>' . sanitize_text_field($_POST['report-message']),
      ['Content-Type: text/html; charset=UTF-8']
    );

    return empty($mail) ? wp_send_json_error() : wp_send_json_success();
  }

}

new PAAjax();
