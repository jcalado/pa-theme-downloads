<?php

use WordPlate\Acf\Fields\PostObject;
use WordPlate\Acf\Location;

class PaAcfLeaders {

    public function __construct(){
        add_action('init', [$this, 'createACFFields']);
        // add_action( 'admin_init', [$this, 'hideEditor']);
    }

    function createACFFields(){
        register_extended_field_group([
            'title' => 'Leader-feature',
            'style' => 'default',
            'fields' => [
                PostObject::make('Líderes destaques', 'lideres_destaques')
                    ->postTypes(['lideres'])
                    ->returnFormat('id'), // id or object (default)
            ],
            'location' => [
                Location::if('page_template', 'page-lideres.php'),
            ]
        ]);
    }
 
    function hideEditor() {
    
        if ( isset($_GET['post']) || isset($_POST['post_ID']) ) {
            $post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;
        }
        
        if( !isset( $post_id ) ) return;
    
        $template_file = get_post_meta($post_id, '_wp_page_template', true);
        
        if($template_file == 'page-lideres.php'){ // edit the template name
            remove_post_type_support('page', 'editor');
        }
    }

}

$PaAcfLeaders = new PaAcfLeaders();
