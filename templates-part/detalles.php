

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

<?php 

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

    $render_table = $render_table;
    $menor_precio = $precio_minimo;


?>


<?php


$detalle_cards .=   '


                            <div class="col-md-3 first-col">
                                <img src="'. get_field( "logo" ) .'" />
                                <p class="media_score">'. number_format((float)round( $media_sco[0], 1), 1, '.', '') .'</p>
                                <p class="stars_media">'. $score_component .'</p>
                                <p class="numer_opinions">'. $total_opiniones .' Opiniones</p>
                            </div>


                            <div class="col-md-6 second-col">
                                <div class="caracteristicas_general">
                                    <p><img src="'. get_stylesheet_directory_uri()."/img/iconos-cards-detalles/garantia.svg" .' "  style="margin-right: 5px;"></img>'. $antes_de_garantia . $garantia_parametro .'</p>
                                    <p><img src="'. get_stylesheet_directory_uri()."/img/iconos-cards-detalles/ssl.svg" .' "  style="margin-right: 5px;"></img> SSL '. $ssl_parametro .'</p>
                                    <p><img src="'. get_stylesheet_directory_uri()."/img/iconos-cards-detalles/dominio.svg" .' "  style="margin-right: 5px;"></img>Dominio '. $dominio_parametro .'</p>
                                    <p><img src="'. get_stylesheet_directory_uri()."/img/iconos-cards-detalles/soporte.svg" .' "  style="margin-right: 5px;"></img>'. $si_hay_soporte .'</p>
                                </div>

                                <hr />

                                <div class="caracteristicas_especificas">
                                    '. $features_details_cards .'
                                </div>
                            </div>

                            <div class="col-md-4 third-col">
                                
                                <p class="title-result-3-column">Planes y precios</p>
                                <p></p>
                                
                                <table class="table-plans-provider">
                                    
                                    '. $render_table .'
                                    
                                </table>

                                <div class="grid_end_box">
                                    <p id="desde_msg">Desde</p>
                                    <p id="precio_msg">USD  $'. $menor_precio .'</p>
                                    <div class="button_combo">
                                        <a href="" class="btn more-details" style="visibility: hidden;">Más detalles</a>
                                        <a target="_blank" href="'. $url_de_afiliados .'" class="btn view-off">Ver ofertas</a>
                                    </div>
                                </div>

                            </div>
                    
                    ';


?>