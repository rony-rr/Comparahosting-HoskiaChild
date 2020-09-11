

<?php



$media_sco = get_post_meta( get_the_ID(), 'media_de_puntuaciones' );

$total_opiniones = get_field('total_opiniones', get_the_ID());

$score_component = '';



$score = $media_sco[0];

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

?>



<? 

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


?>


<?php

$init_up_div = '';
$init_down_div = '';

if ( wp_is_mobile() ) {

    $init_up_div = '<div class="cards_lista_responsive max_width_1000">';
    $init_down_div = '</div>';

}


$lista_cards .=     '


                        <div class="first-col-list">

                            <img src="'. get_field( 'logo' ) .'" />

                        </div>



                        <div class="second-col-list">

                            <p class="media_score">'. number_format((float)round( $media_sco[0], 1), 1, '.', '') .'</p>

                            <p class="stars_media">'. $score_component .'</p>

                            <p class="numer_opinions">'. $total_opiniones .' Opiniones</p>

                        </div>



                        <div class="third-col-list">

                            

                                

                                <p><img src="'. get_stylesheet_directory_uri()."/img/iconos-cards-detalles/ssl.svg" .' "  style="margin-right: 5px;"></img>SSL '. $ssl_parametro .'</p>

                                <p><img src="'. get_stylesheet_directory_uri()."/img/iconos-cards-detalles/dominio.svg" .' "  style="margin-right: 5px;"></img>Dominio '. $dominio_parametro .' </p>

                                



                        </div>


                        <div class="four-col-list min_width_1001">

                            <p id="desde_msg">Desde</p>

                            <p id="precio_msg">USD $'. $menor_precio .'</p>

                        </div>



                        <div class="five-col-list min_width_1001">

                            <a target="_blank" href="'. $url_de_afiliados .'" class="btn view-off">Ver ofertas</a>

                        </div>

                        '. $init_up_div .'

                        <div class="four-col-list max_width_1000">

                            <p id="desde_msg">Desde</p>

                            <p id="precio_msg">USD $'. $menor_precio .'</p>

                        </div>



                        <div class="five-col-list max_width_1000">

                            <a target="_blank" href="'. $url_de_afiliados .'" class="btn view-off">Ver ofertas</a>

                        </div>

                        '. $init_down_div .'

                    ';

                    // <p><img src="'. get_stylesheet_directory_uri()."/img/iconos-cards-detalles/garantia.svg" .' "  style="margin-right: 5px;"></img>'. $antes_de_garantia . $garantia_parametro .' </p>
                    // <p><img src="'. get_stylesheet_directory_uri()."/img/iconos-cards-detalles/soporte.svg" .' "  style="margin-right: 5px;"></img>'. $si_hay_soporte .' </p>

?>