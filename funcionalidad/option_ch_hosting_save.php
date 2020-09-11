<?php 

// funcion anclada al hook de saving/update de los posts para reorganizar el array de paises con sus datos de los posts
function option_ch_hosting_save($post_id){
    
    if( get_post_type( $post_id ) == 'proveedor' ){

        //array final que almacenara la informacion de todos los paises con sus 3 proveedores 
        $array_data_paises_hostings = array();

        //array que almacena temporalmente los paises de cada hosting 
        $array_fields_paises = array();

        //ciclo para obtener todos los paises disponibles el post_type pais
        $args = array(
            'post_type'=> 'pais',
            'orderby'    => 'ID',
            'post_status' => 'publish',
            'order'    => 'DESC',
            'posts_per_page' => -1
        );
        $result = new WP_Query( $args );
        if ( $result-> have_posts() ) :
            while ( $result->have_posts() )
            { 
                $result->the_post();
                $var_pais_id = get_the_ID();

                if( $var_pais_id != NULL ){

                    array_push($array_fields_paises, $var_pais_id);
                
                }

            }
        endif;
        wp_reset_postdata();
        wp_reset_query();
        

        //ciclo para recorrer todos los paises obtenidos por cada hosting
        foreach( $array_fields_paises as $poo ){

            $post_temp = get_post( $poo );
            $nombre_del_pais = get_the_title( $poo );
            $slug_pais = $post_temp->post_name;
            // var_dump( $post_temp->post_name );
            // echo "<br /><br />";

            //array temporal para manejar los datos de cada pais con sus proveedores y puntuacion 
            $array_temporal_por_pais = array();
            $array_de_retorno_por_pais = array();


                // loop para obtener los 3 proveedores para cada pais
                //argumentos para meta query de proveedores x pais.
                $args1 = array(
                    'post_type'=> 'proveedor',
                    'orderby'    => 'ID',
                    'post_status' => 'publish',
                    'order'    => 'ASC',
                    'posts_per_page' => -1,
                    'meta_query'	=> array(
                                                'relation'		=> 'OR',
                                                array(
                                                    'key'	 	=> 'pais',
                                                    'value'	  	=> $poo,
                                                    'compare' 	=> 'LIKE',
                                                ),
                                            ),
                    );
                
                //consulta con los argumentos de la metaquery para obtener proveedores por cada pais
                $posts = new WP_Query( $args1 );
                
                //ccondicion y ciclo loop para obtener los datos de los proveedores x pais 
                if( $posts->have_posts() ){
                    
                    while( $posts->have_posts() ){

                        $posts->the_post();
                        // echo $poo["label"] . ": " . get_the_ID(). "</br>";

                        //obtencion de puntuaciones para el proveedor en este pais
                        $total_opiniones = get_field('total_opiniones', get_the_ID());
                        $soporte = get_field('total_soporte', get_the_ID());
                        $usabilidad = get_field('total_usabilidad', get_the_ID());
                        $funcionalidades = get_field('total_funcionalidades', get_the_ID());
                        $valor = get_field('total_valor', get_the_ID());

                        // echo $poo["label"] . "=>" . get_the_title() . "=>" . ( ( ($soporte/$total_opiniones) + ($usabilidad/$total_opiniones) + ($funcionalidades/$total_opiniones) + ($valor/$total_opiniones) ) / 4 );
                        // echo "<br /><br />";

                        //calculo de promedio de puntuaciones
                        if( get_post_meta( get_the_ID(), 'media_de_puntuaciones') && get_post_meta( get_the_ID(), 'media_de_puntuaciones')[0] > 0 ){
                            $media_score = get_post_meta( get_the_ID(), 'media_de_puntuaciones')[0]; //ya existe dato
                        }else{

                            $media_score = 0;
                        
                            $media_score = ( ( ($soporte/$total_opiniones) + ($usabilidad/$total_opiniones) + ($funcionalidades/$total_opiniones) + ($valor/$total_opiniones) ) / 4 );
                            $media_score = number_format((float)round( $media_score, 1), 1, '.', '');

                            if( $media_score == 0 ){
                                $punt_1 = rand(3, 4);
                                if($punt_1 == 3){
                                    $media_score = $punt_1.".".rand(80, 90);
                                }else{
                                    $media_score = $punt_1.".".rand(50, 90);
                                }

                            } 

                            $media_score = number_format((float)round( $media_score, 1), 1, '.', '');

                            update_post_meta( get_the_ID(), 'media_de_puntuaciones', (float)$media_score );

                        
                        }
                        
                        //array temporal para guardar datos del proveedor
                        $arr_temp = array(

                                'pais' => $nombre_del_pais,
                                'slug' => $slug_pais,
                                'imagen' => get_stylesheet_directory_uri() . '/img/mapas/'.$slug_pais.'.png',
                                'id_proveedor' => get_the_ID(),
                                'nombre_proveedor' => get_the_title(),
                                'puntuacion_promedio' => $media_score,

                        );
                        // var_dump($arr_temp);
                        // echo '<br /><br />';

                        //se agrega a la coleccion del array temporal de cada pais para definir a los mejores proveedores de ese pais
                        if( $arr_temp["slug"] != NULL ){
                            
                            array_push($array_temporal_por_pais, $arr_temp);

                        }                                    

                    }
                }
                else{
                    null;
                }
            // fin de loop

            // var_dump($array_temporal_por_pais);
            // echo '<br /><br />';
            
            //Se ordena el array temporal con la informacion de los paises por su puntuacion de mayor a menor

            usort($array_temporal_por_pais, function($a, $b) {
                return $b['puntuacion_promedio'] <=> $a['puntuacion_promedio'];
            });

            // var_dump ($array_temporal_por_pais);
            // echo "<br /><br />";



            //se realiza un loop para obtener los 10 mejores servicios de hosting de cada pais

            $counter_first_10 = 0;
            $array_de_ids = array();
            foreach( $array_temporal_por_pais as $moo => $key2 ){

                if($counter_first_10 < 10){
                    // var_dump( $key2["pais"] );
                    // echo "<br />";
                    // var_dump( $key2["puntuacion_promedio"] );
                    // echo "<br /><br />";

                    array_push($array_de_ids, $key2["id_proveedor"]);
                }
                else{
                    null;
                }
                
                $counter_first_10++;
            }
            

            //creacion de la estructura del array que se insertara al array de paises y hostings
            $array_de_retorno_por_pais = array(
                $poo =>
                    array(
                        'pais' => $nombre_del_pais,
                        'slug' => $slug_pais,
                        'imagen' => get_stylesheet_directory_uri() . '/img/mapas/'.$slug_pais.'.png',
                        'arr_id' => $array_de_ids,
                    )
            );

            //se agrega el array del pais actual en el loop con sus hostings principales y sus datos
            array_push($array_data_paises_hostings, $array_de_retorno_por_pais);

        }

        // var_dump( $array_data_paises_hostings );
        // echo "<br /><br />";
        


        // algoritmo de borrado de duplicados
        // $duplicate_keys = array();
        // $tmp = array();       

        // foreach ($array_data_paises_hostings as $key => $val){
        //     // convert objects to arrays, in_array() does not support objects
        //     if (is_object($val))
        //         $val = (array)$val;

        //     if (!in_array($val, $tmp))
        //         $tmp[] = $val;
        //     else
        //         $duplicate_keys[] = $key;
        // }



        // foreach ($duplicate_keys as $key){

        //     unset($array_data_paises_hostings[$key]);

        // }


        if( get_option('_paises_hostings_') === false ){
            add_option( '_paises_hostings_', $array_data_paises_hostings );
        }
        else{
            delete_option('_paises_hostings_');
            update_option( '_paises_hostings_', $array_data_paises_hostings );
        }

        wp_reset_postdata();
        wp_reset_query();

    }
    else{
        null;
    }

}

add_action('wp_insert_post', 'option_ch_hosting_save');

// add_action( 'save_post', 'my_save_post_function', 10, 3 );

// function my_save_post_function( $post_ID, $post, $update ) {
//   $msg = 'Is this un update? ';
//   $msg .= $update ? 'Yes.' : 'No.';
//   wp_die( $msg );
// }

?>