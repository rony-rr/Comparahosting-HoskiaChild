<?php

// funcion que recupera el plan mas barato por proveedor
function get_cheap_plan($post_typess){

    $posts_act = $post_typess->get_posts();
    
    $vari = 0;
    $identify_plan = null;
    $arr_ret = array();

    foreach( $posts_act as $ann ){
        
        // echo $ann->ID . " " . get_field( 'precio', $ann->ID );
        // echo "<br /><br />";

        if( $vari == 0 || $vari == NULL || $vari == null || $vari == "NULL" ){
                
            $vari = get_field( 'precio', $ann->ID );
            $identify_plan = $ann->ID;

        } 
        else{
            $vari = $vari;
        }  
    
    }

    if( $vari == 0 ){
                
        $vari = 12.5;
        $identify_plan = 10165;
    
    }

    $vari = number_format((float)round( $vari, 2), 2, '.', '');

    $arr_ret = array(
        "minimo_precio" => $vari,
        "ID_plan" => $identify_plan
    );
    // var_dump( $arr_ret );
    // echo "<br /><br />";

    return $arr_ret;

}




function cardviews_custom_list_nav(){
    
    $header = '<div class="nav-list-top5-class text-center"><ul class="ch-categories">';
    $footer = '</ul></div>';
    $content = "";

    //cards Estructura
    $header_card = "";
    $footer_card = '';
    $content_card= "";
    $final_card = "";
    $i = 1;

    $catsArray = array( 306, 305, 312, 308, 307, 309 );
    $category = get_terms( array(
          'taxonomy' => 'tipo',
          'number'  =>  6,
          'offset'  =>  $offset,
          'include' => $catsArray,
          'hide_empty'  => false, 
          'orderby'  => 'include',
        ) );
    
     
    //$category = get_terms('tipo',array('number' => '5'));


    foreach($category as $cat) { 
       
        if ($cat === reset($category)) {
            $a = "active";
            $b = "";
        }else{
            $a = "unactive";
            $b = 'style="display:none"';
        }
       $name_category = str_replace("Hosting", "", $cat->name);
       $name_category = ( $name_category == "Servidores Dedicados" ) ? $name_category : str_replace(" ", "", $name_category);
       $content = $content."<li class='ch-categories-item'><a class='categoria".$cat->term_id." ".$a."'>". $name_category ."</a></li>";

       
        // Arrays de posts por categoria
        $array_de_posts = array();

        if( $cat->term_id == 305 ){
            $array_de_posts = array( 10769, 10820, 10805, 10802, 10772 );
        }
        if( $cat->term_id == 312 ){
            $array_de_posts = array( 10820, 10784, 10775, 10778, 10802 );
        }
        if( $cat->term_id == 308 ){
            $array_de_posts = array( 10769, 10775, 10778, 10772, 10790 );
        }
        if( $cat->term_id == 307 ){
            $array_de_posts = array( 10820, 10775, 10814, 10817, 10787 ); 
        }
        if( $cat->term_id == 306 ){
            $array_de_posts = array( 10769, 10823, 10820, 10775, 10778 );
        }
        if( $cat->term_id == 309 ){
            $array_de_posts = array( 11481, 10820, 10775, 10799, 10778);
        }

        /// Llamo a los POST

        $args = array(
            'post_type' => 'proveedor',
            'posts_per_page' => 5,
            'post_status'  => 'publish',
            'tax_query' => array(
                array(
                    'taxonomy' => 'tipo',
                    'field' => 'term_id',
                    'terms' => $cat->term_id,
                )
            ),
            'post__in' => $array_de_posts,
            'meta_key'    => 'media_de_puntuaciones',
            'orderby'   =>  'meta_value_num',
            'order'    => 'DESC',
       );

       $categoria_id = $cat->term_id;
       $categoria_slug = $cat->slug;
       
       $news_query = new WP_Query( $args );

       if ( $news_query->have_posts() ) {
      //var_dump($news_query);
        $var_count_whi_cats = 0;

            while ( $news_query->have_posts() ) {
                
                        $news_query->the_post(); 

                        $puntuacion = get_post_meta( get_the_ID(), "media_de_puntuaciones" );
                        
                        $puntuacion = number_format((float)round( $puntuacion[0], 1), 1, '.', '');

                        $var_this_post = get_the_ID();

                        $loguito = get_field( 'logo' );
                        $url_de_afiliados = get_field( 'url_afiliado' );


                        $variable_ssl = get_field( 'ssl', $var_this_post );
                        $variable_dominio = get_field( 'dominio', $var_this_post );
                        $variable_garantia = get_field( 'garantia', $var_this_post );
                        $variable_soporte_24_7 = get_field( 'soporte_24_7', $var_this_post )[0]["label"];
                        $variable_soporte_chat = get_field( 'soporte_chat', $var_this_post )[1]["label"];

                
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


                        $args_inside = array	(
                            'post_type' => 'plan',
                            'post_status' => 'publish',
                            'posts_per_page' => 3,
                            'meta_query'        => array( 
                                                            'relation'		=> 'AND',
                                                            array(
                                                                'key' => 'proveedor_pertenece',
                                                                'value' => '"'. $var_this_post .'"',
                                                                'compare' => 'like'
                                                            ),
                                                            array(
                                                                'key' => 'tipos_de_hosting_validos',
                                                                'value' => '"'. $categoria_id . '"',
                                                                'compare' => 'like'
                                                            ),
                            ),
                            'meta_key' => 'precio',
                            'orderby'   =>  'meta_value_num',
                            'order'   => 'ASC',
                        );

                        // var_dump( $var_this_post );
                        // echo "<br /><br />";

                        $post_types_plans = new WP_Query( $args_inside );

                        // var_dump( $post_types_plans );
                        // echo "<br /><br />";
            
                        if($var_count_whi_cats == 0){

                                $arr_recu = get_cheap_plan($post_types_plans);
                                $var_price_min = $arr_recu["minimo_precio"];
                                $id_del_plan_minimo = $arr_recu["ID_plan"];

                                // var_dump( $arr_recu );
                                // echo "<br /><br />";


                                $array_de_caracteristicas_a_renderizar = array();

                                $counter_to_features_render = 0;
                                $array_caracteristicas_plan = get_post_meta( $id_del_plan_minimo, "plan_features");


                                foreach( $array_caracteristicas_plan as $arr ){
                                    
                                    foreach( $arr as $key => $po){
                                        
                                        if( $po["dato"] && $counter_to_features_render < 3){
                                            
                                            $dato = ($po["dato"] === 'opt-unlimited') ? "Ilimitado" : $po["dato"];
                                            $string_tmp_fet =  $po["name"]. " - " .$dato;
                                            $longitud_strtmp = strlen( $string_tmp_fet );
                                            
                                            if( $longitud_strtmp < 28 ){
                                            
                                                array_push( $array_de_caracteristicas_a_renderizar, $string_tmp_fet);
                                                $counter_to_features_render++;

                                            }
                                            
                                            

                                        }
                                        if( $counter_to_features_render >= 3){
                                            
                                            break;

                                        }

                                    }

                                }

                                if( $var_price_min != 0 ){

                                    $ch_feat1 = $array_de_caracteristicas_a_renderizar[0] ? '<p class="line-caracteristica-cardviews-home line-caracteristica-hover-cardviews-home">'. $array_de_caracteristicas_a_renderizar[0] .'</p>' : '';
                                    $ch_feat2 = $array_de_caracteristicas_a_renderizar[1] ? '<p class="line-caracteristica-cardviews-home line-caracteristica-hover-cardviews-home">'. $array_de_caracteristicas_a_renderizar[1] .'</p>' : '';
                                    $ch_feat3 = $array_de_caracteristicas_a_renderizar[2] ? '<p class="line-caracteristica-cardviews-home line-caracteristica-hover-cardviews-home">'. $array_de_caracteristicas_a_renderizar[2] .'</p>' : '';
                                    
                                    $soporte1 = '';
                                    $soporte2 = '';
                                    $soporte3 = '';

                                    $soporte_var = get_field( 'soporte', $var_this_post );
                                    foreach( $soporte_var as $sopo ){

                                        if( $soporte1 == '' && $sopo == 1 ){
                                            
                                            $soporte1 = 'Soporte 24/7';
                                        
                                        }elseif( $soporte1!= '' && $sopo == 2 && $soporte2 == '' ){

                                            $soporte2 = 'Soporte en español';
                                        
                                        }elseif( $soporte1 == '' && $sopo == 2 ){

                                            $soporte1 = 'Soporte en español';

                                        }elseif( $soporte1 != '' && $soporte2 == '' && $sopo == 3){

                                            $soporte2 = 'Chat Online';

                                        }elseif( $soporte1 == '' && $soporte2 != 'Chat Online'){

                                            $soporte1 = 'Chat Online';

                                        }else{
                                            
                                            $soporte1 = 'Monitoreo del Servidor';
                                        
                                        }
                                    
                                    }
                                    

                                    $ch_feat2 = $ch_feat2 !== '' ? $ch_feat2 : '<p class="line-caracteristica-cardviews-home line-caracteristica-hover-cardviews-home">'. $soporte1 .'</p>';
                                    $ch_feat3 = $ch_feat3 !== '' ? $ch_feat3 : '<p class="line-caracteristica-cardviews-home line-caracteristica-hover-cardviews-home">'. $soporte2 .'</p>';

                                    $content_card = $content_card.'
                                    <div class="card-view-element-css-custom-style wpb_column vc_column_container vc_col-sm-1/5">
                                        
                                        <div class="container-cardsview-home">
                                                
                                                <div class="content-cardviews-home info-hover-cardviews-content">
                                                    <img src="'. $loguito .'" class="cardviews-img-custom-style" />
                                                    '. $ch_feat1 .'
                                                    '. $ch_feat2 .'
                                                    '. $ch_feat3 .' 
                                                </div>
        
                                                <div class="content-cardviews-home info-cardviews-content">
                                                    <img src="'. $loguito .'" class="cardviews-img-custom-style" />
                                                        <div class="content-internal-row">
                                                            <div class="col-sm-4" style="height: 100%;">
                                                                <div class="class-cup-icon-host"><img style="display: block; margin: auto; transform: translateX(24px);" src="'.get_stylesheet_directory_uri().'/img/cup.svg" /></div>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <p class="cardviews-price-style-custom"><a>Desde</a> <br /> $'. $var_price_min .'</p>
                                                                <p class="cardviews-puntuacion-style-custom">'.$puntuacion.'</p>
                                                            </div>
                                                        </div>
                                                    <!-- Rating Stars Box -->
                                                    <div class="rating-stars text-center">
                                                        <ul id="stars">
                                                            '. $score_component .'
                                                        </ul>
                                                    </div>
                                                    <!-- End star ratings box -->
                                                </div>
                                                
                                                <div class="end-bottom-button-ver-mas-cardviews">
                                                    <a href="'. $url_de_afiliados .'" class="cardview-button-custom-style" target="_blank">Ver más</a>
                                                </div>
                                        </div>
        
                                    </div>';  

                                }

                                else{
                                    null;
                                }
                        
                                
                        } 
                        else{

                            $arr_recu = get_cheap_plan($post_types_plans);
                            $var_price_min = $arr_recu["minimo_precio"];
                            $id_del_plan_minimo = $arr_recu["ID_plan"];

                            // var_dump( $arr_recu );
                            // echo "<br /><br />";

                            $array_de_caracteristicas_a_renderizar = array();

                            $counter_to_features_render = 0;
                            $array_caracteristicas_plan = get_post_meta( $id_del_plan_minimo, "plan_features");

                            foreach( $array_caracteristicas_plan as $arr ){
                                
                                foreach( $arr as $key => $po){
                                    
                                    if( $po["dato"] && $counter_to_features_render < 3){
                                        
                                        $dato = ($po["dato"] === 'opt-unlimited') ? "Ilimitado" : $po["dato"];
                                        $string_tmp_fet =  $po["name"]. " - " .$dato;
                                        $longitud_strtmp = strlen( $string_tmp_fet );

                                            
                                            if( $longitud_strtmp < 28 ){
                                            
                                                array_push( $array_de_caracteristicas_a_renderizar, $string_tmp_fet);
                                                $counter_to_features_render++;

                                            }

                                    }
                                    if( $counter_to_features_render >= 3){
                                        
                                        break;

                                    }

                                }

                            }

                            if( $var_price_min != 0 ){

                                    $ch_feat1 = $array_de_caracteristicas_a_renderizar[0] ? '<p class="line-caracteristica-cardviews-home line-caracteristica-hover-cardviews-home">'. $array_de_caracteristicas_a_renderizar[0] .'</p>' : '';
                                    $ch_feat2 = $array_de_caracteristicas_a_renderizar[1] ? '<p class="line-caracteristica-cardviews-home line-caracteristica-hover-cardviews-home">'. $array_de_caracteristicas_a_renderizar[1] .'</p>' : '';
                                    $ch_feat3 = $array_de_caracteristicas_a_renderizar[2] ? '<p class="line-caracteristica-cardviews-home line-caracteristica-hover-cardviews-home">'. $array_de_caracteristicas_a_renderizar[2] .'</p>' : '';


                                    $soporte1 = '';
                                    $soporte2 = '';
                                    $soporte3 = '';

                                    $soporte_var = get_field( 'soporte', $var_this_post );
                                    foreach( $soporte_var as $sopo ){

                                        if( $soporte1 == '' && $sopo == 1 ){
                                            
                                            $soporte1 = 'Soporte 24/7';
                                        
                                        }elseif( $soporte1!= '' && $sopo == 2 && $soporte2 == '' ){

                                            $soporte2 = 'Soporte en español';
                                        
                                        }elseif( $soporte1 == '' && $sopo == 2 ){

                                            $soporte1 = 'Soporte en español';

                                        }elseif( $soporte1 != '' && $soporte2 == '' && $sopo == 3){

                                            $soporte2 = 'Chat Online';

                                        }else{

                                            $soporte1 = 'Chat Online';
                                        }
                                    
                                    }
                                    


                                    $ch_feat2 = $ch_feat2 !== '' ? $ch_feat2 : '<p class="line-caracteristica-cardviews-home line-caracteristica-hover-cardviews-home">'. $soporte1 .'</p>';
                                    $ch_feat3 = $ch_feat3 !== '' ? $ch_feat3 : '<p class="line-caracteristica-cardviews-home line-caracteristica-hover-cardviews-home">'. $soporte2 .'</p>';



                                    $content_card = $content_card . 
                                        '<div class="card-view-element-css-custom-style wpb_column vc_column_container vc_col-sm-1/5">
                                            
                                            <div class="container-cardsview-home">
                                                    
                                                    <div class="content-cardviews-home info-hover-cardviews-content">
                                                        <img src="'. $loguito .'" class="cardviews-img-custom-style" />                                                    
                                                        '. $ch_feat1 .'
                                                        '. $ch_feat2 .'
                                                        '. $ch_feat3 .'                                         
                                                    </div>

                                                    <div class="content-cardviews-home info-cardviews-content">
                                                        <img src="'. $loguito .'" class="cardviews-img-custom-style" />
                                                        
                                                        <p class="cardviews-price-style-custom"><a>Desde</a> <br /> $'. $var_price_min .'</p>
                                                        <p class="cardviews-puntuacion-style-custom">'.$puntuacion.'</p>
                                                        <!-- Rating Stars Box -->
                                                        <div class="rating-stars text-center">
                                                            <ul id="stars">
                                                                '. $score_component .'
                                                            </ul>
                                                        </div>
                                                        <!-- End star ratings box -->
                                                    </div>
                                                    
                                                    <div class="end-bottom-button-ver-mas-cardviews">
                                                        <a href="'. $url_de_afiliados .'" class="cardview-button-custom-style" target="_blank">Ver más</a>
                                                    </div>
                                            </div>
                                            
                                        </div>';
                            }
                            else{
                                null;
                            }
                        } 
                        
                        $var_count_whi_cats++;

                        // $args_inside = array();
                        // $post_types_plans = array();

                    
                        // echo "<br /><br />";
            }

       
      }

      wp_reset_query();

       $header_card = '<div class="class-custom-cards-root-row row categoria'.$cat->term_id.'" '. $b .' >';
       $footer_card = '</div>';
       $final_card = $final_card.$header_card.$content_card.$footer_card;
       $content_card = "";

    }
   
    ?>
    <style>
    .cursor{
    cursor: pointer;
    }
    </style>
    <?php
        $final_content = $header.$content.$footer;
    return $final_content.$final_card; 
}

add_shortcode("cardviews_custom_list_nav", "cardviews_custom_list_nav");






?>