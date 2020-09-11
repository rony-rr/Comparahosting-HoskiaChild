<?php

    function top5_sidebar( $atts ){

        $var_content_html = '';
        $var_js = '';


        $value_acf_tag = get_field( "category_include" );
        $value_acf_tag = ( $value_acf_tag == NULL || $value_acf_tag == null || $value_acf_tag == 'NULL' || $value_acf_tag == '' || empty( $value_acf_tag ) ) ? 306 : $value_acf_tag;
        // var_dump( $value_acf_tag );

        $a = shortcode_atts( array(
            'categ' =>  $value_acf_tag
        ), $atts );


        $term_find = $a["categ"];

        $term_recovered = get_term( $term_find, 'tipo' );
        // var_dump( $term_recovered );

        $var_content_html .=    '
                                    <div class="top5_sidebar">
                                        <h4 class="h4_title">Top 5 '. $term_recovered->name .'</h4>
                                ';

        
        // Arrays de posts por categoria
        $array_de_posts = array();

        if( $term_recovered->term_id == 305 ){
            $array_de_posts = array( 10769, 10820, 10805, 10802, 10772 );
        }
        if( $term_recovered->term_id == 312 ){
            $array_de_posts = array( 10820, 10784, 10775, 10778, 10802 );
        }
        if( $term_recovered->term_id == 308 ){
            $array_de_posts = array( 10769, 10775, 10778, 10772, 10790 );
        }
        if( $term_recovered->term_id == 307 ){
            $array_de_posts = array( 10820, 10775, 10814, 10817, 10787 ); 
        }
        if( $term_recovered->term_id == 306 ){
            $array_de_posts = array( 10769, 10823, 10820, 10775, 10778 );
        }
        if( $term_recovered->term_id == 309 ){
            $array_de_posts = array( 11481, 10820, 10775, 10799, 10778);
        }
        // var_dump( $array_de_posts );


        //Llamada a los posts
        $args = array(
            'post_type' => 'proveedor',
            'posts_per_page' => 5,
            'post_status'  => 'publish',
            'tax_query' => array(
                array(
                    'taxonomy' => 'tipo',
                    'field' => 'term_id',
                    'terms' => $term_recovered->term_id,
                )
            ),
            'post__in' => $array_de_posts,
            'meta_key'    => 'media_de_puntuaciones',
            'orderby'   =>  'meta_value_num',
            'order'    => 'DESC',
        );

        $news_query = new WP_Query( $args );
        $counter_items = 0;

        if ( $news_query->have_posts() ) {
      
                  while ( $news_query->have_posts() ) {

                        $news_query->the_post(); 

                        $puntuacion = get_post_meta( get_the_ID(), "media_de_puntuaciones" );
                        
                        $puntuacion = number_format((float)round( $puntuacion[0], 1), 1, '.', '');

                        $var_this_post = get_the_ID();

                        $loguito = get_field( 'logo' );
                        $url_de_afiliados = get_field( 'url_afiliado' );

                        $thumbID = get_post_thumbnail_id( $var_this_post );
                        $imgDestacada = wp_get_attachment_url( $thumbID );

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
                                                                'value' => '"'. $term_recovered->term_id . '"',
                                                                'compare' => 'like'
                                                            ),
                            ),
                            'meta_key' => 'precio',
                            'orderby'   =>  'meta_value_num',
                            'order'   => 'ASC',
                        );


                        $post_types_plan = new WP_Query( $args_inside );
                        $posts_act = $post_types_plan->get_posts();
                        // var_dump( get_the_title($var_this_post) );
                        $price_cheap_plan = 0;

                        foreach( $posts_act as $ann ){

                            if( $price_cheap_plan == 0 ){

                                $price_cheap_plan = get_field( 'precio', $ann->ID );
                                $identify_plan = $ann->ID;
                                // var_dump( $price_cheap_plan ); 

                            }
                        
                        }

                        $clase_extra = '';
                        if( $counter_items == 0 ){
                            $clase_extra = 'first_item';
                        }

                        $var_content_html .=    '
                                                    <a class="host_item '. $clase_extra .'" href="'. $url_de_afiliados .'" target="_blank" rel="noopener noreferrer">
                                                        <img class="img_color" src="'. $loguito .'" />
                                                        <img class="img_white" src="'. $imgDestacada .'" />

                                                        <span>'. $score_component .'</span>

                                                        <div class="price_item">
                                                            <span><p class="text_item" style="font-size: 10px; ">Desde</p></span>
                                                            <span><p class="text_item">$'. $price_cheap_plan .'</p></span>
                                                        </div>
                                                    </a>
                                                ';

                        $counter_items++;
                  }
        
        }

        $var_content_html .= '</div>';

        $var_return = $var_content_html . $var_js;
        return $var_return;

    }

    add_shortcode('top5_sidebar', 'top5_sidebar');

?>