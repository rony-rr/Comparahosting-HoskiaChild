<?php



function get_plans_by_proveedor_tax( $id_proveedor, $tax_cat, $cantidad_sitios, $pay_method, $budged, $traffic ){


    // var_dump( $tax_cat );
    // echo "<br /><br />";
    // die;
    
    $args_inside = array	(
            'post_type' => 'plan',
            'post_status' => 'publish',
            'posts_per_page' => 3,
            'meta_key'    => 'precio',
            'orderby'   =>  'meta_value_num',
            'order'    => 'ASC',
        );

        
        $range_price = explode("-", $budged);
        // var_dump( $range_price[0] );
        // var_dump( $range_price[1] );
        // die;

        if( $cantidad_sitios != '' && $pay_method != '' && $budged != '' && $traffic != '' ){
        
            $args_inside['meta_query'] = array(
                                            'relation'		=> 'AND',
                                            array(
                                                'key' => 'proveedor_pertenece',
                                                'value' => '"'.$id_proveedor.'"',
                                                'compare' => 'like'
                                            ),
                                            array(
                                                'key' => 'tipos_de_hosting_validos',
                                                'value' => '"'.$tax_cat.'"',
                                                'compare' => 'like'
                                            ),
                                            array(
                                                'key' => 'precio',
                                                'value' => (int)$range_price[1],
                                                'type'    => 'numeric',
                                                'compare' => '<='
                                            ),
                                            array(
                                                'relation' => 'OR',
                                                array(
                                                    'key' => 'cantidad_sitios',
                                                    'value' => $cantidad_sitios,
                                                    'compare' => '<='
                                                ),
                                                array(
                                                    'key' => 'trafico_maximo',
                                                    'value' => $traffic,
                                                    'compare' => '<='
                                                ),
                                            ),
                                            
            );
        
        }
        elseif( $tax_cat != '' ){

            $args_inside['meta_query'] = array( 
                                            'relation'		=> 'AND',
                                            array(
                                                'key' => 'proveedor_pertenece',
                                                'value' => '"'. $id_proveedor. '"',
                                                'compare' => 'like'
                                            ),
                                            array(
                                                'key' => 'tipos_de_hosting_validos',
                                                'value' => '"'. $tax_cat . '"',
                                                'compare' => 'like'
                                            ),
            );

        }
        else{
            
            $tax_cat = '306';
            $args_inside['meta_query'] = array( 
                                            'relation'		=> 'AND',
                                            array(
                                                'key' => 'proveedor_pertenece',
                                                'value' => '"'. $id_proveedor. '"',
                                                'compare' => 'like'
                                            ),
                                            array(
                                                'key' => 'tipos_de_hosting_validos',
                                                'value' => '"'. $tax_cat . '"',
                                                'compare' => 'like'
                                            ),
            );

        }


        // var_dump( $args_inside );
        // echo "<br /><br />";
    


        $post_types_plans = new WP_Query( $args_inside );

        $posts = $post_types_plans->get_posts();

        /* variable de return de la funcion */
        $render_return = '';

        /* Variables que se usaran para renderizar la tabla de planes en las cards de detalles */
        $render_table = '';
        $min_price = 0;

        /* variables para control de features */
        $features_plan = array();
     
        /* Contador de control para saber si existen planes */
        $count_this_while = 0;


        /* Variables del renderizado en el comparador */
        $options_plans_compare = '';
        $options_plans_compare .= ' <select name="plans_compare_ids_'. $id_proveedor .'" style="" class="seleccion-plan-comparacard"> ';

        $price_plans_compare .= '';

        $arr_3_filters_options_detailcards = get_option( '3_feaures_'.$tax_cat );
        $features_details_cards = '';
        // var_dump( $arr_3_filters_options_detailcards );
            
        foreach($posts as $po){

                // var_dump( get_the_title( $po->ID ) );
                // var_dump( get_post_meta( $po->ID, 'trafico_maximo' ) );
                // echo "<br /><br />";

              
                // var_dump( get_post_meta( $po->ID, 'cantidad_sitios' ) );

                $render_table .=    '
                                        <tr>
                                            <td class="start_td">'. get_field( 'shortname_plan', $po->ID ) .'</td>
                                            <td class="end_td">$'. number_format((float)round( get_field( 'precio', $po->ID ), 2), 2, '.', '') .'</td>
                                        </tr>
                                    
                                    ';

                $options_plans_compare .=   '
                                                <option value="'. $po->ID . '"> '. get_field( 'shortname_plan', $po->ID ) .' </option>
                                            ';



                                    
                if($count_this_while == 0){
                    
                    $min_price = get_field( 'precio', $po->ID );
                    $min_price = number_format((float)round( $min_price, 2), 2, '.', '');
                    
                    $price_plans_compare .= '<p class="'. $po->ID .'" style="display: block;">$ '. $min_price .'</p>';


                    $array_fetaures_post_meta = get_post_meta( $po->ID, "plan_features");

                    if( count( $array_fetaures_post_meta ) > 0 ){
                        
                        foreach( $array_fetaures_post_meta as $arr ){
                                            
                            foreach( $arr as $key => $pa){
    
                                    $clase_controller = str_replace(' ', '', $pa["name"]);
                                    
                                    if( $pa["dato"] ){

                                        if( $pa["dato"] == "opt-unlimited" ){

                                            $features_plan[] =  '<div class="adding-element " feature="'. $clase_controller .'" style="display: none;"><p class="'. $po->ID .'" style="display: block;"> Ilimitado </p>'; // <i class="fa fa-check" style="margin-right: 5px;"></i> </p>';

                                        }else{
                                            
                                            $features_plan[] =  '<div class="adding-element " feature="'. $clase_controller .'" style="display: none;"><p class="'. $po->ID .'" style="display: block;">'. $pa["dato"] .'</p>'; // <i class="fa fa-check" style="margin-right: 5px;"></i> </p>';

                                        } 
                                    
                                    }   
                                    else{
    
                                        $features_plan[] =  '<div class="adding-element " feature="'. $clase_controller .'" style="display: none;"><p class="'. $po->ID .'" style="display: block;"> <i class="fa fa-times gray-color-item" style="margin-right: 5px;"></i> </p>';
                                    
                                    }  
                                    
                                    
                                    if ( in_array( $pa["name"], $arr_3_filters_options_detailcards ) ) {
                                        
                                        if( $pa["dato"] == "opt-unlimited" ){
                                            
                                            $features_details_cards .= '<p>'. $pa["name"] .' Ilimitado </p>';

                                        }else{

                                            $features_details_cards .= '<p>'. $pa["name"] .' '. $pa["dato"] .' </p>';

                                        }
                                            

                                    }

                        
                            }
                        
                        }

                    }
                    else{
                        
                        $feats_ = get_option( 'filtros_hosting_data' );
                        foreach( $feats_ as $arr ){
    
                            $clase_controller = str_replace(' ', '', $arr);
                                
                            $features_plan[] =  '<div class="adding-element " feature="'. $clase_controller .'" style="display: none;"><p class="'. $po->ID .'" style="display: block;"> <i class="fa fa-times gray-color-item" style="margin-right: 5px;"></i> </p>';
                        
                        }

                    }
 
                
                } else{

                    $price_mvp = get_field( 'precio', $po->ID );
                    $price_mvp = $media_score = number_format((float)round( $price_mvp, 2), 2, '.', '');

                    $price_plans_compare .= '<p class="'. $po->ID .'" style="display: none;">$ '. $price_mvp .'</p>';

                    $array_fetaures_post_meta = get_post_meta( $po->ID, "plan_features");
                    $contador_de_features = 0;

                    if( count( $array_fetaures_post_meta ) > 0 ){

                        foreach( $array_fetaures_post_meta as $arr ){
                                                
                            foreach( $arr as $key => $pa){

                                $clase_controller = str_replace(' ', '', $pa["name"]);

                                if( $pa["dato"] ){

                                    if( $pa["dato"] == "opt-unlimited" ){

                                        $contenido_anterior = $features_plan[$contador_de_features];
                                        $features_plan[$contador_de_features] =  $contenido_anterior . '<p class="'. $po->ID .'" style="display: none;"> Ilimitado </p>'; //<i class="fa fa-check" style="margin-right: 5px;"></i> </p>';

                                    }else{
                                        
                                        $contenido_anterior = $features_plan[$contador_de_features];
                                        $features_plan[$contador_de_features] =  $contenido_anterior . '<p class="'. $po->ID .'" style="display: none;"> '. $pa["dato"] .' </p>'; //<i class="fa fa-check" style="margin-right: 5px;"></i> </p>';

                                    } 

                                    $contador_de_features++;

                                }
                                else{

                                    $contenido_anterior = $features_plan[$contador_de_features];
                                    $features_plan[$contador_de_features] =  $contenido_anterior . '<p class="'. $po->ID .'" style="display: none;"> <i class="fa fa-times gray-color-item" style="margin-right: 5px;"></i> </p>';
                                    
                                    $contador_de_features++;

                                }
                            
                            }

                            

                        }

                    }
                    else{
                        
                        $feats_ = get_option( 'filtros_hosting_data' );
                        foreach( $feats_ as $arr ){
    
                            $clase_controller = str_replace(' ', '', $arr);
                                
                            $contenido_anterior = $features_plan[$contador_de_features];
                            $features_plan[$contador_de_features] =  $contenido_anterior . '<p class="'. $po->ID .'" style="display: none;"> <i class="fa fa-times gray-color-item" style="margin-right: 5px;"></i> </p>';
                                    
                            $contador_de_features++;
                        }

                    }
                
                }

                $count_this_while++;

        }
        
        $contador_fplans = 0;
        foreach ( $features_plan as $key => $fplan ){

            $contenido_anterior = $fplan;
            $features_plan[$contador_fplans] = $contenido_anterior . '</div>';
            $contador_fplans++;

        }


        $features_planes = '';
        foreach ( $features_plan as $fplan ){
            
            $features_planes .= $fplan;

        }

        $options_plans_compare .= ' </select>  ';
          
        if($count_this_while > 0){

            $render_return = array(     
                                        "tabla"=>$render_table, 
                                        "menor_precio"=>$min_price, 
                                        "features_plans" =>$features_planes, 
                                        "select_compare_plans"=>$options_plans_compare, 
                                        "precios_comparador_plans"=>$price_plans_compare,
                                        "caracteristicas_para_card_detalle"=>$features_details_cards
                                    );
        }else{
            $render_return = "";
        }

            
        return $render_return ;


}




?>