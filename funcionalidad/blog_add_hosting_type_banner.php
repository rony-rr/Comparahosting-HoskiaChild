<?php

    function add_hosting_type_banner($atts) 
    {
        $args = shortcode_atts(array(
            'tipoh' => 'cloud-hosting'
        ), $atts);

        $uf = $args["tipoh"];

        $category = get_term_by('slug', $uf, 'tipo');

        $url_compose = "https://www.comparahosting.com/tipo/".$uf;
        $image_custom_tax = get_field( 'imagen_header_taxonomy', $category );

        $args = array(
            'post_type' => 'proveedor',
            'posts_per_page' => 3,
            'post_status'  => 'publish',
            'tax_query' => array(
                array(
                    'taxonomy' => 'tipo',
                    'field' => 'term_id',
                    'terms' => $category->term_id,
                )
            ),
            'meta_key'    => 'media_de_puntuaciones',
            'orderby'   =>  'meta_value_num',
            'order'    => 'DESC',
       );

       $query = new WP_Query( $args );
       $array_logos = array();

       if ( $query->have_posts() ) {

            while ( $query->have_posts() ) {

                $query->the_post(); 

                $var_this_post = get_the_ID();
                $loguito = get_field( 'logo' );
                array_push( $array_logos, $loguito );

            }

       }

       $image_component = '';

       foreach( $array_logos as $arr ){
           $image_component .= '<div><img src=" '. $arr .' " class="" /></div>';
       }

       $component_banner =  '
                                <a href="'. $url_compose .'" class="ch-hosting-block">
                                    <div class="ch-hosting-block-img"><img src=" '. $image_custom_tax .' " alt="" /></div>
                                    <div class="ch-hosting-block-content">
                                        <h5>Descubre y compara empresas de '. $category->name .'</h5>
                                        <p>¿Estás buscando un '. $category->name .'? Comparahosting te brinda las mejores comparativas de hosting en español.</p>
                                        <div class="ch-hosting-block-top-3">
                                            ' .$image_component .'    
                                        </div>
                                        <svg viewbox="0 0 1 1" preserveAspectRatio="none"><polygon points="0,0 1,0 1,1" /></svg>
                                    </div>
                                </a>
                            ';


        
        return $component_banner;
    }

    add_shortcode("banner_hosting", "add_hosting_type_banner");



function add_post_blog_banner($atts) 
    {
        $args = shortcode_atts(array(
            'urlp' => 'https://www.comparahosting.com/housing/'
        ), $atts);

        $uf = $args["urlp"];

        $postId = url_to_postid ( $uf );
        $image = get_the_post_thumbnail_url($postId);
        $titlePost = get_the_title( $postId );


        $component_banner = '
                                <div class="ch-post-block">
                                    <div class="ch-post-img">
                                        <img src="'. $image .'" alt="">
                                    </div>
                                    <div class="ch-post-content">
                                        <div class="ch-post-title">
                                            <a href="'. $uf .'"><h5>'. $titlePost .'</h5></a>
                                        </div>
                                        <div class="ch-post-go">
                                            <a href="'. $uf .'">Leer m&aacute;s</a>
                                        </div>
                                    </div>
                                </div>
                            ';


        
        return $component_banner;
    }

    add_shortcode("banner_blog", "add_post_blog_banner");

?>