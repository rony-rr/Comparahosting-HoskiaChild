<?php
/* 
Template Name: Type hosting
*/

 include "funcionalidad/archive_template.php";
 include "funcionalidad/get_provider_by_term.php";
 ?>
<?php get_header(); ?>

<?php

$allacf = get_field_objects( get_option( 'idpostultimate' ) );
$garantia = $allacf['garantia']["choices"];
$dominio = $allacf['dominio']["choices"];
$ssl = $allacf['ssl']["choices"];
$metodos_pago = $allacf['metodos_pago']["choices"];
$soporte = $allacf['soporte']["choices"];
$pais = array();

$args_paises_ids = array(
    'post_type' => 'pais',
    'post_status'       => 'publish',
    'posts_per_page'    => -1,
);

$consulta_paises = new WP_Query( $args_paises_ids );

if( $consulta_paises->have_posts() ){
    while( $consulta_paises->have_posts() ){
        
        $consulta_paises->the_post();
        array_push( $pais, get_the_ID() );

    }
}

wp_reset_postdata();
wp_reset_query();



// var_dump( $allacf['pais'] );
// echo "<br /><br />";

$current_cat = get_queried_object();

$current_taxonomy = $current_cat->taxonomy;
$category_current = $current_cat->term_id;
$category_current_slug = $current_cat->slug;
// var_dump($category_current)."\n";


if(isset($_GET['ps'])){
 
    $countryPost = $_GET['ps'];

}else{

    $countryPost = '';

}


?>





<div id="pageContent" class="pd--100-0">

    <div class="container">
    <div class="pricing--filter toggle-btn-content">
                    <ul class="selector-changue-mode-view">
                        <li class="indicator" style="left: -5px; width: 129px;"></li>
                        <li id="detail-toggle-btn" class="detail-card show-filters active"><a href="#pricingTabmensual" role="tab" data-toggle="tab">Detalles</a></li>
                        <li id="list-toggle-btn" class="list-card show-filters"><a href="#pricingTabanual" role="tab" data-toggle="tab">Lista</a></li>	
                        <li id="compare-toggle-btn" style='
                        <?php
                        if(!isset($_GET['compa'])){
                            echo "display:none";   
                        }
                        ?>
                        ' class="compare-card hide-filters"><a href="#pricingTabanual" role="tab" data-toggle="tab">Comparativa</a></li>			
                    </ul>
		        </div>
        <div class="row page--container">

            <aside class="page--sidebar col-md-3">

                <form method='GET'>


                    <!-- Contenedor -->
                    <ul class="tab-lists">


                        <li class="tab-list accordion-tab categoria-tit master-li-tab"><h5>Categoría<i class="fa fa-angle-up right"></i></h5></li>
                        <li class="tab-list accordion-contents categoria-tit-list master-li-tab">
                            <ul>
                            <?php
                            
                            $clase_adicional_de_cat = '';
                            $id_slug = '';
                            $identity_current_term = '';

                            foreach($category as $po){
                                $id = $po->term_id;
                                $slug_act = $po->slug;
                                // var_dump($id);

                                

                                if($slug_act == $category_current_slug){
                                    $clase_adicional_de_cat = 'current_cate';
                                    $id_slug = $category_current_slug;
                                    $identity_current_term = $category_current;
                                }else{
                                    $clase_adicional_de_cat = '';
                                    $id_slug = '';
                                    $identity_current_term = '';
                                }

                                echo '
                                        <li id="'. $id_slug .'" term_id="'. $identity_current_term .'" class="'. $clase_adicional_de_cat .'">
                                            <i class="fa fa-circle" aria-hidden="true"></i>
                                            <a href="'.get_category_link($id).'" >'.$po->name.'</a>
                                        </li>
                                    ';
                            }
                            ?>
                            </ul>
                        </li>



                        <!-- LI -->
                        <li class="tab-list accordion-tab beneficios-tit master-li-tab no-display-comparador"><h5>Beneficios<i class="fa fa-angle-up right"></i></h5></li>
                        <li class="tab-list accordion-contents beneficios-tit-list master-li-tab">
                            <ul>
                                    <li>
                                        <select name='gar'>
                                        <option value=''>Garantía</option>
                                        <?php 
                                            foreach($garantia as $key => $value){
                                                echo "<option value='".$key."'>".$value."</option>";
                                            }
                                        ?>
                                        </select>

                                        <select name='dom'>
                                        <option value=''>Dominio</option>
                                        <?php 
                                            foreach($dominio as $key => $value){
                                                echo "<option value='".$key."'>".$value."</option>";
                                            }
                                        ?>
                                        </select>


                                        <select name='ssl'>
                                        <option value=''>Certificado SSL</option>
                                        <?php 
                                            foreach($ssl as $key => $value){
                                                echo "<option value='".$key."'>".$value."</option>";
                                            }
                                        ?>
                                        </select>
                                    </li>
                            </ul>
                        </li>
                        <!-- /LI -->
                        



                        <li class="tab-list accordion-tab atencion-cli master-li-tab no-display-comparador"><h5>Atención al cliente<i class="fa fa-angle-up right"></i></h5></li>
                        <li class="tab-list accordion-contents atencion-cli-list master-li-tab ">
                            <ul>
                            <?php
                            foreach($soporte as $key => $value){
                                echo '
                                        <li class="grid-align-inputs-soporte"><input type="checkbox" value="'.$key.'" name="at[]"> <label>'.$value.'</label></li>
                                     ';
                            }
                            ?>
                            </ul>
                        </li>


                    
                        <li class="tab-list accordion-tab metodos-pago master-li-tab no-display-comparador"><h5>Formas de pago<i class="fa fa-angle-up right"></i></h5></li>
                        <li class="tab-list accordion-contents metodos-pago-list master-li-tab ">
                            <ul>
                        
                                <?php 
                                    foreach($metodos_pago as $key => $value){

                                        $var_check = '';
                                        
                                        if( ( $_GET["metodo_pago"] ) != NULL ){

                                            if( $_GET["metodo_pago"] == $key ){
                                                $var_check = 'checked';
                                            } 

                                        }

                                        echo '
                                            <li><input type="checkbox" value="'.$key.'" name="pay[]" '. $var_check .'> <label>'.$value.'</label></li>
                                        ';
                                    }
                                ?>
                        

                            </ul>
                        </li>




                        <li class="tab-list accordion-tab pais- master-li-tab no-display-comparador"><h5>País / Dominio<i class="fa fa-angle-up right"></i></h5></li>
                        <li class="tab-list accordion-contents pais-list master-li-tab">
                            <ul>
                                <select name='ps'>
                                <option value=''>Pais</option>
                                <?php 
                                    foreach($pais as $pa){
                                        
                                        $post = get_post($pa); 
                                        $label_pais = $post->post_title;
                                        $value_pais = $post->post_name;
                                        $extension_pais = get_field("extension_de_pais", $pa);

                                        if($countryPost == $pa){
                                            echo "<option value='". $pa ."' selected>". $label_pais ." / ". $extension_pais ."</option>";
                                        }else{
                                            echo "<option value='". $pa ."'>". $label_pais ." / ". $extension_pais ."</option>";
                                        }
                                    }
                                ?>
                                </select>
                            </ul>
                        </li>



                    </ul>

                    <!-- <input class="btn find_button_btn" type='submit' name='a' value='Buscar'> -->


                </form>

            </aside>



       

            <article id="container-results-filterpage" class="page--main-content col-md-9 custom-pages">

             


                <?php // Screen loading while AJAX Request is eject ?>  

                <div id="loading_ajax_filter" style="">
                    <img class src="https://s3-sa-east-1.amazonaws.com/img.decodecms/entradas/Ajax+en+WordPress/ajax-loader.gif" style="float:left;" />
                </div>  

                


                <div id="build-by-term-find">
                    
                    <?php //Contenedor de html por defecto ?>
                    
                    <?php

                            // condicion que verifica si entrto por el wizard o por un enlace de categoria
                            if( $_GET['cantidad_sitios'] && $_GET['metodo_pago'] && $_GET['presupuesto'] && $_GET['trafico'] )
                            {

                                $cantidad_sitios = $_GET['cantidad_sitios'];
                                $pay_method = $_GET['metodo_pago'];
                                $budged = $_GET['presupuesto'];
                                $traffic = $_GET['trafico'];


                                get_proveedores_and_plans_by_term($current_taxonomy, $category_current_slug, $category_current, 1, $countryPost, $cantidad_sitios, $pay_method, $budged, $traffic);  
                            
                            }                                 

                            else
                                get_proveedores_and_plans_by_term($current_taxonomy, $category_current_slug, $category_current, 1, $countryPost, '', '', '', '');

                    ?>
                    
                </div>

                
                <?php // aqui se escribira el codigo HTML proveniente de la peticion AJAX ?>       


                <?php //Modal de filtrado del comparador ?>
                <div id="modal-results-filters" class="modal-filter-page" >
                    <div class="modal-window">
                        <div class="filter-content">

                            <ul class="tabs_control_filters">
                                <li id="features-modal-filter-ctrl" class="active" rel="tab1">Características</li>
                                <li id="providers-modal-filter-ctrl" rel="tab2">Proveedores</li>
                            </ul>

                            <div id="filtrar-proveedores" class="providers-filter"></div>

                        </div>
                        <button id="aplicar-filtros-seleccionados" class="apply-filters-button">Aplicar</button>
                    </div>
                </div>


     

            </article>


            <aside class="sidebar--down page--sidebar col-md-12">
              
            </aside>

            <?php $ar_to_json = get_option( "catalogos_hosting_data" ); ?>

            <script type="text/javascript">
                var ar = <?php echo json_encode($ar_to_json) ?>;
                // ["apple","orange",1,false,null,true,8];
                // access 4th element in array
                
            </script>
            
            
        </div>
    </div>
</div>
<?php get_footer(); ?>
<style>
.tab-lists {
 width: 100%;
 list-style: none;
 padding-left: 0px;
padding-right: 40px;
}
.tab-lists ul{
    list-style: none;
    border-bottom: 5px #000;
    padding: 10;
}

</style>




