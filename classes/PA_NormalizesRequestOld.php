<?php

function DownloadRedirect($template)
{
    if (is_404()) {
        $url_parts = explode('/', $_SERVER['REQUEST_URI']);
        if (in_array('iasd-counter-link', $url_parts)) {
            $post_id = base64_decode(urldecode(array_pop($url_parts)));

            $link = get_post_meta($post_id, 'dp_file_url', true);

            if ($link) {
                header('Location: ' . $link);
                exit();
            }
        }
    }
    return $template;
}

add_action('template_include', 'DownloadRedirect');
