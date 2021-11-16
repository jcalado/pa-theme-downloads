<?php

/**
 * Search the first department of the post
 *
 * @param string $post_id The post ID
 * @return mixed
 */
function getDepartment($post_id) {
  if(!empty($term = get_the_terms($post_id, 'xtt-pa-departamentos')) && !is_wp_error($term))
      return $term[0];

  return null;
}

/**
 * Search the first priority seat of the post
 *
 * @param string $post_id The post ID
 * @return mixed
 */
function getPrioritySeat($post_id) {
  if($term = get_the_terms($post_id, 'xtt-pa-owner'))
      return $term[0];

  return null;
}

/**
 * Search the first project of the post
 *
 * @param string $post_id The post ID
 * @return mixed
 */
function getProject($post_id) {
  if($term = get_the_terms($post_id, 'xtt-pa-projetos'))
      return $term[0];

  return null;
}

/**
 * Search the related posts
 *
 * @param string $post_id The post ID
 * @param int $limit Maximum posts per query. Default = 3
 * @return array
 */
function getRelatedPosts($post_id, $post_type = 'post', $limit = 3): array {
  if(get_the_terms($post_id, 'xtt-pa-projetos') || get_the_terms($post_id, 'xtt-pa-departamentos')):
    $terms_projetos = get_the_terms($post_id, 'xtt-pa-projetos') ? wp_list_pluck(get_the_terms($post_id, 'xtt-pa-projetos'), 'term_id') : null;
    $terms_deptos   = get_the_terms($post_id, 'xtt-pa-departamentos') ? wp_list_pluck(get_the_terms($post_id, 'xtt-pa-departamentos'), 'term_id') : null;
    
    $args = array(
      'post_type'      => $post_type,
      'post__not_in'   => array($post_id),
      'posts_per_page' => $limit,
      'tax_query'      => array(
        'relation'     => 'OR',
        array(
          'taxonomy' => 'xtt-pa-projetos',
          'terms'    => $terms_projetos,
        ),
        array(
          'taxonomy' => 'xtt-pa-departamentos',
          'terms'    => $terms_deptos,
        ),
      ),
    );
    
    return get_posts($args);
  endif;

  return array();
}

function getHeaderTitle($post_id = NULL) {
  if(is_post_type_archive('kit'))
    $title = get_queried_object()->label;
  elseif(is_tax()) //is archive
    $title = get_taxonomy(get_queried_object()->taxonomy)->label . ' | ' . get_queried_object()->name;
  elseif(is_singular('kit')) //is single
    $title = 'Kits' . ' | ' . getProject($post_id)->name;
  elseif(is_single()) //is single
    $title = getDepartment($post_id)->name;
  else
    $title = get_the_title(); //default

  $words = explode(' ', $title);
  $regex = '/^([a-z]+(?:-[a-z]+)?)$/i';

  foreach($words as $word):
    if(preg_match($regex, $word, $m))
      $title = str_replace($word, "<span>{$word}</span>", $title);
  endforeach;

  return $title;
}
