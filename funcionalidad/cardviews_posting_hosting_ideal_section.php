<?php



function cardviews_section_hosting_ideal(){





    // variables de control    

    $var_html_content = '';

    $var_script_js = '';



    $var_html_content .=    '

                                <div class="mb-5 wpb_animate_when_almost_visible wpb_fadeInUp fadeInUp wpb_start_animation animated">
                                    <p> INFÓRMATE EN NUESTRO ARCHIVO VIRTUAL ANTES DE ELEGIR </p>
                                    <h2 class="ch-title seccion_de_titulo" style="color: #303d48 !important; font-weight: 700 !important;">Nuestra biblioteca virtual sobre hosting</h2>

                                    <hr class="ch-subtitle__line">

                                    </hr>

                                    <p class="texto-descriptivo-subtitle">Comparahosting.com te da acceso a múltiples artículos certificados por expertos que te guiarán para reconocer e identificar tu proveedor de hosting más conveniente.</p>

                                </div>



                                <div class="container row" id="ch-post__block">

                            ';



    // argumentos de la consulta WP

    $args = array	(

        'post_type' => 'post',

        'post_status' => 'publish',

        'posts_per_page' => '3',

    );



    // variable de consulta de posts

    $posts = null;	

    $posts = new WP_Query($args);





    // si la consulta devuelve algun post

    if( $posts->have_posts() ){

        $varcounterint = 1;

        $class_manage = '';

        // bucle para recorrer los posts

        while($posts -> have_posts())

        {

            $posts->the_post();

            $post_id = get_the_ID();

            $product = wc_get_product( $post_id );

            $titulo = get_the_title();

			$resumen = (get_field('descripcion_corta_post') == '') ? get_the_excerpt() : get_field('descripcion_corta_post');

			$fecha = get_the_date();

            $enlace = get_permalink();



            switch($varcounterint){

                

                case $varcounterint <= 3 :

                    $class_manage = 'first-show active';

                break;



                // case $varcounterint <= 6 :

                //     $class_manage = 'second-show';

                // break;



                // case $varcounterint <= 9 :

                //     $class_manage = 'third-show';

                // break;



                // case $varcounterint <= 12 :

                //     $class_manage = 'four-show';

                // break;



                default : 

                    null;

                break;



            }


            $thumbID = get_post_thumbnail_id( $post_id );
            $imgDestacada = wp_get_attachment_url( $thumbID );
            

            $var_html_content .=    '

                                        <div class="col-lg-4 col-md-4 col-sm-12 mb-30 '. $class_manage .'">

                                            <div class="ch-card-info">

                                            <a href="'.$enlace.'"> <img src="'. $imgDestacada .'" class="img-responsive px-2" /></a>
                                            <p></p>

                                            <a href="'.$enlace.'" >   <h4 class="mt-4 px-4 title-post-card">'. $titulo .'</h4></a>

                                                <hr class="ch-card__line" align="left">

                                                <p class="ch-card-describe px-4">

                                                    '. $resumen .'

                                                </p>

                                                <div class="text-center py-4">

                                                    <a href="'.$enlace.'" class="btn btn-secondary">Leer más</a>

                                                </div>

                                            </div>

                                        </div>

                                    ';

            

            $varcounterint++;



        }

    }



    wp_reset_query();



    $var_html_content .=    '       

                                </div>

                            '; 



    $var_html_content .=    '

                                <div class="view-more-posts-related">

                                    <a class="view-more-posts-related-button btn btn-primary">Todos los artículos</a>

                                </div>

                            ';





    $var_script_js .=   '

                                <script>

                                    jQuery(document).ready(function(){



                                                                                

                                    });

                                </script>

                        ';









    return $var_html_content . $var_script_js;

}



add_shortcode("cardviews_section_hosting_ideal", "cardviews_section_hosting_ideal");









?>