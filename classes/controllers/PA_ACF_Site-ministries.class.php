<?php

// This example is registering a option page using ACF. Please see the
// documentation for more information:
// https://www.advancedcustomfields.com/resources/acf_add_options_page/


use WordPlate\Acf\Fields\Select;
use WordPlate\Acf\Location;


class PaAcfSiteMinistries {
	public function __construct(){
        add_action('init', [$this, 'createAcfFields' ], 998);
	}

    function createAcfFields(){
        register_extended_field_group([
            'title' => 'Ministry',
            'style' => 'default',
            'fields' => [
                Select::make('Departamento', 'departamento')
                    ->choices([
                        'institucional' => 'Institucional',
                        'depto-adolescente' => 'Adolescente',
                        'depto-adra' => 'Adra',
                        'depto-afam' => 'AFAM',
                        'depto-asa' => 'ASA',
                        'depto-associacao-ministerial' => 'Associação Ministerial',
                        'depto-aventureiro' => 'Aventureiros',
                        'depto-comunicacao' => 'Comunicação',
                        'depto-crianca' => 'Criança',
                        'depto-desbravador' => 'Desbravadores',
                        'depto-downloads' => 'Downloads',
                        'depto-educacao' => 'Educação',
                        'depto-escola-sabatina' => 'Escola Sabatina',
                        'depto-espirito-profecia' => 'Espirito de Profecia',
                        'depto-evangelismo' => 'Evanvelismo',
                        'depto-familia' => 'Família',
                        'depto-jovem' => 'Jovens',
                        'depto-liberdade-religiosa' => 'Liberdade Religiosa',
                        'depto-ministerio-pessoal' => 'Ministério Pessoal',
                        'depto-missao-global' => 'Missão Global',
                        'depto-mordomia' => 'Mordomia',
                        'depto-mulher' => 'Mulher',
                        'depto-musica' => 'Música',
                        'depto-noticias' => 'Notícias',
                        'depto-publicacoes' => 'Publicações',
                        'depto-salt' => 'SALT',
                        'depto-saude' => 'Saúde',
                        'depto-universitario' => 'Universitários',
                        'depto-videos' => 'Vídeos',
                        'depto-voluntario' => 'Voluntários',
                    ])
                    ->returnFormat('value'), // array, label or value (default)
            ],
            'location' => [
                Location::if('options_page', 'iasd_custom_settings'),
            ],
        ]);
    }
}
$PaAcfSiteMinistries = new PaAcfSiteMinistries();
