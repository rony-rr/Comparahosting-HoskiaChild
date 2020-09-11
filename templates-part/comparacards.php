
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

    $var_sop_arr =  $soporte_form;
    $si_hay_soporte = '';

    foreach( $var_sop_arr as $kk ){
        if( $kk == 'es' ){
            $si_hay_soporte = 'Soporte en español';
        }
    }


    $soporte_espaniol = '';
    $soporte_24_7 = ''; 
    $soporte_array = get_field( 'soporte' );
    if ( $soporte_array ):
        foreach ( $soporte_array as $soporte_item ):

            if( $soporte_item == 1 ){

                $soporte_24_7 = 'si';

            }
            if( $soporte_item == 2 ){

                $soporte_espaniol = 'si';

            }

        endforeach;
    endif;


    $soporte_espaniol = ( $soporte_espaniol == 'si' ) ? '<i class="fa fa-check" style="margin-right: 5px;"></i>' : "--" ;
    $soporte_24_7 = ( $soporte_24_7 == 'si' ) ? '<i class="fa fa-check" style="margin-right: 5px;"></i>' : "--" ;


    $render_features_by_plan = $array_caracteristicas_plan;

    $compare_content .= '
                            <div class="card-col">
                                <div class="first-row"><span class="quit-elements-by-x"></span><a href="'. $url_de_afiliados .'" target="_blank"><img src="'. get_field( 'logo' ) .'" /></a></div>
                                <a class="sticky-image-comparacard" target="_blank" href="'. $url_de_afiliados .'"><img src="'. get_field( 'logo' ) .'" /></a>
                                <div class="second-row">
                                    <p class="media_score">'. number_format((float)round( $media_sco[0], 1), 1, '.', '') .'</p>
                                    <p class="stars_media">'. $score_component .'</p>
                                </div>
                                <div class="plains-providers-select-compare">'. $options_plans_compare .'</div>
                                <div class="adding-element check-ele" feature="ssl">
                                    <p>'. get_field( 'ssl' )["label"] .'</p>
                                </div>
                                <div class="adding-element check-ele" feature="garantia">
                                    <p>'. get_field( 'garantia' )["label"] .'</p>
                                </div>
                                <div class="adding-element check-ele" feature="dominio">
                                    <p>'. get_field( 'dominio' )["label"] .'</p>
                                </div>
                                <div class="adding-element check-ele" feature="soporte_espaniol">
                                    <p>'. $soporte_espaniol .'</p>
                                </div>
                                <div class="adding-element check-ele" feature="24_7">
                                    <p>'. $soporte_24_7 .'</p>
                                </div>
                                '. $render_features_by_plan .'
                                <div href="'.  $url_de_afiliados .'" class="end-button-comparacard end-price-card-carousel">
                                    '. $price_plans_compare .'
                                </div>
                            </div>
                        ';

?>