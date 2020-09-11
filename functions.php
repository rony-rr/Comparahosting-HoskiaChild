<?php
/**
 * @version    1.0
 * @package    Hoskia
 * @author     Themelooks  <support@themelooks.com>
 * @copyright  Copyright (C) 2017 themelooks.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.themelooks.com
 */

/* Invocando archivo de creacion de post_types y taxonomias */
include "funcionalidad/register_post_types_taxonomies.php";

//recent post 
include "widgets/resent_post.php";
/* End Invoke */

// Extra Google Fonts
function theme_fonts_add() {
    wp_register_style('Montserrat', 'https://fonts.googleapis.com/css?family=Montserrat:300,500,600');
    wp_enqueue_style( 'Montserrat');
}
add_action('wp_print_styles', 'theme_fonts_add');


/**
 * Enqueue style of child theme
 */
function hoskia_child_enqueue_styles() {

    global $wp;
    global $post;

    wp_enqueue_style( 'hoskia-child-style', get_stylesheet_directory_uri() . '/style.css' );
    wp_enqueue_style( 'hoskia-child-custom-style', get_stylesheet_directory_uri() . '/css/customs.css' );
    wp_enqueue_style( 'hoskia-child-custom2-style', get_stylesheet_directory_uri() . '/css/custom2-css.css' );
    wp_enqueue_style( 'hoskia-child-custom3-style', get_stylesheet_directory_uri() . '/css/custom3-css.css' );
    wp_enqueue_style( 'hoskia-child-shortcodes-style', get_stylesheet_directory_uri() . '/css/shortcodes.css' );
    wp_enqueue_style( 'hoskia-child-footer-style', get_stylesheet_directory_uri() . '/css/footer.css' );
    wp_enqueue_style( 'hoskia-child-mediaQueries-style', get_stylesheet_directory_uri() . '/css/media-query.css' );
    wp_enqueue_style( 'hoskia-child-mediaQueries-style2', get_stylesheet_directory_uri() . '/css/media-query-2.css' );

    if ( is_singular( 'post' ) ) {
        wp_enqueue_script( 'hoskia-child-custom-scripts', get_stylesheet_directory_uri() . '/js-scripts/jquery.sticky-sidebar.js' );  
    }
    wp_enqueue_script( 'hoskia-child-custom-scripts', get_stylesheet_directory_uri() . '/js-scripts/custom-scripts.js' );
    wp_enqueue_script( 'hoskia-child-custom2-scripts', get_stylesheet_directory_uri() . '/js-scripts/custom2-js.js' );
    wp_enqueue_script( 'hoskia-child-custom3-scripts', get_stylesheet_directory_uri() . '/js-scripts/custom3.js' );


    wp_localize_script( 'hoskia-child-custom-scripts', 'hoskia_ajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
    

}

add_action( 'wp_enqueue_scripts', 'hoskia_child_enqueue_styles', 100000 );


/* Creacion de seccion de Top 5 */
include 'funcionalidad/top_5_section.php';
/* Fin de seccion */

/* seccion de hosting ideal cardviews del final de la seccion */
include 'funcionalidad/cardviews_posting_hosting_ideal_section.php';
/* Fin de la seccion */

/* Seccion de Mapa para Hosting */
include 'funcionalidad/map_section.php';
/* Fin de la seccion */

/* Seccion de cupones */
include 'funcionalidad/cards_cupones.php';
/* Fin de la seccion */

/* ACF Import*/
include "ACF/acf_options.php";
include "funcionalidad/option_ch_hosting_save.php";

// options to detail cards
include "funcionalidad/options_to_detailcard.php";


// Consultar API de Voyager
include "rest/get_data.php";


// Añadir código de tablas 
include "funcionalidad/tables_to_edit.php";
// Fin de seccion

// Añadir código de top 5 sidebar 
include "funcionalidad/top5_sidebar.php";
// Fin de seccion

// Añadir código de top banner comparador sidebar 
include "funcionalidad/banner_comparador_sidebar.php";
// Fin de seccion

// Añadir código de top banner comparador sidebar 
include "funcionalidad/banner_paises_sidebar.php";
// Fin de seccion

 
// var_dump( get_post_meta( 2057, 'media_de_puntuaciones' ) );


/*
function register_term(){
    
    $term = term_exists( 'Cloud Hosting', 'tipo' ); 
    $term_id = $term["term_id"];
    
    if ( $term !== 0 && $term !== null ) {
        echo  'Category exists!' . $term_id; 
    }
    else{
        
        wp_insert_term(
            'Nueva Categoria',   
            'taxonomia', 
            array(
                'description' => 'Aqui pone la descripcion.',
                'slug'        => 'el identificador de la nueva categoria',
                'parent'      => $parent_term_id,
            )
        );

    }
    
}
*/
// register_term();

/*
function add_cats_to_posts(){
    
    $cat_ids = array( 6, 8 );
    
    $term_taxonomy_ids = wp_set_object_terms( 42, $cat_ids, 'category' );
    
    if ( is_wp_error( $term_taxonomy_ids ) ) {
        
        // En caso de error aqui

    } else {
        
        // En caso de exito

    }

}
*/




// Funcion AJAX en hook de accion para manejar filtros


//Accion para controlar peticion de proveedores y campos
add_action( "wp_ajax_get_results_filterpage", "getresults_wp_ajax_function" );
add_action( "wp_ajax_nopriv_get_results_filterpage", "getresults_wp_ajax_function" );


//funcion que responde a la accion de la peticion de proveedores y planes en pagina de filtros
function getresults_wp_ajax_function(){

            $render_content_filter = '';
            include "funcionalidad/get_plans_by_proveedor_tax.php";


            // Se verifica que en el POST['gar'] el valor sea diferente de vacio
            //se puede usar la validacion empty: ( $_POST['gar'] )
            $garantia_form = $_POST['gar'] != "" ? $_POST['gar'] : 'all';
            $dominio_form = $_POST['dom'] != "" ? $_POST['dom'] : 'all';
            $ssl_form = $_POST['ssl'] != "" ? $_POST['ssl'] : 'all';
            $soporte_form = $_POST['at'];
            $metodos_pago_form = $_POST['pay'];
            $pais_form = $_POST['ps'] != "" ? $_POST['ps'] : 'all';
            $category_current_slug = $_POST['current_category_slug'];
            $current_taxonomy = 'tipo';
            $category_current = $_POST['category_current_id'];
            
            
            // var_dump( $garantia_form );
            // var_dump( $dominio_form );
            // var_dump( $ssl_form );
            // var_dump( $soporte_form );
            // var_dump( $metodos_pago_form );
            // var_dump( $pais_form );
            // var_dump( $category_current_slug );
            // var_dump( $current_taxonomy );
            // var_dump( $category_current );
            // echo "<br /><br />";
            
            // wp_die();
            
            $count_soporte = count( $soporte_form );
            $count_metodos = count( $metodos_pago_form );
            // echo $count_soporte . "\n" . $count_metodos;


            // var_dump( $metodos_pago_form );
            // echo "<br /><br />";


            //construccion de meta consultas para el query 
            $meta_query_soporte = array();
            if($count_soporte > 0){
                $meta_query_soporte['relation'] = 'AND';
                foreach( $soporte_form as $p ){
                    $meta_query_soporte[] = array(
                        'key' => 'soporte',
                        // 'value' => sanitize_text_field( (string) $p ),
                        'value' => '"'. $p . '"',
                        'compare' => 'like'
                    );
                }
            } else{
                $meta_query_soporte = array(
                    'key' => 'soporte',
                    'value' => '',
                    'compare' => 'like'
                );
            }


            $meta_query_metodos_pagos = array();
            $arr_param_methods_pagos = array();
            if($count_metodos > 0){
                $meta_query_metodos_pagos['relation'] = 'OR';
                foreach( $metodos_pago_form as $p ){

                    $valor_nuevo_metodo = '"'. $p .'"';

                    $meta_query_metodos_pagos[] = array(
                        'key' => 'metodos_pago',
                        //'value' => /*sanitize_text_field( array ( $p ) ) */,
                        'value' => '"'. $p . '"',
                        'compare' => 'like'
                    );
                }
            } else{
                $meta_query_metodos_pagos = array(
                    'key' => 'metodos_pago',
                    'value' => '',
                    'compare' => 'like'
                );
            }
            
            // var_dump( $meta_query_metodos_pagos );
            // echo "<br /><br />";

            // argumentos para la consulta

            // $_222 = 2;

            $args = array(
                'post_type'         => 'proveedor',
                'post_status'       => 'publish',                
                'posts_per_page'    => -1,
                'meta_key'    => 'media_de_puntuaciones',
                'orderby'   =>  'meta_value_num',
                'order'    => 'DESC',
                'meta_query'        => array( 
                                                'relation'		=> 'AND',
                                                    array(
                                                        'key' => 'garantia', // name of custom field
                                                        // se realiza el query con el parametro de garantia validando que este vacio o no
                                                        'value' => ($garantia_form == 'all' ? '' : $garantia_form),
                                                        'compare' => 'like'
                                                    ),

                                                    array(
                                                        'key' => 'dominio',
                                                        'value' => ( $dominio_form == 'all' ? '' : $dominio_form ),
                                                        'compare' => 'like'
                                                    ),

                                                    array(
                                                        'key' => 'ssl',
                                                        'value' => ( $ssl_form == 'all' ? '' : $ssl_form ),
                                                        'compare' => 'like'
                                                    ),

                                                    array(
                                                        'key' => 'pais',
                                                        'value' => ( $pais_form == 'all' ? '' : '"'.$pais_form.'"' ) ,
                                                        'compare' => 'like'
                                                    ),
                                                    
                                                    $meta_query_soporte,

                                                    $meta_query_metodos_pagos,
                                                    
                                                    
                )


            );

            if(isset($_POST['current_category_slug'])){
       
                    $args['tax_query'] = array(
                        array (
                            'taxonomy' => $current_taxonomy,
                            'field' => 'slug',
                            'terms' => $category_current_slug,
                        )
                    );

            }
            //consulta con args
            $query = new WP_Query($args);

            
        
                        $detalle_cards = '';
                        $lista_cards = '';
                        $compare_content = '';

                        if( $query->have_posts() ){
                            
                            $count_posts_no_plans = 0;
                            $count_posts_yes_plans = 0;

                            $feats_ = get_option( 'filtros_hosting_data' );
                            $render_feats_title = '';

                            foreach( $feats_ as $fe ){

                                $clase_controller = str_replace(' ', '', $fe);

                                $render_feats_title .=   '
                                                            <div class="adding-element title-ele hosting-features" feature="'. $clase_controller .'" style="display: none;"><p>'. $fe .'</p></div>
                                                        ';            

                            }


                            $account_filter_build = 0;
                            $_class_build_ = '';

                            $compare_content .= '<div id="control_comparador_container" class="section--compare container--compare-cards container--comparacards--view resultados" style="display: none;">'; 
                            
                            $compare_content .= '
                                                    <div class="features-rows-compare ">
                                                        <div class="first-row"><p>Hosting</p></div>
                                                        <div class="second-row"><p>Score</p></div>
                                                        <div class="plains-providers-select-compare"><p>Plans</p></div>
                                                        <div class="adding-element title-ele hosting-features" feature="ssl"><p>SSL</p></div>
                                                        <div class="adding-element title-ele hosting-features" feature="garantia"><p>Garantia</p></div>
                                                        <div class="adding-element title-ele hosting-features" feature="dominio"><p>Dominio</p></div>
                                                        <div class="adding-element title-ele hosting-features" feature="soporte_espaniol"><p>Soporte Español</p></div>
                                                        <div class="adding-element title-ele hosting-features" feature="24_7"><p>Soporte 24/7</p></div>
                                                        '. $render_feats_title .'
                                                        <div id="image-paste-to-plus-features-sticky-text"></div>
                                                        <div id="image-paste-to-plus-features-sticky-arrow"></div>
                                                        <a class="end-button-comparacard button-plus btn"><i class="fa fa-plus" style=""></i></a>
                                                    </div>
                                                ';
                            
                            $compare_content .= '
                                <div class="owl-carousel carrousel--compare-cards" 
                                    data-carousel-items="4"
                                    data-carousel-margin="0"
                                    data-carousel-responsive=\'{"0":{"items":"1"},"576":{"items": "2"},"768":{"items":"3"},"960":{"items":"5"}}\'
                                >
                            ';

                            while( $query->have_posts() ){

                                if($account_filter_build == 0) { $_class_build_ = 'primary_select'; }
                                else{ $_class_build_ = ''; }

                                $query->the_post();


                                $ssl_parametro = get_field( 'ssl', get_the_ID() )["label"];
                                $garantia_parametro = get_field( 'garantia', get_the_ID() )["label"];
                                $dominio_parametro = get_field( 'dominio', get_the_ID() )["label"];
                                $soporte_parametro = get_field( 'soporte', get_the_ID() );

                                $url_de_afiliados = get_field( 'url_afiliado' );


                                // $get_render_table = get_plans_by_proveedor_tax( get_the_ID(), $category_current );
                                $get_render_table = get_plans_by_proveedor_tax( get_the_ID(), $category_current, '', '', '', '' );
                                
                                if($get_render_table != ''){

                                    /* Variables de renderizado que se obtienen de los planes */
                                    $render_table = $get_render_table["tabla"];
                                    $precio_minimo = $get_render_table["menor_precio"];
                                    $array_caracteristicas_plan = $get_render_table["features_plans"];
                                    $options_plans_compare = $get_render_table["select_compare_plans"];
                                    $price_plans_compare = $get_render_table["precios_comparador_plans"];
                                    $features_details_cards = $get_render_table["caracteristicas_para_card_detalle"];
                                    


                                    /* renderizado de las cards */
                                    $detalle_cards .= "<div class='row resultados detail-card result_filter_details " . $_class_build_ . "'>";
                                        include "templates-part/detalles.php";
                                    $detalle_cards .= "</div>";

                                    $lista_cards .= '<div class="row resultados list-card result_filter_list '. $_class_build_ .' " style="display: none;">';
                                        include "templates-part/lista.php";
                                    $lista_cards .= '</div>';

                                    $compare_content .= '<div id="'. get_the_ID() .'" class="compare-card result_filter_compare '. get_the_ID() .'" prove-slug="'. get_the_title( get_the_ID() ) .'" prove-logo="'. get_field( 'logo' ) .'" prove-logo-gris="'. wp_get_attachment_url( $thumbID ) .'" >';
                                        include "templates-part/comparacards.php";
                                    $compare_content .= '</div>';

                                    $count_posts_yes_plans++;

                                }
                                else{
                                    $count_posts_no_plans++;
                                }

                                

                                $account_filter_build++;
                            }

                            $compare_content .= '</div>';

                            $compare_content .= '</div>';


                            $render_content_filter = $detalle_cards . $lista_cards . $compare_content;

                            
                            
                        } else{

                            $render_content_filter = 'No hay posts';

                        }


                        if($count_posts_no_plans > 0){
                            if($count_posts_yes_plans == 0){
                                
                                $render_content_filter = 'No hay posts';

                            }
                            else{
                                null;
                            }
                        }
                        else{

                            null;

                        }


                        

            echo $render_content_filter;

            wp_reset_postdata();
            wp_die();

}




// var_dump( get_post_meta( 9436, 'plan_features' ) );
// var_dump( count( get_post_meta( 9994, 'plan_features' ) ) );


// var_dump( get_option( 'filtros_hosting_data' ) );
// option_ch_hosting_save(10107);

//  Shotcode Comparahosting caja de alerta
function comparahosting_shortcode_alert_box($atts, $content = null)
{
  $atts = shortcode_atts(array(
    'type' => 'warning',
    'align' => 'left',
  ), $atts);

  $html  = '<div class="alert_box '.$atts['type']. ' '.$atts['align'].'">';
  $html .= '<div class="alert_box__content">';
  $html .= $content;
  $html .= '</div></div>';

  return $html;
}
add_shortcode('alert-box', 'comparahosting_shortcode_alert_box');

// var_dump( get_option( 'catalogos_hosting_data3') );
// update_option( 'catalogos_hosting_data2', get_option( 'catalogos_hosting_data' ) );
// var_dump( get_stylesheet_directory_uri() );



// var_dump( get_option( '3_feaures_306' ) );


// Add Shortcode
// 


//Añadir code shortcode banner tipos hosting
include "funcionalidad/blog_add_hosting_type_banner.php";
//support custon image size
add_action('init', 'register_custom_post_thumb');
function register_custom_post_thumb()
{
    add_image_size('child_size', 600, 450, true); //hard crop
    add_image_size('basic_size', 768, 512, true); //hard crop
    add_image_size('baby_size_400', 400, 270, true);
    add_image_size('baby_size_300', 300, 225, true);
    add_image_size('baby_size_120', 120, 90, true);
}

// procon
add_shortcode('row', 'row_shortcode');
add_shortcode('procon', 'procon_shortcode');
add_shortcode('pro_h4', 'pro_h4_shortcode');
add_shortcode('con_h4', 'con_h4_shortcode');
add_shortcode('proconTable', 'proconTable');

add_shortcode('check_list', 'check_list_shortcode');
add_shortcode('cross_list', 'cross_list_shortcode');


add_shortcode('tablex', 'table_shortcode');
add_shortcode('th', 'data_head');
add_shortcode('tr', 'data_table');


function has_attr($flag, $atts) {
    if (is_array($atts)) {
        foreach ( $atts as $key => $value) {
            if ( $key === $flag || $value === $flag){
                return true;
            }
        }
    }
    return false;
}


//PROCON V2______________________


//__________ PROCON __________

function row_shortcode($atts, $content = null)
{
    return '<div class="row"> ' . do_shortcode($content) . '</div>';
}

function procon_shortcode($atts, $content = null)
{
    return '<div class="procon-col"><div class="well well-procon"> ' . do_shortcode($content) . '</div></div>';
}

function pro_h4_shortcode()
{
    $vorteile = __("Ventajas", "paperback");
    return "<div class='procon__title procon__title--vorteile'>$vorteile</div>";
}

function con_h4_shortcode()
{
    $nachteile = __("Desventajas", "paperback");
    return "<div class='procon__title procon__title--nachteile'>$nachteile</div>";
}

function check_list_shortcode($atts, $content = null)
{
    $output = '';
	 //Soporte apostrofe
    $content = str_replace('&#8217;', '"', $content);
    $contentt = explode(';', $content);
    $output .= '<ul class="procon__list list-icon  list-icon-check" >';
    foreach ($contentt as $con) :
        $output .= '<li class="procon__list-item">' . $con . '</li>';
    endforeach;
    $output .= '</ul>';
    return $output;
}

function cross_list_shortcode($atts, $content = null)
{
    $output = '';
	 //Soporte apostrofe
    $content = str_replace('&#8217;', '"', $content);
    $contentt = explode(';', $content);
    $output .= '<ul class="procon__list list-icon" >';
    foreach ($contentt as $con) :
        $output .= '<li class="procon__list-item">' . $con . '</li>';
    endforeach;
    $output .= '</ul>';
    return $output;
}

function table_shortcode($atts, $content = null)
{
    $tableAttributesList = array();
    if (has_attr('striped', $atts)) {
        $tableAttributesList[] = 'striped';
    }
    $stripedCols = '';
    if (has_attr('striped-cols', $atts)) {
        $tableAttributesList[] = 'striped-cols';
    }
    if (has_attr('fixed-column', $atts)) {
        $tableAttributesList[] = 'table--fixed-column';
    }
    $tableAttributes = implode(' ', $tableAttributesList);
    return "<div class='shortcode_table-wrap'><table class='shortcode_table $tableAttributes' role='table'>" . do_shortcode($content) . ' </tbody></table></div>';
}

function data_table($atts, $content = null)
{
    $output = '';
    $content = str_replace('&#8222;', '"', $content);
    $content = str_replace('&#8216;', '"', $content);
    $content = str_replace('&#8217;', '’', $content);
    $content = str_replace('&#8220;', '"', $content);
    $content = str_replace('&#8211;', '-', $content);
    $content = str_replace('&#8212;', '-', $content);
    $content = str_replace('&#8221;', '"', $content);
    $content = str_replace('&rsquo;', '’', $content);
    $contentt = explode(';', $content);
    $output .= '<tr role="row">';
    foreach ($contentt as $con) :
        $output .= '<td class="td_shortcodetable" role="cell">' . $con . '</td>';
    endforeach;
    $output .= '</tr>';
    return $output;
}

function data_head($atts, $content = null)
{

    $output = '';
    $content = str_replace('&#8222;', '"', $content);
    $content = str_replace('&#8216;', '"', $content);
    $content = str_replace('&#8217;', '’', $content);
    $content = str_replace('&#8220;', '"', $content);
    $content = str_replace('&#8211;', '-', $content);
    $content = str_replace('&#8212;', '-', $content);
    $content = str_replace('&#8221;', '"', $content);
    $content = str_replace('&rsquo;', '’', $content);
    $content = str_replace('"', '', $content);
  	$content = str_replace('&#8243;', '"', $content);
  	$contentt = explode(";", $content);
    $id_css = rand(1, 30);
    data_head_css($atts, $contentt, $id_css);
    add_action('wp_enqueue_scripts', 'data_head_css');
    //add_action('wp_head', 'data_head_css',100);
    $output .= '<thead role="rowgroup"><tr role="row">';
    foreach ($contentt as $con) :
        $output .= '<th role="columnheader">' . $con . '</th>';
    endforeach;
    $output .= '</tr><tbody role="rowgroup" id="tbody_' . $id_css . '">';

    return $output;
}

//__________ SU-IMG __________
// Add Shortcode

remove_shortcode('su_note');
add_filter('su/data/shortcodes', 'remove_su_shortcodes');

/**
 * Filter to modify original shortcodes data
 *
 * @param array   $shortcodes Default shortcodes
 * @return array Modified array
 */
function remove_su_shortcodes($shortcodes)
{

    // Remove shortcode
    unset($shortcodes['note']);

    // Return modified data
    return $shortcodes;
}

add_shortcode('su_note', 'paperback_su_shortcode_note');
function paperback_su_shortcode_note($atts = null, $content = null)
{

    $atts = shortcode_atts(array(
        'note_color' => '#FFFF66',
        'text_color' => '#333333',
        'background' => null, // 3.x
        'color'      => null, // 3.x
        'radius'     => '3',
        'class'      => ''
    ), $atts, 'su_note');

    if ($atts['color'] !== null) {
        $atts['note_color'] = $atts['color'];
    }

    if ($atts['background'] !== null) {
        $atts['note_color'] = $atts['background'];
    }

    // Prepare border-radius
    $radius = $atts['radius'] != '0'
        ? 'border-radius:' . $atts['radius'] . 'px;-moz-border-radius:' . $atts['radius'] . 'px;-webkit-border-radius:' . $atts['radius'] . 'px;'
        : '';

    return '<div class="note-box">
                <div class="note-box-icon">
                    <img src="'. get_stylesheet_directory_uri() .'/img/foco.png" alt="">
                </div>
                <div class="note-box-content">' . $content .'</div>
            </div>';
}

/* KB_criteria*/
function kb_criteria_func($atts, $content)
{
    $output = '';
    $re = '/\<h3[^>]*>(.*?)\<\/h3>/m';
    $re2 = '/\//';
    preg_match_all($re, $content, $matches, PREG_SET_ORDER, 0);
    $output .=  '<ul class="ch-criteria">';
    foreach ($matches as $match) {
        $match[0] = preg_replace($re2, "\\\/", $match[0]);
        $patron = '/' . $match[0] . '/';


        $re3 = '/\?/';
        $re4 = '/\W/';
        $slughref = $match[1];
        $slughref = preg_replace($re3, "", $slughref);
        $slughref = preg_replace($re4, "_", $slughref);




        $sustitución = '<h3 id="' . $slughref . '">' . $match[1] . '</h3>';

        $content = preg_replace($patron, $sustitución, $content);
        $output .= "<li class='licompa'><a class='aposition' href='# "  . $slughref . "'>" . $match[1] . "</a></li>";
    }
    $output .= "</ul>";
    return $output . do_shortcode($content);
}
add_shortcode('kb_criteria', 'kb_criteria_func');

/*END KB_criteria*/

/*XADVICE*/
function xadvice($atts, $content)
{
    $a = shortcode_atts(array(
        'name' => '',
        'title' => '',
        //'img' => '',
    ), $atts);

    $x = '';

    $x .= '<div class="advice-box">';
    $x .= '<div class="advice-box-icon"><img src="'. get_stylesheet_directory_uri() .'/img/advice.svg" alt=""></div>';
    $x .= '<div class="advice-box-content">';
    $x .= '<div class="advice-box-name">' . $a["name"] . '</div>';
    $x .= '<div class="advice-box-title">' . $a["title"] . '</div>';
    $x .= '<div class="advice-box-main">' . $content . '</div>';
    $x .= '</div>';
    $x .= '</div>';



    return $x;
}
add_shortcode('xadvice', 'xadvice');

function data_head_css($atts, $contentt = [], $id_css = '')
{ }

/*XADVICE END*/


// Personalización de wp caption shortcode

add_filter( 'img_caption_shortcode', 'cleaner_caption', 10, 3 );

function cleaner_caption( $output, $attr, $content ) {

	/* We're not worried abut captions in feeds, so just return the output here. */
	if ( is_feed() )
		return $output;

	/* Set up the default arguments. */
	$defaults = array(
		'id' => '',
		'align' => 'alignnone',
		'width' => '',
		'caption' => '',
		'source' => '',
	);

	/* Merge the defaults with user input. */
	$attr = shortcode_atts( $defaults, $attr );

	/* If the width is less than 1 or there is no caption, return the content wrapped between the &#091;caption&#093;&lt; tags. */
	if ( 1 > $attr['width'] || empty( $attr['caption'] ) )
        return $content;
        
    /* 
    * Nuevo atributo source
    * ejemplo de uso:
    * source="istockphoto.com;photographerusername"
    */
    if ( $attr['source'] != '' ) {
        $sourcedata = str_getcsv( $attr['source'], ';' );
        $source =   '<div class="wp-caption-source">
                        <span class="wp-caption-source-site"><i class="fa fa-globe"></i>'. $sourcedata[0] .'</span>
                        <span class="wp-caption-source-user"><i class="fa fa-user"></i>'. $sourcedata[1] .'</span>
                    </div>';
    }

	/* Set up the attributes for the caption &lt;div>. */
	$attributes = ( !empty( $attr['id'] ) ? ' id="' . esc_attr( $attr['id'] ) . '"' : '' );
	$attributes .= ' class="wp-caption ' . esc_attr( $attr['align'] ) . '"';
	$attributes .= ' style="width: ' . esc_attr( $attr['width'] ) . 'px"';

	/* Open the caption &lt;div>. */
	$output = '<figure' . $attributes .'>';

	/* Allow shortcodes for the content the caption was created for. */
	$output .= do_shortcode( $content );

	/* Append the caption text. */
	$output .= '<figcaption class="wp-caption-text">'. $attr['caption'] . $source .'</figcaption>';

	/* Close the caption &lt;/div>. */
	$output .= '</figure>';

	/* Return the formatted, clean caption. */
	return $output;
}


// Blog posts meta hook function. Overwrite.
if( !function_exists('hoskia_blog_posts_meta_cb') ){
    function hoskia_blog_posts_meta_cb(){

        $divide = '<span class="divider">'.esc_html__( '/', 'hoskia' ).'</span>';
        ?>
        <?php 
        if( hoskia_opt('hoskia_blog_posttitle_position') == '2' && get_the_title() ):
        ?>
        <div class="post--title">
            <h2 class="h4"><?php the_title(); ?></h2>
        </div>
        <?php 
        endif;
        ?>
        <div class="post--meta">
            <?php if( get_the_date() ): ?>
                <span><a href="<?php echo esc_url( hoskia_blog_date_permalink() ); ?>"><?php echo esc_html( get_the_date() ); ?></a></span>
            <?php endif; ?>
            <?php /* Old post--meta
                if( get_the_author() ):
                    <span><?php esc_html_e( 'by', 'hoskia' ); ?> <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta('ID') ) ); ?>"><?php the_author(); ?></a></span>
                    <?php 
                    echo wp_kses_post( $divide );
                endif;
                if( get_the_date() ):
                    ?>
                    <span><a href="<?php echo esc_url( hoskia_blog_date_permalink() ); ?>"><?php echo esc_html( get_the_date() ); ?></a></span>
                    <?php 
                    echo wp_kses_post( $divide );
                endif;
                if( hoskia_posted_comments() ):
                    ?>
                    <span><?php echo wp_kses_post( hoskia_posted_comments() ); ?></span>
                    <?php 
                endif;
            */ ?>
        </div>
        <?php
    }
}


// Featured image caption
add_shortcode('topcaption', 'ch_caption');
function ch_caption($atts, $content)
{

    $atts = shortcode_atts( array(
        'source' => '',
    ), $atts);

    if ( $atts['source'] != '' ) {
        $sourcedata = str_getcsv( $atts['source'], ';' );
        $source =   '<div class="ch-caption-top-source">
                        <span class="ch-caption-top-source-site"><i class="fa fa-globe"></i>'. $sourcedata[0] .'</span>
                        <span class="ch-caption-top-source-user"><i class="fa fa-user"></i>'. $sourcedata[1] .'</span>
                    </div>';
    }
    
    $output = '';

    $output .= '<div class="ch-caption-top">';
    $output .= do_shortcode($content);
    $output .= $source;
    $output .= '</div>';
    
    return $output;

}

function ejr_limite_extracto ($longitud) {
 return 30;
}
add_filter ('excerpt_length', 'ejr_limite_extracto', 999);

function excludePages($query) {

    if ($query->is_search) {
    
        $query->set('post_type', 'post');
    
    }
        return $query;
    
}
    
add_filter('pre_get_posts','excludePages');



// add_action('init', 'my_custom_rewrite'); 
// function my_custom_rewrite() {

//     add_permastruct('proveedor', '/%customname%/', false);

// }

// add_filter( 'post_type_link', 'my_custom_permalinks', 10, 2 );
// function my_custom_permalinks( $permalink, $post ) {
//       return str_replace( '%customname%/', $post->post_name, $permalink );
// }

// add_action('after_switch_theme', 'mytheme_setup');
// function mytheme_setup () {
//     flush_rewrite_rules();
// }

// function na_remove_slug( $post_link, $post, $leavename ) {

//     if ( 'Proveedores' != $post->post_type || 'publish' != $post->post_status ) {
//         return $post_link;
//     }

//     $post_link = str_replace( '/' . $post->post_type . '/', '/', $post_link );

//     return $post_link;
// }
// add_filter( 'post_type_link', 'na_remove_slug', 10, 3 );


// function na_parse_request( $query ) {

//     if ( !$query->is_main_query() || 2 != count( $query->query ) || !isset( $query->query['page'] ) ) {
//         return;
//     }

//     if ( !empty( $query->query['name'] ) ) {
//         $query->set( 'post_type', array( 'post', 'Proveedores', 'page' ) );
//     }
// }
// add_action( 'pre_get_posts', 'na_parse_request' );

?>

