<?php

class PaRewriteRules {
	public function __construct(){
        add_filter( 'do_parse_request', [$this, 'PostRewriteRules'], 3);
        add_action( 'pre_post_link', [$this,'InitPostUrls'], 3, 3);
        add_action( 'pre_post_link', [$this,'ReplacePostUrls'], 100, 3);
	}

	function InitPostUrls($permalink, $post) {

        if($post->post_type == 'post') {
            // $permalink = '/editoria/%'.PATaxonomias::TAXONOMY_EDITORIAS.'%/%postname%/';
            $permalink = '/editoria/%xtt-pa-editorias%/%postname%/';
        }
    
        return $permalink;
    }
    function PostRewriteRules($bool) {
        
        $rewrite_rule = 'editoria/([^/]+)/([^/]+)/?$';
        $rewrite_redirect = 'index.php?name=$matches[2]&post_type=post&xtt-pa-editorias=$matches[1]';
        add_rewrite_rule( $rewrite_rule, $rewrite_redirect);
    
        flush_rewrite_rules();

        return $bool;
    }
    
    function ReplacePostUrls($permalink, $post) {
        if($post->post_type == 'post') {
    
            $args = array(
                'object_type' => array(
                    'post',
                ),
            );
            $output = 'names'; // or objects
            $operator = 'and'; // 'and' or 'or'
            $taxonomias = get_taxonomies($args, $output, $operator);
    
            $terms = wp_get_object_terms($post->ID, $taxonomias);
            foreach($terms as $term) {
                $permalink = str_replace('%'.$term->taxonomy.'%', $term->slug, $permalink);
            }
            foreach($taxonomias as $taxonomia){
                $permalink = str_replace('/%'.$taxonomia.'%', '', $permalink);
            }
        }
    
        return $permalink;
    }
}
$PaRewriteRules = new PaRewriteRules();