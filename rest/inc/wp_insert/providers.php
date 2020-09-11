<?php

    foreach($providers as $key => $value) {

        $tmpProvider = [
            'id'                =>  $value->id,
            'name'              =>  $value->name,
            'sede'              =>  $value->headquarters,
            'fundado'           =>  $value->year,
            'resumen'           =>  $value->summary,
            'url'               =>  $value->website_url,
            'social_facebook'   =>  $value->facebook_url,
            'social_twitter'    =>  $value->twitter_url,
            'social_linkedin'   =>  $value->linkedin_url,
            'social_google'     =>  $value->googleplus_url,
            'social_youtube'    =>  $value->youtube_url,
            'url_afiliado'      =>  $value->affiliate_url,
            'garantia'          =>  $value->warranty,
            'dominio'           =>  $value->domain,
            'ssl'               =>  $value->ssl,
            // 'tag_id'            =>  $value->tag_id,
            // 'logo'             =>  $value->image
        ];

     if($value->white_image != null)
     $id_img_bln =  imgInsert($value->white_image,$value->name);
     if($value->image != null)
      $id_img =  imgInsert($value->image,$value->name);


      $HavePost = ch_have_post('proveedor','unic_ID',$value->id);

      

        $tmpPost = [
            'post_title'    =>  $tmpProvider['name'],
            'post_content'  =>  '',
            'post_status'   =>  'publish',
            'post_type'     =>  'proveedor',
            'post_name'     =>  $tmpProvider['name']
        ];
        
        $countries = $value->countries;
        $hosting_types = $value->hosting_types;
        $customer_supports = $value->customer_supports;
        $payment_methods = $value->payment_methods;

           // add Category
           $catArr = [];
           foreach($hosting_types as $po){
               $catArr[] = get_option('IdTypeHosting_'.$po);
            }

            
        if($HavePost != false){
            $tmpPost['ID'] = $HavePost;
            wp_update_post( $tmpPost );
            $postId = $HavePost;
        }else{
            $postId = wp_insert_post($tmpPost);
        }

        //id_utlimo POST[]
        update_option('idpostultimate',$postId);
        /// agrego el codigo unico del pais de voyager en los META
        update_post_meta($postId, "unic_ID",$tmpProvider['id']);

        // Actualizar ACF de forma recursiva
        foreach($tmpProvider as $key => $value) {
            update_field($key, $value, $postId);
        }
        
        /// Relacion Paises
        $countriesArr = [];
        foreach($countries as $po){
            $countriesArr[] = ch_have_post('pais','unic_ID',$po);
        }
        update_field('pais', $countriesArr, $postId);

        ///customer_supports
        $customer_supports_arr = [];
        foreach($customer_supports as $po){
           $customer_supports_arr[] = $po;
        }
        update_field('soporte', $customer_supports_arr, $postId);
        
        /// metodos_pago
        $payment_methods_arr = [];
        foreach($payment_methods as $po){
           $payment_methods_arr[] = $po;
        }
        
        update_field('metodos_pago', $payment_methods_arr, $postId);

        // imagen logo 
        update_field('logo', $id_img, $postId);
        

        /// Imagen blanca
        set_post_thumbnail( $postId, $id_img_bln);

        // add post in cats
        wp_set_post_terms( $postId, $catArr, 'tipo');

    }