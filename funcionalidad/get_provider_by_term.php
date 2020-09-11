<?php

include "get_plans_by_proveedor_tax.php";

function get_proveedores_and_plans_by_term($current_taxonomy, $category_current_slug, $category_current, $type, $country, $cantidad_sitios, $pay_method, $budged, $traffic){

    $args = array(
        'post_type'         => 'proveedor',
        'post_status'       => 'publish',
        'posts_per_page'    => -1,
        'meta_key'    => 'media_de_puntuaciones',
        'orderby'   =>  'meta_value_num',
        'order'    => 'DESC',
        
    );

    if($type == 1){
        
        $args['tax_query'] = array(
                array (
                    'taxonomy' => $current_taxonomy,
                    'field' => 'slug',
                    'terms' => $category_current_slug,
                )
        );

    }


    if($country != ''){
        $args['meta_query'] = array( 
            'relation'		=> 'AND',

                array(
                    'key' => 'pais',
                    'value' => $country,
                    'compare' => 'like'
                ),                
            );
    }

    if( $pay_method != ''){
        
        $args['meta_query'] = array( 
            'relation'		=> 'AND',
                array(
                    'key' => 'metodos_pago',
                    'value' => '"'.$pay_method.'"' ,
                    'compare' => 'like'
                ),  
                     
        );

    }


    // var_dump( $args );
    // echo "<br /><br />";


    $query = new WP_Query( $args );

    $detalle_cards = '';
    $lista_cards = '';
    $compare_content = '';

    if( $query->have_posts() ){


        $feats_ = get_option( 'filtros_hosting_data' );
        $render_feats_title = '';

        foreach( $feats_ as $fe ){

            $clase_controller = str_replace(' ', '', $fe);

            $render_feats_title .=   '
                                        <div class="adding-element title-ele hosting-features" feature="'. $clase_controller .'" style="display: none;"><p>'. $fe .'</p></div>
                                    ';            

        }
        
        $account_filter_build = 0;
        $_class_build_ = '';

        $compare_content .= '<div id="control_comparador_container" class="section--compare container--compare-cards container--comparacards--view resultados" style="display: none;">'; 

        $compare_content .= '
                                <div id="features-fields-compare" class="features-rows-compare ">
                                    <div class="first-row"><p>Hosting</p></div>
                                    <div class="second-row"><p>Score</p></div>
                                    <div class="plains-providers-select-compare"><p>Plans</p></div>
                                    <div class="adding-element title-ele hosting-features" feature="ssl"><p>SSL</p></div>
                                    <div class="adding-element title-ele hosting-features" feature="garantía"><p>Garantía</p></div>
                                    <div class="adding-element title-ele hosting-features" feature="dominio"><p>Dominio</p></div>
                                    <div class="adding-element title-ele hosting-features" feature="soporte_espaniol"><p>Soporte Español</p></div>
                                    <div class="adding-element title-ele hosting-features" feature="24_7"><p>Soporte 24/7</p></div>
                                    '. $render_feats_title .'
                                    <div id="image-paste-to-plus-features-sticky-text"></div>
                                    <div id="image-paste-to-plus-features-sticky-arrow"></div>
                                    <a class="end-button-comparacard button-plus btn"><i class="fa fa-plus" style=""></i></a>
                                </div>
                            ';
        
        $compare_content .= '
            <div class="owl-carousel carrousel--compare-cards" 
                data-carousel-items="4"
                data-carousel-margin="0"
                data-carousel-responsive=\'{"0":{"items":"1"},"576":{"items": "2"},"768":{"items":"3"},"960":{"items":"5"}}\'
            >
        ';

        while( $query->have_posts() ){
            

            if($account_filter_build == 0) { $_class_build_ = 'primary_select'; }
            else{ $_class_build_ = ''; }

            $query->the_post();

            $ssl_parametro = get_field( 'ssl', get_the_ID() )["label"];
            $garantia_parametro = get_field( 'garantia', get_the_ID() )["label"];
            $dominio_parametro = get_field( 'dominio', get_the_ID() )["label"];
            $soporte_parametro = get_field( 'soporte', get_the_ID() );

            $url_de_afiliados = get_field( 'url_afiliado' );


            $thumbID = get_post_thumbnail_id( get_the_ID() );
            $imgDestacada = wp_get_attachment_url( $thumbID );


            $get_render_table = get_plans_by_proveedor_tax( get_the_ID(), $category_current, $cantidad_sitios, $pay_method, $budged, $traffic );
            
            
            if($get_render_table != ''){

                /* Variables de renderizado que se obtienen de los planes */
                $render_table = $get_render_table["tabla"];
                $precio_minimo = $get_render_table["menor_precio"];
                $array_caracteristicas_plan = $get_render_table["features_plans"];
                $options_plans_compare = $get_render_table["select_compare_plans"];
                $price_plans_compare = $get_render_table["precios_comparador_plans"];
                $features_details_cards = $get_render_table["caracteristicas_para_card_detalle"];



                /* renderizado de las cards */


                $detalle_cards .= "<div class='row resultados detail-card result_filter_details " . $_class_build_ . "'>";
                    include( dirname(__FILE__)."/../templates-part/detalles.php" );
                $detalle_cards .= "</div>";

                $lista_cards .= '<div class="row resultados list-card result_filter_list '. $_class_build_ .' " style="display: none;">';
                    include( dirname(__FILE__)."/../templates-part/lista.php" );
                $lista_cards .= '</div>';

                $compare_content .= '<div id="'. get_the_ID() .'" class="compare-card result_filter_compare '. get_the_ID() .'" prove-slug="'. get_the_title( get_the_ID() ) .'" prove-logo="'. get_field( 'logo' ) .'" prove-logo-gris="'. $imgDestacada .'" >';
                    include( dirname(__FILE__)."/../templates-part/comparacards.php" );
                $compare_content .= '</div>';

            }
            else{
                null;
            }

            

            $account_filter_build++;
        }

        $compare_content .= '</div>';

        $compare_content .= '</div>';


        $render_content_filter = $detalle_cards . $lista_cards . $compare_content;

        
        
    }

    echo $render_content_filter;

}



?>