<?php get_header(); ?>

<?php

    $idPost = get_the_ID( );

?>

<?php 

    // variables de contenido

    $logo = get_field( 'logo', $idPost );
    $url_afiliado = get_field( 'url_afiliado', $idPost );
    $singlebanner = get_field( 'singlebanner', $idPost );
    $name_proveedor = get_the_title( $idPost );
    $thumbID = get_post_thumbnail_id( $idPost );
    $imgDestacada = wp_get_attachment_url( $thumbID );
    $excerpt = get_the_excerpt( $idPost );

    $puntuacion = get_post_meta( $idPost, "media_de_puntuaciones" );
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

    $ssl_parametro = get_field( 'ssl', $idPost )["label"];
    $garantia_parametro = get_field( 'garantia', $idPost )["label"];
    $dominio_parametro = get_field( 'dominio', $idPost )["label"];
    $soporte_parametro = get_field( 'soporte', $idPost );

    if( $garantia_parametro == 'No ofrece' ){
        
        $antes_de_garantia = 'Garantía: ';

    }else{

        $antes_de_garantia = 'Garantía de ';
    
    }

    $var_sop_arr =  $soporte_parametro;
    $si_hay_soporte = '';
    foreach( $var_sop_arr as $param ){

        if( $param == '2' ){
            $si_hay_soporte = 'Soporte Español Sí';
        }

    }

    if( $si_hay_soporte == ''){

        $si_hay_soporte = 'Soporte Español No';

    }

    $imagenContenido = get_field( 'imagen_contenido', $idPost );

    $imagenCarrusel1 = get_field( 'img_carousel1', $idPost );
    $imagenCarrusel2 = get_field( 'img_carousel2', $idPost );
    $imagenCarrusel3 = get_field( 'img_carousel3', $idPost );
    $imagenCarrusel4 = get_field( 'img_carousel4', $idPost );
    $imagenCarrusel5 = get_field( 'img_carousel5', $idPost );
    $imagenCarrusel6 = get_field( 'img_carousel6', $idPost );

?>

<?php 

    // logica de estructuras y tipos

    // get terms del posts
    $terms = get_the_terms( $idPost, 'tipo' );
    $arraTerms = array(); // array de reestructura de terms
    if ( $terms && !is_wp_error( $terms ) ) : 
        
        //loop de objetos terms del posts
        foreach ( $terms as $term ) {

            $arraTerms[] = array( "id_term" => $term->term_id, "term" => $term->name ); // set de array por item
        
        }
     
    endif;

    // var_dump( $arraTerms );

    // minimo precio
    $min_price = 0;

    //renderizado de planes por categoría.
    $render_plans = '';

    // loop de array con ids de terms
    //$counter_terms
    $counter_terms = 0;
    $render_features_name = '';
    foreach( $arraTerms as $key => $arrT ){
        
        $args_inside = array	(
            'post_type' => 'plan',
            'post_status' => 'publish',
            'posts_per_page' => 3,
            'meta_key'    => 'precio',
            'orderby'   =>  'meta_value_num',
            'order'    => 'ASC',
        );

        $args_inside['meta_query'] = array( 
            'relation'		=> 'AND',
            array(
                'key' => 'proveedor_pertenece',
                'value' => '"'. $idPost. '"',
                'compare' => 'like'
            ),
            array(
                'key' => 'tipos_de_hosting_validos',
                'value' => '"'. $arrT["id_term"] . '"',
                'compare' => 'like'
            ),
        );

        // Query con argumentos
        $post_types_plans = new WP_Query( $args_inside );

        // get de posts de la query
        $posts = $post_types_plans->get_posts();
                        
        // variables de recuperación por item
        /* variables para control de features */
        $features_plan = array();
        /* Contador de control para saber si existen planes */
        $count_this_while = 0;

        $display_none = "";
        if( $counter_terms != 0 ){
            $display_none = 'none';
        }

        $render_features_name .= '<table class="item_'. $arrT["id_term"] .'-toggle-btn" style="display: '. $display_none .';">';

        foreach($posts as $po){
            
            if($count_this_while == 0){
                    
                $value_price = get_field( 'precio', $po->ID );
                $value_price = number_format((float)round( $value_price, 2), 2, '.', '');
                $min_price = ( $min_price == 0 ) ? $value_price : $min_price;

                $icono_redondo_card =   '
                                            <img src=" ' . get_stylesheet_directory_uri() . '/img/elementos/plan1-01.svg' . ' " />  
                                        ';

                $render_plans .=    '
                                        <div class="plan_card item_'. $arrT["id_term"] .'-toggle-btn" term_plan="'. $arrT["id_term"] .'-toggle-btn" style="display: '. $display_none .';">
                                            <div class="_1">
                                                <h5>'. get_field( 'shortname_plan', $po->ID ) .'</h5>
                                                <span>Desde</span>
                                                <h3>$'. $min_price .'</h3>
                                                <div class="rounded_div_">
                                                    '. $icono_redondo_card .'
                                                </div>
                                            </div>
                                            <div class="_2">
                                                <table>
                                    ';

                $array_fetaures_post_meta = get_post_meta( $po->ID, "plan_features");
                $features_plan = '';
                if( count( $array_fetaures_post_meta ) > 0 ){
                        
                    foreach( $array_fetaures_post_meta as $arr ){
                                        
                        foreach( $arr as $key => $pa){

                            if( $key == 0 ){ $border_top = 'solid 1px #dddddd'; }else{ $border_top = ''; }
                            if( $pa["dato"] ){

                                $render_features_name .= '<tr><td style="border-top: '. $border_top .' ;">'. $pa["name"]. '</td></tr>';
                                if( $pa["dato"] == "opt-unlimited" ){

                                    $features_plan .=  '<tr><td style="border-top: '. $border_top .' ;"> Ilimitado </td></tr>';

                                }else{
                                    
                                    $features_plan .=  '<tr><td style="border-top: '. $border_top .' ;">'. $pa["dato"] .'</td></tr>';

                                } 
                            
                            }   
                            else{

                                $features_plan .=  '<tr><td style="border-top: '. $border_top .' ;"> <i class="fa fa-times gray-color-item" style="margin-right: 5px;"></i> </td></tr>';
                            
                            }  
                            
                        }

                    }
                
                }else{
                        
                        $feats_ = get_option( 'filtros_hosting_data' );
                        foreach( $feats_ as $arr ){
                                
                            $features_plan .=  '<tr><td> <i class="fa fa-times gray-color-item" style="margin-right: 5px;"></i> </td></tr>';
                        
                        }

                }

                $render_plans .=    $features_plan . 
                                    '
                                            </table>
                                        </div>
                                        <a href="'. $url_afiliado .'" target="_blank" rel="noopener noreferrer" class="btn btn-secondary">Ver más</a>
                                    </div>
                                    ';

            }else{

                $price_mvp = get_field( 'precio', $po->ID );
                $price_mvp = $media_score = number_format((float)round( $price_mvp, 2), 2, '.', '');

                if( $count_this_while == 2 ){ $border_right = "solid 1px #dddddd"; }else{ $border_right = ''; }
                if( $count_this_while == 1 ){ $clase_hovered = 'hover_eterno'; }else{ $clase_hovered = ''; }
                if($count_this_while == 1){
                    
                    $icono_redondo_card =   '
                                            <img src=" ' . get_stylesheet_directory_uri() . '/img/elementos/plan2-01.svg' . ' " />  
                                            ';

                }
                if($count_this_while == 2){
                    
                    $icono_redondo_card =   '
                                            <img src=" ' . get_stylesheet_directory_uri() . '/img/elementos/plan3-01.svg' . ' " />  
                                            ';

                }
                $render_plans .=    '
                                        <div class="plan_card '. $clase_hovered .' item_'. $arrT["id_term"] .'-toggle-btn" term_plan="'. $arrT["id_term"] .'-toggle-btn" style="display: '. $display_none .';">
                                            <div class="_1">
                                                <h5>'. get_field( 'shortname_plan', $po->ID ) .'</h5>
                                                <span>Desde</span>
                                                <h3>$'. $price_mvp .'</h3>
                                                <div class="rounded_div_">
                                                    '. $icono_redondo_card .'
                                                </div>
                                            </div>
                                            <div class="_2" style="border-right: '. $border_right .';">
                                                <table>
                                    ';

                $array_fetaures_post_meta = get_post_meta( $po->ID, "plan_features");
                $features_plan = '';
                if( count( $array_fetaures_post_meta ) > 0 ){
                        
                    foreach( $array_fetaures_post_meta as $arr ){
                                        
                        foreach( $arr as $key => $pa){

                            if( $key == 0 ){ $border_top = 'solid 1px #dddddd'; }else{ $border_top = ''; }
                            if( $pa["dato"] ){

                                if( $pa["dato"] == "opt-unlimited" ){

                                    $features_plan .=  '<tr><td style="border-top: '. $border_top .' ;"> Ilimitado </td></tr>';

                                }else{
                                    
                                    $features_plan .=  '<tr><td style="border-top: '. $border_top .' ;">'. $pa["dato"] .'</td></tr>';

                                } 
                            
                            }   
                            else{

                                $features_plan .=  '<tr><td style="border-top: '. $border_top .' ;"> <i class="fa fa-times gray-color-item" style="margin-right: 5px;"></i> </td></tr>';
                            
                            }  
                            
                        }

                    }
                
                }else{
                        
                        $feats_ = get_option( 'filtros_hosting_data' );
                        foreach( $feats_ as $arr ){
                                
                            $features_plan .=  '<tr><td> <i class="fa fa-times gray-color-item" style="margin-right: 5px;"></i> </td></tr>';
                        
                        }

                }

                $render_plans .=    $features_plan .
                                    '
                                            </table>
                                        </div>
                                        <a href="'. $url_afiliado .'" target="_blank" rel="noopener noreferrer" class="btn btn-secondary">Ver más</a>
                                    </div>
                                    ';

            }

            $count_this_while++;
            
        }

        $render_features_name .= '</table>';

        $counter_terms++;

    }

    if( $imagenCarrusel1 && $imagenCarrusel1 != NULL && $imagenCarrusel1 != null && $imagenCarrusel1 != '' ){

        $printImg1 =    '
                        <div class="item-carrusel">
                            <div class="imagerrusel">
                                <img src=" '. $imagenCarrusel1 .' " />
                            </div>
                            <div class="hoverrusel">
                            </div>
                            <a class="contenidoHover" href="'. $url_afiliado .'" target="_blank" rel="noreferrer noopener nofollow">
                                <img src=" '. get_stylesheet_directory_uri() . "/img/elementos/gositio-01.svg" .' " />
                                <hr />
                                <h5>Ir al sitio web</h5>
                            </a>
                        </div>
                        ';
    }else{
        $printImg1 = '';
    }


    if( $imagenCarrusel2 && $imagenCarrusel2 != NULL && $imagenCarrusel2 != null && $imagenCarrusel2 != '' ){

        $printImg2 =    '
                        <div class="item-carrusel">
                            <div class="imagerrusel">
                                <img src=" '. $imagenCarrusel2 .' " />
                            </div>
                            <div class="hoverrusel">
                            </div>
                            <a class="contenidoHover" href="'. $url_afiliado .'" target="_blank" rel="noreferrer noopener nofollow">
                                <img src=" '. get_stylesheet_directory_uri() . "/img/elementos/gositio-01.svg" .' " />
                                <hr />
                                <h5>Ir al sitio web</h5>
                            </a>
                        </div>
                        ';
    }else{
        $printImg2 = '';
    }


    if( $imagenCarrusel3 && $imagenCarrusel3 != NULL && $imagenCarrusel3 != null && $imagenCarrusel3 != '' ){

        $printImg3 =    '
                        <div class="item-carrusel">
                            <div class="imagerrusel">
                                <img src=" '. $imagenCarrusel3 .' " />
                            </div>
                            <div class="hoverrusel">
                            </div>
                            <a class="contenidoHover" href="'. $url_afiliado .'" target="_blank" rel="noreferrer noopener nofollow">
                                <img src=" '. get_stylesheet_directory_uri() . "/img/elementos/gositio-01.svg" .' " />
                                <hr />
                                <h5>Ir al sitio web</h5>
                            </a>
                        </div>
                        ';
    }else{
        $printImg3 = '';
    }

    if( $imagenCarrusel4 && $imagenCarrusel4 != NULL && $imagenCarrusel4 != null && $imagenCarrusel4 != '' ){

        $printImg4 =    '
                        <div class="item-carrusel">
                            <div class="imagerrusel">
                                <img src=" '. $imagenCarrusel4 .' " />
                            </div>
                            <div class="hoverrusel">
                            </div>
                            <a class="contenidoHover" href="'. $url_afiliado .'" target="_blank" rel="noreferrer noopener nofollow">
                                <img src=" '. get_stylesheet_directory_uri() . "/img/elementos/gositio-01.svg" .' " />
                                <hr />
                                <h5>Ir al sitio web</h5>
                            </a>
                        </div>
                        ';
    }else{
        $printImg4 = '';
    }

    if( $imagenCarrusel5 && $imagenCarrusel5 != NULL && $imagenCarrusel5 != null && $imagenCarrusel5 != '' ){

        $printImg5 =    '
                        <div class="item-carrusel">
                            <div class="imagerrusel">
                                <img src=" '. $imagenCarrusel5 .' " />
                            </div>
                            <div class="hoverrusel">
                            </div>
                            <a class="contenidoHover" href="'. $url_afiliado .'" target="_blank" rel="noreferrer noopener nofollow">
                                <img src=" '. get_stylesheet_directory_uri() . "/img/elementos/gositio-01.svg" .' " />
                                <hr />
                                <h5>Ir al sitio web</h5>
                            </a>
                        </div>
                        ';
    }else{
        $printImg5 = '';
    }

    if( $imagenCarrusel6 && $imagenCarrusel6 != NULL && $imagenCarrusel6 != null && $imagenCarrusel6 != '' ){

        $printImg6 =    '
                        <div class="item-carrusel">
                            <div class="imagerrusel">
                                <img src=" '. $imagenCarrusel6 .' " />
                            </div>
                            <div class="hoverrusel">
                            </div>
                            <a class="contenidoHover" href="'. $url_afiliado .'" target="_blank" rel="noreferrer noopener nofollow">
                                <img src=" '. get_stylesheet_directory_uri() . "/img/elementos/gositio-01.svg" .' " />
                                <hr />
                                <h5>Ir al sitio web</h5>
                            </a>
                        </div>
                        ';
    }else{
        $printImg6 = '';
    }

    $carrusel_render =  '
                            <div class="owl-carousel carrusel" 
                                 data-carousel-items="3"
                                 data-carousel-margin="10"
                                 data-carousel-nav="false"
                                 data-carousel-dots="true"
                                 data-carousel-autoplay="true"
                                 data-carousel-loop="true"
                                 data-carousel-responsive=\'{"0":{"items":"1"},"576":{"items": "2"},"768":{"items":"2"},"960":{"items":"3"}}\'
                            >
                                
                                '. $printImg1 . $printImg2 . $printImg3 . $printImg4 . $printImg5 . $printImg6 .'  
                                
                            </div>
                        ';

?>

<div id="pageContent" class="pd--100-0 primary_content_single_proveedor">
    
        <div class="banner_header_single_proveedor" style="background-image: url('<?php echo $singlebanner; ?>');">

            <div class="nubes_banner" style="">
                <div class="header_box1">
                    <img src=" <?php echo $imgDestacada; ?> " >
                    <h1><?php echo $name_proveedor; ?></h1>
                    <span>Comparahosting.com te ayuda a elegir el mejor proveedor de hosting para tu nuevo proyecto o empresa.</span>   
                    <a href="<?php echo $url_afiliado; ?>" target="_blank" rel="noopener noreferrer" class="btn btn-secondary">Comienza ahora</a>        
                </div>
                <div class="header_box2">

                    <div class="item-column-element">

                        <span class="texto_price">Desde</span>
                        <span class="texto_price">$<?php echo $min_price; ?></span>
                        <span class="cardviews-puntuacion-style-custom"><?php echo $puntuacion; ?></span>
                        <ul id="stars">
                            <?php echo $score_component; ?>
                        </ul>          
                        <a href="<?php echo $url_afiliado; ?>" target="_blank" rel="noopener noreferrer" class="btn btn-secondary" >Ver más</a>
                        
                    </div>

                </div>
            </div>

        </div>
    
        <div class="container">

            <div class="row page--container">
                
                <div class="section1">
                    
                    <div class="container_img_title"> 
                        <h3>Lo que debes saber sobre <?php echo $name_proveedor; ?></h3>
                        <img src="<?php echo $imagenContenido; ?>" >
                    </div>
                    <div class="container_texto">
                        <span class="texto">
                                <?php echo get_the_content( $idPost ); ?>
                        </span>
                    </div>

                </div>
            
            </div>
        
        </div>

        <div class="container">

            <div class="row page--container">
                
                <div class="section1 carrusel_section_proveedores">
                    
                    <h1>Interfaz visual de usuario Digital Ocean</h1>
                    <?php echo $carrusel_render; ?>

                </div>

            </div>
        
        </div>

        <div class="section2">

            <p>Principales ventajas del servicio de hosting</p>
            <h1>Características Exclusivas</h1>

            <div style="display: flex; background-color: #fc466b; width: 100%; margin: 50px auto;">
                <div class="caracteristicas_exclusivas">
                    <div class="elemento_exclusive_caracteristicas">
                        <div class="icono"><div style="width: 70px; height: 70px; border-radius: 75px; background-color: #FFF; display: flex; justify-content: center; align-items: center; align-content: center;"><img src="<?php echo get_stylesheet_directory_uri() . '/img/elementos/garantia.svg'; ?>" /></div></div>
                        <div class="contenido"><?php echo $antes_de_garantia . $garantia_parametro; ?></div>
                    </div>
                    <div class="elemento_exclusive_caracteristicas">
                        <div class="icono"><div style="width: 70px; height: 70px; border-radius: 75px; background-color: #FFF; display: flex; justify-content: center; align-items: center; align-content: center;"><img src="<?php echo get_stylesheet_directory_uri() . '/img/elementos/ssl.svg'; ?>" /></div></div>
                        <div class="contenido"><?php echo "SSL " . $ssl_parametro; ?></div>
                    </div>
                    <div class="elemento_exclusive_caracteristicas">
                        <div class="icono"><div style="width: 70px; height: 70px; border-radius: 75px; background-color: #FFF; display: flex; justify-content: center; align-items: center; align-content: center;"><img src="<?php echo get_stylesheet_directory_uri() . '/img/elementos/dominio.svg'; ?>" /></div></div>
                        <div class="contenido"><?php echo "Dominio " . $dominio_parametro; ?></div>
                    </div>
                    <div class="elemento_exclusive_caracteristicas">
                        <div class="icono"><div style="width: 70px; height: 70px; border-radius: 75px; background-color: #FFF; display: flex; justify-content: center; align-items: center; align-content: center;"><img src="<?php echo get_stylesheet_directory_uri() . '/img/elementos/soporte_espa.svg'; ?>" /></div></div>
                        <div class="contenido"><?php echo $si_hay_soporte; ?></div>
                    </div>
                </div>
            </div>

        </div>

        <div class="section3">
            
            <div class="pricing--filter toggle-btn-content toggle_btn_providers_control">
                <ul class="selector-changue-mode-view">
                    <li class="indicator" style="left: -5px; width: 129px;"></li>	
                    <?php
                        $counter = 0;
                        foreach( $arraTerms as $key => $arrT ){
                            
                            if( $counter == 0 ){
                                echo '<li id="'. $arrT["id_term"] .'-toggle-btn" class="active"><a href="#pricingTab'. $arrT["id_term"] .'" role="tab" data-toggle="tab">'. $arrT["term"] .'</a></li>';
                            }else{
                                echo '<li id="'. $arrT["id_term"] .'-toggle-btn" class=""><a href="#pricingTab'. $arrT["id_term"] .'" role="tab" data-toggle="tab">'. $arrT["term"] .'</a></li>';
                            }
                            $counter++;

                        }
                    ?>
                </ul>
            </div>

            <p>Descubre y compara los distintos planes y precios según tu conveniencia</p>
            <h1>Planes y precios</h1>
            <hr />

            <div class="planes_pricing_post">
                <div class="planes_features_container">
                    <div class="_1">
                        <h4>Lista de configuración</h4>
                        <div class="rounded_div_"></div>
                    </div>
                    <div class="_2">
                        <?php echo $render_features_name; ?> 
                    </div>
                    <a class="btn btn-secondary">""</a>
                </div>
                <div class="planes_section_container">
                    <?php echo $render_plans; ?>
                </div>
            </div>
            
        </div>

        <div class="section4 padding_lateral">
            <?php $withcomments = 1; comments_template(); ?>
        </div>

</div>

<?php get_footer(); ?>

<style>

</style>




