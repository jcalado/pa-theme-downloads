<?php

/** 
 * videoLength Format video length in 'mm:ss'
 *
 * @param  int $post_id The post ID
 * @return string Formated length string
 */
function videoLength(int $post_id = 0): string {
    $length = get_field('video_length', !empty($post_id) ? $post_id : get_the_ID());

    if(empty($length))
        return "";

    if($length / 3600 >= 1)
        return sprintf('%02d:%02d:%02d', ($length / 3600), ($length / 60 % 60), $length % 60);
    else
	    return sprintf('%02d:%02d', ($length / 60 % 60), $length % 60);
}

/**
 * getVideoLength Get video length and save data
 *
 * @param  int    $post_id The post ID
 * @param  string $video_host The video host
 * @param  string $video_id The video ID
 * @return void
 */
function getVideoLength(int $post_id, string $video_host, string $video_id): void {
    $json = file_get_contents("https://api.feliz7play.com/v4/{$video_host}info?video_id={$video_id}");
    $obj = json_decode($json);

    if(!empty($obj))
        update_field('video_length', $obj->time, $post_id);
}

/**
 * getPostFormat Get the post format
 *
 * @param string $post_id The post ID
 * @return mixed
 */
function getPostFormat($post_id) {
    if($term = get_the_terms($post_id, 'xtt-pa-format'))
        return $term[0];

    return null;
}

/**
 * getPostEditorial Get the post editorial
 *
 * @param string $post_id The post ID
 * @return mixed
 */
function getPostEditorial($post_id) {
    if($term = get_the_terms($post_id, 'xtt-pa-editorias'))
        return $term[0];

    return null;
}

/**
 * getPostRegion Get the post region
 *
 * @param string $post_id The post ID
 * @return mixed
 */
function getPostRegion($post_id) {
    if($term = get_the_terms($post_id, 'xtt-pa-regiao'))
        return $term[0];

    return null;
}

/**
 * Search the first priority seat of the post
 *
 * @param string $post_id The post ID
 * @return string
 */
function getPrioritySeat($post_id): string {
    if($term = get_the_terms($post_id, 'xtt-pa-owner'))
        return $term[0]->name;

    return 'Não há nenhuma sede proprietária vinculada a este post.';
}

/**
 * Search the related posts
 *
 * @param string $post_id The post ID
 * @param int $limit Maximum posts per query. Default = 6
 * @return array
 */
function getRelatedPosts($post_id, $limit = 6): array {
    if($term = get_the_terms($post_id, 'xtt-pa-projetos')):
        $args = array(
            'post_type'      => 'post',
            'post__not_in'   => array($post_id),
            'posts_per_page' => $limit,
            'tax_query'      => array(
                array(
                    'taxonomy' => 'xtt-pa-projetos',
                    'terms'    => $term[0]->name,
                ),
            ),
        );
        
        return get_posts($args);
    endif;

    return array();
}

function getHeaderTitle($post_id = NULL) {
    if(is_author() || is_singular('post') && !empty($format = getPostFormat($post_id)) && $format->slug == 'artigo')
        return 'Coluna | ' . (is_author() ? get_queried_object()->display_name : get_the_author_meta('display_name'));
    elseif(is_archive()) //is archive
        return get_taxonomy(get_queried_object()->taxonomy)->label . ' | ' . get_queried_object()->name;
    elseif(is_singular('post')) //is single
        return getPostEditorial($post_id)->name;
    elseif(is_singular('press')) //is single
        return __('Press room', 'iasd');
    
    return the_title(); //default
}

/**
 * Search the first department of the post
 *
 * @param string $post_id The post ID
 * @return mixed
 */
function getDepartment($post_id) {
    if($term = get_the_terms($post_id, 'xtt-pa-departamentos'))
        return $term[0];

    return null;
}