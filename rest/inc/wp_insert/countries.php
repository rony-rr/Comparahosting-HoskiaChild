<?php
foreach($countries as $key => $value){

    $name_countries = $value->name;
    $shortname_countries = $value->shortname;
    $id_countries = $value->id;

    $HavePost = ch_have_post('pais','unic_ID',$id_countries);

          $my_post = array(
            'post_title'    => $name_countries,
            'post_content'  => "",
            'post_status'   => 'publish',
            'post_type'     => 'pais',
            'post_name' => $name_countries

        );
        // if(get_the_title($id) == $name_countries){
        
        if ( $HavePost != false) {
            $my_post['ID'] = $HavePost;
            wp_update_post( $my_post );
            $post_id = $HavePost;
          }else{
            $post_id = wp_insert_post( $my_post );
        }

 

      /// agrego el codigo unico del pais de voyager en los META
        update_post_meta($post_id, "unic_ID",$id_countries );

        // Actualizo el ACF de extension de pais
        update_field('extension_de_pais', ".".strtolower($shortname_countries),$post_id);
  
}