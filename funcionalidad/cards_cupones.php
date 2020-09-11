<?php 


/* Funcion necesaria para poder acceder a los datos de los terms desde otra funcion */
function call_term( $termino_id ){
    
    $cat_cu = get_term_by( 'id', $termino_id, 'tipo');
    $name_cate = $cat_cu->name;

    return $name_cate;

}


function cards_cupones () {

    $var_html_content = '';
    $var_script = '';


    $var_html_content .=    '
                                <div class="pricing--filter toggle-btn-content">
                                    <ul class="selector-changue-mode-view">
                                        <li class="indicator" style="left: -5px; width: 129px;"></li>
                                        <li id="mensual-toggle-btn" class="active"><a href="#pricingTabmensual" role="tab" data-toggle="tab">Mensual</a></li>
                                        <li id="anual-toggle-btn" class=""><a href="#pricingTabanual" role="tab" data-toggle="tab">Anual</a></li>		
                                    </ul>
                                </div>
                            ';

    $var_html_content .=    '
                                <div 
                                    class="owl-carousel carrusel-de-cupones" style="display: none;"
                                    data-carousel-items="1"
                                    data-carousel-center="true"
                                    data-carousel-margin="0"
                                    data-carousel-responsive=\'{"0":{"items":"1"},"650":{"items": "2"},"768":{"items":"2"},"960":{"items":"2"}}\'
                                >
                                </div>
                            ';


    // hiperconsulta de cupones - planes - proveedores - tipos de hosting        planes: mensuales-anuales


    $args = array(
        'post_type'=> 'cupon',
        'orderby'    => 'ID',
        'post_status' => 'publish',
        'order'    => 'DESC',
        'posts_per_page' => 6,
        'meta_query'        => array( 
                                        'relation'		=> 'AND',
                                        array(
                                            'key' => 'es_visible',
                                            'value' => 'si',
                                            'compare' => 'like'
                                        ),
                                    ),

    );
    
    $result = new WP_Query( $args );

    if ( $result-> have_posts() ) :
        while ( $result->have_posts() )
        { 
            $result->the_post();

            
            $titulo_cupon = '';
            $tipo_hosting = '';
            $link_hosting = '';
            $valido_desde = get_field( 'valido_desde' );
            $validez_hasta = get_field( 'valido_hasta' );
            $oferta_cupon = get_field( 'oferta' );
            $tipo_contrato_plan_cupon = get_field( 'tipo_de_contrato' );
            $codigo_cupon = get_field( 'codigo_cupon' );
            $porcentaje_descuento = get_field( 'valor_descuento' );
            

            $estilo_none = '';
            if( $tipo_contrato_plan_cupon == 2){
                $estilo_none = 'style="display: none;"';
            }
            else{
                $estilo_none = '';
            }

    
            $plan_pertenece = get_field( 'plan_pertenece' );
            

            if ( $plan_pertenece ):
                $counter_fore = 0;
                foreach ( $plan_pertenece as $p):
                    if($counter_fore == 0){


                        $name_plan = get_field("shortname_plan", $p );
                        
                        $precio_plan = get_field( "precio", $p );
                        $valor_descuento = ( $porcentaje_descuento*$precio_plan )/100;
                        $precio_con_descuento = $precio_plan - $valor_descuento;
                        $precio_con_descuento = number_format((float)$precio_con_descuento, 2, '.', '');
    
                        $tipo_plan = get_field( "tipo_de_plan", $p );
                        $tipo_plan = $tipo_plan[0];
                        $caracteristicas = get_field( "caracteristicas", $p );
                        $proveedor_pertenece = get_field( 'proveedor_pertenece', $p );
                        $plan_pertenece = get_field( 'plan_pertenece', $p );
                        $tipos_de_hosting_validos_ids = get_field( 'tipos_de_hosting_validos', $p );

                        
                        $name_cate = call_term($tipos_de_hosting_validos_ids[0]);
                        
                        
    
                        $logo = get_field( 'logo', $proveedor_pertenece[0] );
                        $url_afiliado = get_field( 'url_afiliado', $proveedor_pertenece[0] );
                        $name_proveedor = get_the_title($proveedor_pertenece[0]);
                        $thumbID = get_post_thumbnail_id( $proveedor_pertenece[0] );
                        $imgDestacada = wp_get_attachment_url( $thumbID );


                        $separador_caracteristicas = ',';
                        $caracteristicas = explode($separador_caracteristicas, $caracteristicas);

                        $caracteristicas_elem = '';

                
                        $caracterisiticas =  get_post_meta($p, "plan_features");

                        $counter_to_features_render = 0;
                        foreach( $caracterisiticas  as $po){
                            foreach($po as $key => $pa){
                                if( $pa["dato"] && $counter_to_features_render < 5){
                                    $dato_caracteristica = $pa["dato"];
                                    if($pa["dato"] == "opt-unlimited"){
                                    $dato_caracteristica = 'Ilimitado';
                                    }

                                    $caracteristicas_elem .=    '
                                    <li><p class="dato-caracateristica-line">'. $pa["name"]. " - " . $dato_caracteristica.'</p></li>
                                ';
                                    $counter_to_features_render++;

                                }
                                if( $counter_to_features_render >= 5){
                                    
                                    break;

                                }

                            }
                        }

                  

                        $var_html_content .= '
                                                    <div class="cupon_element_cp pricing--item '. $tipo_contrato_plan_cupon. '-cards col-xs-12 col-md-4 col-sm-12" '. $estilo_none .'>
                                                        <div class="pricing--content ">
                                                            <div class="pricing--header">
                                                                <h3 class="h4">'. $name_cate . '</h3>
                                                                <img src="' .$imgDestacada. '" alt="4 hostinger">
                                                                <h4 class="h5">
                                                                    <strike>$' .$precio_plan .'</strike>
                                                                    <strong>$'.$precio_con_descuento.' /'.$tipo_plan.'</strong>
                                                                </h4>
                                                            </div>
                                                            <div class="pricing--icon">
                                                                <i></i>
                                                            </div>
                                                            <div class="pricing--features">
                                                                <div class="content-control">
                                                                <ul>
                                                                    '. $caracteristicas_elem .'
                                                                </ul>
                                                                </div>
                                                            </div>
                                                            <div class="pricing--separator"></div>
                                                            <div class="pricing--footer">
                                                                <span class="pricing--ribbon">Cup&oacute;n descuento</span>
                                                                <div class="pricing--footer-panel1">
                                                                    <div class="pricing--footer-panel2">
                                                                        <h1>'.$porcentaje_descuento.'% OFF</h1>
                                                                        <hr></hr>
                                                                        <div class="cupon_area">
                                                                            <div class="cupon_button_area">
                                                                                <a class="btn btn-primary">Generar Código</a>
                                                                                <label>Válido hasta '.$validez_hasta.'</label>
                                                                            </div>
                                                                            
                                                                            <div class="cupon_reveal_area">
                                                                                <p>Código de cupón:</p>
                                                                                <input type="text" class="txt_cupon" value="'. $codigo_cupon .'" />
                                                                                <input type="hidden" class="txt_cupon_url" value="'.$url_afiliado.'?poosas=123s" />
                                                                                <p>Copiado en Portapapeles!</p>
                                                                            </div>
                                                                            
                                                                            <div class="cupon_reveal_area redirec_host">
                                                                            <p>Código de cupón: <b>'.$codigo_cupon.'</b> Copiado !!</p>
                                                                            <input type="hidden" class="txt_cupon_url" value="http://www.google.com" />
                                                                            <p>Redireccionando al sitio de ventas!</p>
                                                                          
                                                                            </div>
                                                                            
                                                                        </div>
                                                                        
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                ';
    
                    }
                    else{
                        null;
                    }
                    $counter_fore++;
                endforeach;
            endif;
        }
    endif;
        


    //return de componentes
    $var_return = $var_html_content . $var_script;

    return $var_return;
} 

add_shortcode( "cards_cupones", "cards_cupones" );


?>