<?php

include "get_plans_by_proveedor_tax.php";


//Accion para controlar peticion de proveedores y campos
add_action( "wp_ajax_get_results_filterpage", "getresults_wp_ajax_function" );
add_action( "wp_ajax_nopriv_get_results_filterpage", "getresults_wp_ajax_function" );


//funcion que responde a la accion de la peticion de proveedores y planes en pagina de filtros
function getresults_wp_ajax_function(){

        echo '<p>si se pudo</p>';


/*
            // Se verifica que en el POST['gar'] el valor sea diferente de vacio
            //se puede usar la validacion empty: ( $_POST['gar'] )
            $garantia_form = $_POST['gar'] != "" ? $_POST['gar'] : 'all';
            $dominio_form = $_POST['dom'] != "" ? $_POST['dom'] : 'all';
            $ssl_form = $_POST['ssl'] != "" ? $_POST['ssl'] : 'all';
            $soporte_form = $_POST['at'];
            $metodos_pago_form = $_POST['pay'];
            $pais_form = $_POST['ps'] != "" ? $_POST['ps'] : 'all';


            
            // var_dump( $garantia_form );
            // var_dump( $dominio_form );
            // var_dump( $ssl_form );
            // var_dump( $soporte_form );
            // var_dump( $metodos_pago_form );
            // var_dump( $pais_form );
            
            $count_soporte = count( $soporte_form );
            $count_metodos = count( $metodos_pago_form );
            // echo $count_soporte . "\n" . $count_metodos;


            //construccion de meta consultas para el query 
            $meta_query_soporte = array();
            if($count_soporte > 0){
                $meta_query_soporte['relation'] = 'OR';
                foreach( $soporte_form as $p ){
                    $meta_query_soporte[] = array(
                        'key' => 'soporte',
                        'value' => sanitize_text_field( (string) $p ),
                        'compare' => 'like'
                    );
                }
            } else{
                $meta_query_soporte = array(
                    'key' => 'soporte',
                    'value' => '',
                    'compare' => 'like'
                );
            }

            $meta_query_metodos_pagos = array();
            if($count_metodos > 0){
                $meta_query_metodos_pagos['relation'] = 'OR';
                foreach( $metodos_pago_form as $p ){
                    $meta_query_metodos_pagos[] = array(
                        'key' => 'metodos_pago',
                        'value' => sanitize_text_field( (string) $p ),
                        'compare' => 'like'
                    );
                }
            } else{
                $meta_query_metodos_pagos = array(
                    'key' => 'metodos_pago',
                    'value' => '',
                    'compare' => 'like'
                );
            }
            

            // argumentos para la consulta

            $args = array(
                'post_type'         => 'proveedor',
                'post_status'       => 'publish',
                // 'product_cat'       => $category_current_slug,
                'tax_query' => array(
                    array (
                        'taxonomy' => $current_taxonomy,
                        'field' => 'slug',
                        'terms' => $category_current_slug,
                    )
                ),
                'orderby'    => 'media_de_puntuaciones',
                'posts_per_page'    => -1,
                'order'    => 'DESC',
                'meta_query'        => array( 
                                                'relation'		=> 'AND',
                                                    array(
                                                        'key' => 'garantia', // name of custom field
                                                        // se realiza el query con el parametro de garantia validando que este vacio o no
                                                        'value' => ($garantia_form == 'all' ? '' : $garantia_form),
                                                        'compare' => 'like'
                                                    ),

                                                    array(
                                                        'key' => 'dominio',
                                                        'value' => ( $dominio_form == 'all' ? '' : $dominio_form ),
                                                        'compare' => 'like'
                                                    ),

                                                    array(
                                                        'key' => 'ssl',
                                                        'value' => ( $ssl_form == 'all' ? '' : $ssl_form ),
                                                        'compare' => 'like'
                                                    ),

                                                    array(
                                                        'key' => 'pais',
                                                        'value' => ( $pais_form == 'all' ? '' : $pais_form ) ,
                                                        'compare' => 'like'
                                                    ),

                                                    $meta_query_soporte,

                                                    $meta_query_metodos_pagos,
                                                    
                                                    
                                        )


            );

            //consulta con args
            $query = new WP_Query($args);

        
                        $detalle_cards = '';
                        $lista_cards = '';
                        $compare_content = '';


                        if( $query->have_posts() ){
                            
                            $account_filter_build = 0;
                            $_class_build_ = '';

                            $compare_content .= '<div class="section--compare container--compare-cards container--comparacards--view resultados" style="display: none;">'; 

                            $compare_content .= '
                                                    <div class="features-rows-compare ">
                                                        <div class="first-row"><p>Hosting</p></div>
                                                        <div class="second-row"><p>Score</p></div>
                                                        <div class="third-row"><p class="hosting-features">Hosting Features</p></div>
                                                        <div class="adding-element title-ele"><p>VPS</p></div>
                                                        <div class="end-button-comparacard button-plus"><i class="fa fa-plus" style=""></i></div>
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

                                $ssl_parametro = $ssl[$ssl_form];
                                $garantia_parametro = $garantia[$garantia_form];
                                $dominio_parametro = $dominio[$dominio_form];
                                $soporte_parametro = $soporte_form;


                                $get_render_table = get_plans_by_proveedor_tax( get_the_ID(), $category_current );
                                
                                if($get_render_table != ''){

                                    $render_table = $get_render_table["tabla"];
                                    $precio_minimo = $get_render_table["menor_precio"];

                                    $detalle_cards .= "<div class='row resultados detail-card result_filter_details " . $_class_build_ . "'>";
                                        include "templates-part/detalles.php";
                                    $detalle_cards .= "</div>";

                                    $lista_cards .= '<div class="row resultados list-card result_filter_list '. $_class_build_ .' " style="display: none;">';
                                        include "templates-part/lista.php";
                                    $lista_cards .= '</div>';

                                    $compare_content .= '<div class="compare-card result_filter_compare">';
                                        include "templates-part/comparacards.php";
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

                            echo $render_content_filter;

                            wp_reset_postdata();
                        }else{
                        // get_template_part( 'templates/content', 'none' );
                        }
        


*/

        wp_die();

}


?>