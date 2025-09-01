<?php

class PAAjax
{

  public function __construct()
  {
    add_action('wp_ajax_send_report', [$this, 'sendReport']);
    add_action('wp_ajax_nopriv_send_report', [$this, 'sendReport']);
  }

  function sendReport()
  {
    $secret = get_field('report_recaptcha_secret_key', 'pa_settings');
    $token = sanitize_text_field(array_key_exists('token', $_POST) ? $_POST['token'] : '');

    if (!empty($secret) && !empty($token)) :
      $url = 'https://www.google.com/recaptcha/api/siteverify';
      $params = "secret={$secret}&response={$token}";

      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

      $response = json_decode(curl_exec($ch), true);

      if (
        !is_array($response) ||
        !array_key_exists('success', $response) ||
        empty($response['success']) ||
        $response['score'] < 0.5
      )
        wp_send_json_error();
    endif;

    $author_id = get_post_field('post_author', $_POST['report-postid']);
    $author_email = get_user_by('ID', $author_id)->user_email;
    $report_email = get_field('report_email', 'pa_settings');


    $to = !empty($report_email) ? [$report_email, $author_email] : $author_email;

    $mail = wp_mail(
      $to,
      __('New problem reported: ', 'downloads') . sanitize_text_field($_POST['report-title']),
      '<p>' . __('Someone has reported a problem with their material posted on the Downloads portal.', 'downloads') .
        '</p><strong>' . __('Title', 'downloads') . ': </strong>' . sanitize_text_field($_POST['report-title']) .
        '<br /><strong>' . __('Message', 'downloads') . ': </strong>' . sanitize_text_field($_POST['report-message']) .
        '<br /><strong>' . __('Url', 'downloads') . ': </strong>' . sanitize_text_field($_POST['report-permalink']),
      ['Content-Type: text/html; charset=UTF-8']
    );

    return empty($mail) ? wp_send_json_error() : wp_send_json_success();
  }
}

$PAAjax = new PAAjax();
