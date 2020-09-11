<?php
foreach($plans as $key => $value) {


    $arr_plan = [
        'post_title'    =>  $value->name." - ".get_the_title($id_provider),
        'post_content'  =>  '',
        'post_status'   =>  'publish',
        'post_type'     =>  'plan',
        'post_name'     =>  $value->name
    ];
    
    $HavePost = ch_have_post('plan','unic_ID',$value->id); //  existe ? 
    $id_provider = ch_have_post('proveedor','unic_ID',$value->provider_id); // id proveedor
    $hosting_type_id = get_option('IdTypeHosting_'.$value->hosting_type_id); // id category
    $shortname = $value->name; // nombre corto de plan
    $price = $value->price; // price
    $type_plan = $value->plan_type_id; // plan_type_id
    $plan_features_int = $value->plan_features;
    $id_planvy = $value->id;

    //variables utilizables en modal wizard
    $visitas_estimadas = '';
    $cantidad_sitios = '';
    

    /// Generate plan_features
    $features_plan_arr = [];
    $filtros = [];
     foreach($plan_features_int as $po){
        $id         = $po->id;
        $assigned   = $po->assigned;
        $extra      = $po->extra;
        // paso 1 : buscar name de caracteristica 
        $name       = $custom_plan_features[$id];
        $filtros[] = $name;

        if($extra == null){
            
            $arr = array(
                "name" => $name,
                "dato" => $assigned
            );
            if( $name == 'Visitas estimadas'){

                $visitas_estimadas = $assigned;
            
            }
            if( $name == 'Sitios Web'){

                $cantidad_sitios = $assigned;
            
            }

        }else{
            
            $arr = array(
                "name" => $name,
                "dato" => $extra
            );
            if( $name == 'Visitas estimadas'){

                $visitas_estimadas = $extra;
            
            }
            if( $name == 'Sitios Web'){

                $cantidad_sitios = $extra;
            
            }

        }

        array_push($features_plan_arr, $arr);

     }

    update_option('filtros_hosting_data', $filtros);
    $filtros = [];

    if($HavePost != false){
        $arr_plan['ID'] = $HavePost;
        wp_update_post( $arr_plan );
        $postId = $HavePost;
    }else{
        $postId = wp_insert_post($arr_plan);
    }

    /// agrego plan type 
    update_post_meta($postId, "tipo_contrato_hostingXS",$type_plan__[$type_plan]);

    /// agrego el codigo unico 
    update_post_meta($postId, "unic_ID",$id_planvy);

    // agrego los metas cantidad de sitios we y trafico maximo para filtros wizard
    update_post_meta( $postId, 'cantidad_sitios', $cantidad_sitios );
    update_post_meta( $postId, 'trafico_maximo', $visitas_estimadas );

    /// save provider ACF
    update_field('proveedor_pertenece', array($id_provider), $postId);
    //save Hosting type ACF
    update_field('tipos_de_hosting_validos', array($hosting_type_id), $postId);
    //save price 
    update_field('precio', $price, $postId);
    // save type plan
    
    // save shorname plan
    update_field('shortname_plan',$shortname , $postId);
    // save feature 
    update_post_meta($postId, "plan_features", $features_plan_arr);

}
?>