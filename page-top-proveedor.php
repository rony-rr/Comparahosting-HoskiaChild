<?php 

/* Template Name: Top proveedores */ 

get_header();

// Variables
setlocale(LC_TIME, 'es_ES.UTF-8');
$currentMonth = ucfirst( strftime("%B") );
$currentYear = date("Y");


$catsArray = array( 306, 305, 312, 308, 307, 309 );
$category = get_terms( array(
        'taxonomy' => 'tipo',
        'number'  =>  6,
        'offset'  =>  $offset,
        'include' => $catsArray,
        'hide_empty'  => false, 
        'orderby'  => 'include',
) );



?>

<div id="pageContent" class="pd--100-0 primary_content_single_proveedor top_mejor_hosting">

        <div class="banner_header_single_proveedor" style="background-image: url('<?php echo get_stylesheet_directory_uri() . '/img/elementos/banner_mejor_hosting.png'; ?>');">

            <h1>Las mejores empresas de hosting <br /><?php echo $currentMonth . ' ' . $currentYear; ?></h1>

        </div>

        <div class="container">

            <div class="row page--container">
                
                <div class="section1">
                    <h3>Top de proveedores</h3>
                    <div class="pricing--filter toggle-btn-content toggle_btn_categories_control">
                        <ul class="selector-changue-mode-view">
                            <li class="indicator" style="left: -5px; width: 129px;"></li>	
                            <?php

                                $counter = 0;
                                foreach($category as $cat) { 
                                    
                                    if( $counter == 0 ){
                                        // var_dump( $cat );
                                        echo '<li id="'. $cat->term_id .'-toggle-btn-category" class="active"><a href="#pricingTab'. $cat->term_id .'" role="tab" data-toggle="tab">'. $cat->name .'</a></li>';
                                    }else{
                                        echo '<li id="'. $cat->term_id .'-toggle-btn-category" class=""><a href="#pricingTab'. $cat->term_id .'" role="tab" data-toggle="tab">'. $cat->name .'</a></li>';
                                    }
                                    $counter++;

                                }
                               
                            ?>
                        </ul>
                    </div>
                    <div id="contenedorCardsTopPage">
                        <?php

                            $html_content = '';

                            $counter = 0;
                            foreach($category as $cat) { 

                                $varSelected = "";
                                $name_category = str_replace("Hosting", "", $cat->name);
                                $name_category = ( $name_category == "Servidores Dedicados" ) ? $name_category : str_replace(" ", "", $name_category);

                                if( $counter == 0 ){
                                    $varSelected = "activado";
                                }else{
                                    $varSelected = "unactivado";
                                }
                                $counter++;
                                
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
                                        
                                        $render_card = '';
                                        $news_query->the_post(); 

                                        $puntuacion = get_post_meta( get_the_ID(), "media_de_puntuaciones" );
                                        
                                        $puntuacion = number_format((float)round( $puntuacion[0], 1), 1, '.', '');

                                        $var_this_post = get_the_ID();

                                        $loguito = get_field( 'logo' );
                                        $url_de_afiliados = get_field( 'url_afiliado' );

                                        $titulo = get_the_title( $var_this_post );
                                        $permalink = get_the_permalink( $var_this_post );
                                        $contenido = get_the_content( $var_this_post );
                                        $excerpt = /*substr(*/get_the_excerpt( $var_this_post )/*, 0,250)*/;

                                        $variable_ssl = get_field( 'ssl', $var_this_post );
                                        $variable_dominio = get_field( 'dominio', $var_this_post );
                                        $variable_garantia = get_field( 'garantia', $var_this_post );
                                        $variable_soporte = get_field( 'soporte', $var_this_post );

                                        $var_sop_arr =  $variable_soporte;
                                        $si_hay_soporte = '';
                                        foreach( $var_sop_arr as $param ){
                                    
                                            if( $param == '2' ){
                                                $si_hay_soporte = 'Soporte Español Sí';
                                            }
                                    
                                        }
                                    
                                        if( $si_hay_soporte == ''){
                                    
                                            $si_hay_soporte = 'Soporte Español No';
                                    
                                        }

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

                                        $render_card .='
                                                            <div class="card_top_page '. $categoria_id .' '. $varSelected .'" nameTerm="'. $categoria_slug .'">
                                                                <div class="bloq1">
                                                                    <img class="image_logo" src="'. $loguito .'" >
                                                                    <img class="image_topCertified" src="'. get_stylesheet_directory_uri() . '/img/elementos/sello_top5.svg' .'" />
                                                                    <hr />
                                                                    <div class="scoresec">
                                                                        <span class="puntos">'. $puntuacion .'</span>
                                                                        <span class="estrellas">'. $score_component .'</span>
                                                                    </div>
                                                                    <div class="botoncito_azul_abajo_score">
                                                                        <span>Lorem</span>
                                                                    </div>
                                                                    <div>
                                                                        '. $caracteristicas_1 .'
                                                                    </div>
                                                                </div>
                                                                <div class="bloq2">
                                                                    <div class="content_up">
                                                                        <div class="_1">
                                                                            <span>SSL '. $variable_ssl["label"] .'</span>
                                                                            <span>Dominio '. $variable_dominio["label"] .'</span>
                                                                            <span>Garantía '. $variable_garantia["label"] .'</span>
                                                                            <span>'. $si_hay_soporte .'</span>
                                                                        </div>
                                                                        <div class="_2">
                                                                            <a class="btn btn-primary" href="'. $url_de_afiliados .'" target="_blank" rel="noreferrer noopener nofollow">Ir a '. $titulo .'</a>
                                                                            <div style="widt: 100%; height: 10px;"></div>
                                                                            <a class="btn btn-primary" href="'. $permalink .'">Perfil de proveedor</a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="content_content">
                                                                        <h5>Consectetuer adipiscing elit, sed </h5>
                                                                        <span>'. $excerpt .'</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        ';

                                        
                                        $html_content .= $render_card;
                                        
                                    }
                                
                                }

                                

                            }

                            echo $html_content;

                        ?>
                    </div>
                </div>
            
            </div>

        </div>


</div>

<?php

get_footer();

?> 