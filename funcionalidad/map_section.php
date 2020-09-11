<?php

// Section de Home de Mapa y Hosting

function map_area_hosting_site(){

    //variables de contenido
    $var_html_content = '';
    $var_script_js = '';
    
    // variable de pais que inicializa como seleccionado
    $pais = ""; 
    $pais = ucfirst($pais);
    
    //variables de control del foreach con los mapas de los paises
    $var_account_inside = 0;
    $var_img_content .= '';
    $var_cards_hosting_content .= '';
    $var_countries_list .= '';
    $extensions_list = '';
    
    $result_paises = get_option( '_paises_hostings_' );

    foreach( $result_paises as $arr_eval){
        foreach( $arr_eval as $re => $kword ){
            $post_object = get_page_by_path( $kword["slug"], OBJECT, 'pais' );
            $idPosPAIS = $post_object->ID;
            switch ($kword["slug"]) {
            
                case "internacional" :
                    null;
                break;

                default :

                        $clase_seleccionada = '';
                        $clase_divs_cards_select = '';
                        if($var_account_inside == 0){ $clase_seleccionada = 'img-selected'; $clase_divs_cards_select = 'selected'; $pais = ucfirst($kword["pais"]); }
                        else{ $clase_seleccionada = ''; $clase_divs_cards_select = 'no-selected'; }
                
                        $var_img_content .= '<img class="' . $kword["slug"] . ' ' . $clase_seleccionada . '" src="' . $kword["imagen"] . '"/>';

                        $extensions_list .= '<p class="' . $kword["slug"] . ' ' . $clase_divs_cards_select . '">'. strtoupper( get_field( "extension_de_pais", $re ) ) .'</p>';

                        $var_cards_hosting_content .=   '
                                                <div id="'.$kword["slug"].'" class="options-items-map '.$clase_divs_cards_select.'">
                                                    
                                                    <div class="selects-items">

                                                        ';

                                                        // echo $key_i["pais"];
                                                        // loop para obtener todos los proveedores de cada pais



                                                        $arr_recupe_tmp = array();
                                                        foreach( $kword["arr_id"] as $ppp ){
                                                            $puntuacion = get_post_meta( $ppp, "media_de_puntuaciones" )[0];
                                                            $_tmp_ = array("id"=>$ppp, "score"=>$puntuacion);
                                                            array_push($arr_recupe_tmp, $_tmp_);
                                                        }
                                                        usort($arr_recupe_tmp, function($a, $b) {
                                                                return $b['score'] <=> $a['score'];
                                                        });


                                                        $random_keys = array_rand( $arr_recupe_tmp, 3 );                                


                                                        $var_count_host = 0;
                                                        foreach( $random_keys as $val_key ){

                                                            $nn2 = $arr_recupe_tmp[$val_key];

                                                            $url_afiliado = get_field( 'url_afiliado', $nn2["id"] );
                                                            // get_data
                                                            //obtencion de puntuaciones para el proveedor en este pais
                                                            // $total_opiniones = get_field('total_opiniones', $nn2);
                                                            // $soporte = get_field('total_soporte', $nn2);
                                                            // $usabilidad = get_field('total_usabilidad', $nn2);
                                                            // $funcionalidades = get_field('total_funcionalidades', $nn2);
                                                            // $valor = get_field('total_valor', $nn2);
                                                            // $media_score = ( ( ($soporte/$total_opiniones) + ($usabilidad/$total_opiniones) + ($funcionalidades/$total_opiniones) + ($valor/$total_opiniones) ) / 4 );

                                                            // $media_score = round($media_score, 1);

                                                            // imagen del proveedor
                                                            $image_thumb = get_field( "logo", $nn2["id"]);
                                                            $puntuacion = get_post_meta( $nn2["id"], "media_de_puntuaciones" );
                                                            $puntuacion = number_format((float)round( $puntuacion[0], 1), 1, '.', '');

                                                            $score_component = '';
                                                            $score = $puntuacion;
                                                            for( $i=1; $i<=5; $i++){
                                                                if($score >= 1){
                                                                    $score_component .= '<i class="fa fa-star" style="color: #efce4a;"></i>';
                                                                    $score--;
                                                                } else{
                                                                    if($score >= 0.5){
                                                                        $score_component .= '<i class="fa fa-star-half-o" style="color: #efce4a;"></i>';
                                                                        $score-=0.5;
                                                                    } else{
                                                                        $score_component .= '<i class="fa fa-star-o" style="color: #efce4a;"></i>';
                                                                    }
                                                                }
                                                            }

                                                            $separador_caracteristicas = ',';
                                                            $datos_caracteristica = get_field( "resumen_caracteristicas", $nn2["id"] );

                                                            $datos_caracteristica = explode($separador_caracteristicas, $datos_caracteristica);
                                                            $elem_caracteristicas = '';

                                                            $count_caract = 0;
                                                            foreach( $datos_caracteristica as $key => $dc ){
                                                                
                                                                if( $count_caract < 2){
                                                                    $elem_caracteristicas .= '<p class="class-dato">'.$dc.'</p>';
                                                                }
                                                                else{
                                                                    null;
                                                                }
                                                                
                                                                $count_caract++;

                                                            }

                                                            
                                                            $var_cards_hosting_content .=   '
                                                                                                <div class="item-column-element">
                                                                                            
                                                                                                    <div class="content-cardviews-home info-cardviews-content">
                                                                                                        <img src="'. $image_thumb .'" class="cardviews-img-custom-style" />
                                                                                                        <div class="content-internal-row item-score">
                                                                                                            <div class="col-sm-12 price-rank-p">
                                                                                                                <p class="cardviews-puntuacion-style-custom">'. $puntuacion .'</p>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <!-- Rating Stars Box -->
                                                                                                        <div class="rating-stars text-center item-star">
                                                                                                            <ul id="stars">
                                                                                                                '. $score_component .'
                                                                                                            </ul>
                                                                                                        </div>
                                                                                                        <!-- End star ratings box -->

                                                                                                      
                                                                                                        
                                                                                                        <div class="end-bottom-button-ver-mas-cardviews">
                                                                                                            <a target="_blank" href="'.$url_afiliado.'" class="cardview-button-custom-style" >Ver más</a>
                                                                                                        </div>
                                                                                                    </div>
                                            
                                                                                                </div>
                                                                                            ';


                                                            $var_count_host++;

                                                        }


                        $var_cards_hosting_content .=   '

                                                    </div>

                                                    <div><a arget="_blank" class="newdesigncolumnbutton btn" href="'.get_permalink($idPosPAIS).'">Ver todas las opciones</a></div>

                                                </div>
                                                        ';

                        


                        $var_countries_list .=  '
                                                        <a><h5 id="'. $kword["slug"] .'" class="'. $clase_divs_cards_select .'">'. $kword["pais"].'</h5></a>
                                                ';
                        
                        

                           
                        $var_account_inside++;  
                                             
            
            }

            
        }
    }



    $var_html_content .=    '
                                <div id="ch-page-section-3" class="map-content">
                                    <div class="inner-fila fila-title-map">
                                        <div class="column-filatitle section--title">
                                            <p class="text-subheading">.com / .mx /.pe / .do/ .uy/ .co/ .br/ .cl/ .bo/ .cr/ .uy/ .pa/ .sv/ .hn/ .ar/</P>
                                            <h2>¿ Qué tipo de dominio (.) quieres hostear?</h2>
                                            <h4 class="texto-descriptivo-subtitle">Elija entre servicios de hosting especializados para alojar extensiones de tu país según la terminación de tu dominio.</h4>
                                        </div>
                                    </div>

                                    <div class="inner-fila fila-1-map">
                                        <div class="columns-fila1 columna-1-fila1">
                                            ' . $var_img_content . '
                                        </div>
                                        <div class="columns-fila1 columna-2-fila1">
                                            <div class="header-items-map">
                                                <span class="tooltiptext">'. $pais .'</span>
                                                <h3>DOMINIOS / '. $extensions_list .'</h3>
                                                <h5>¡Tenemos el dominio perfecto para tí!</h5>
                                            </div>

                                            '. $var_cards_hosting_content .'
                                        </div>
                                    </div>

                                    <div class="inner-fila fila-2-map">
                                        <div class="columns-fila2 lista-paises">
                                            '. $var_countries_list .'
                                        </div>
                                    </div>
                                </div>
                            ';

    $var_script_js =    '
                            <script>
                                    
                            </script>
                        ';

    $var_return = $var_html_content . $var_script_js;

    return $var_return;
}

add_shortcode( "map_area_hosting_site", "map_area_hosting_site" );


// Fin de seccion

?>