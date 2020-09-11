<?php
function ch_have_post($postype,$key,$value){
 $args = array(
    'posts_per_page' => '1',
    'post_type' => $postype,
    'meta_query' => array(
        array(
            'key' => $key,
            'value' => $value,
            'compare' => '=',
        )
    )
 );

$query = new WP_Query($args);

if ( $query->have_posts() ) {
    return $query->post->ID;
}else{
   return false;
}
}
 ?>