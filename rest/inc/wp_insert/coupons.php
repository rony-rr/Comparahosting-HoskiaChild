<?php

foreach($coupons as $coupons){
    $name_cupons = $coupons->name;
    $code_cupons = $coupons->code;
    $valid_from = $coupons->valid_from;
    $valid_until = $coupons->valid_until;
    $offer = $coupons->offer;
    $discount = $coupons->discount;
    $description = $coupons->description;
    $hosting_type_id = $coupons->hosting_type_id;
    $plan_type_id = $coupons->plan_type_id;
    $id_cupon = $coupons->id;
    $plansVars = $coupons->plans;

     $my_post = array(
        'post_title'    => $name_cupons,
        'post_content'  => "",
        'post_status'   => 'publish',
        'post_type'     => 'cupon',
        'post_name'     => $name_cupons
    );

    $HavePost = ch_have_post('cupon','unic_ID',$id_cupon);
    
    /// verifico si existe o no 
    if($HavePost != false){
        $my_post['ID'] = $HavePost;
        wp_update_post( $tmpPost );
        $postId = $HavePost;
    }else{
        $postId = wp_insert_post($my_post);
    }
    
    /// agrego el codigo unico de cupon 
    update_post_meta($postId, "unic_ID",$id_cupon );

    // ACF  COdigo Cupon
    update_field('codigo_cupon', $code_cupons, $postId);
    
    // //acf a que plan pertenece
    $plan_arr = [];
    foreach( $plansVars as $po){
        $idPlan = ch_have_post('plan','unic_ID',$po);
        $plan_arr[]= $idPlan;
    }

    update_field('plan_pertenece', $plan_arr,$postId);
    ///valid_from 
    update_field('valido_desde', $valid_from,$postId);
    //valid_until
    update_field('valido_hasta', $valid_until,$postId);
    //offer
    if($offer == ''){ $offer = "-"; }
    update_field('oferta', $offer,$postId);
    //tipo_de_contrato
    update_field('tipo_de_contrato', $plan_type_id,$postId);
    //valor_descuento
    update_field('valor_descuento', $discount,$postId);
    //descripcion_cupon_y_proveedor
    update_field('descripcion_cupon_y_proveedor', $description,$postId);





}
?>