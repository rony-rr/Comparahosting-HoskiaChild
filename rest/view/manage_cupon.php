        
<?php


$arr_cupones_mes = array();
$arr_cupones_anio = array();


$var_guardado = '';

// consulta de todos los cupones con bandera activa 
$args = array(
    'post_type'=> 'cupon',
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

        $titulo_cupon = get_the_title();
        $id_cupon = get_the_ID();
        $desc_ = get_field("descripcion_cupon_y_proveedor", $id_cupon);
        $tipo_plan = get_field("tipo_de_contrato", $id_cupon);
        $visible = get_post_meta( $id_cupon, 'es_visible' );
        $visible = $visible[0];

        if($tipo_plan == "3"){
            
            $array_tmp = array(
                                "id" => $id_cupon, 
                                "titulo" => $titulo_cupon, 
                                "descripcion" => $desc_, 
                                "tipo_plan" => $tipo_plan,
                                "visible" => $visible,
                            );

            array_push($arr_cupones_mes, $array_tmp);

        }

        if($tipo_plan == "2"){
            
            $array_tmp = array(
                                "id" => $id_cupon, 
                                "titulo" => $titulo_cupon, 
                                "descripcion" => $desc_, 
                                "tipo_plan" => $tipo_plan,
                                "visible" => $visible,
                            );

            array_push($arr_cupones_anio, $array_tmp);
            
        }

        
    }
endif;


if($_POST['save_config']){

    // Cupones por meses
    foreach( $arr_cupones_mes as $key => $aa ){
        update_post_meta( $aa["id"], 'es_visible', 'no' );
    }

    foreach( $_POST["cupones-mes"] as $po ){
        update_post_meta( $po, 'es_visible', 'si' );
    }




    // Cupones por anio
    foreach( $arr_cupones_anio as $key => $aa ){
        update_post_meta( $aa["id"], 'es_visible', 'no' );
    }

    foreach( $_POST["cupones-anio"] as $po ){
        update_post_meta( $po, 'es_visible', 'si' );
    }


    $var_guardado = 'none';



    
}


?>
        
        
<?php 

        if( $var_guardado == 'none' ){


            include "done_message.php";


        }

?>

        
        <h2 style="display: <?php echo $var_guardado; ?>;">Lista de Cupones</h2>
        <p style="display: <?php echo $var_guardado; ?>;">Seleccione los cupones que se mostraran el la seccion de Promociones.</p>

        <form id="form-cupones-select" name="form-cupones-select" method="POST" style="display: <?php echo $var_guardado; ?>;">
            <section class="container">
                <div class="dropdown">
                    <h3>Cupones por Mes</h3>
                    <select name="cupones-mes[]" class="dropdown-select" size="3" multiple="multiple" tabindex="1">
                        <option value="">Selecione un cupon</option>
                        <?php 
                                foreach( $arr_cupones_mes as $key => $aa ){
                                    
                                    $var_preselected = '';

                                    if( $aa["visible"] == "si" ){ 
                                        $var_preselected = "selected='selected'"; 
                                    } else{
                                        $var_preselected = '';
                                    }

                                    echo '<option value="'. $aa["id"] .'" '. $var_preselected .' >'. $aa["descripcion"] .' / '. $aa["titulo"] .'</option>';
                                }
                        ?>
                    </select>
                </div>
            </section>

            <section class="container">
                <div class="dropdown">
                    <h3>Cupones por Año</h3>
                    <select name="cupones-anio[]" class="dropdown-select" size="3" multiple="multiple" tabindex="1">
                        <option value="">Selecione un cupon</option>
                        <?php 
                                foreach( $arr_cupones_anio as $key => $aa ){
                                    
                                    $var_preselected = '';

                                    if( $aa["visible"] == "si" ){ 
                                        $var_preselected = "selected='selected'"; 
                                    } else{
                                        $var_preselected = '';
                                    }

                                    echo '<option value="'. $aa["id"] .'" '. $var_preselected .' >'. $aa["descripcion"] .' / '. $aa["titulo"] .'</option>';
                                }
                        ?>
                    </select>
                </div>
            </section>

            <input class="btn btn-send" type="submit" name="save_config" value="Guardar Configuracion">
        
        </form>



    
        


        <style>
            .btn-send {
                display: flex;
                justify-content: center;
                text-align: center;
                align-content: center;
                align-items: center;
                margin: 50px auto;
                height: 40px;
                width: 200px;
                border-radius: 25px;
                background: #FFF;  
                border: solid 1px #00a0d2;
                font-weight: 900;
                letter-spacing: 1px;
                transition: all 150ms linear;
                cursor: pointer;
            }

            .btn-send:hover {
                background: #d6dbdf ;
                text-decoration: none;
                transition: all 250ms linear;
            }

            .dropdown-select{
                width: 400px;
            }
        </style>