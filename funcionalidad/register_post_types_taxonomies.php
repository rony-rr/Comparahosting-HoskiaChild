<?php
/* Creacion de Custom Posts Type para hosting */
/* Register Post Types */
add_action( 'init', 'comparahosting_register_post_type_proveedores' );

function comparahosting_register_post_type_proveedores()
{

  /**
   * Post type: Proveedores
   */
  $labels = array(
    "name" => __( "Proveedores", "" ),
    "singular_name" => __( "proveedor", "" ),
    "menu_name" => __( "Proveedores", "" ),
  );

  $args = array(
    "label" => __( "Proveedores", "" ),
    "labels" => $labels,
    "description" => "",
    "public" => true,
    "publicly_queryable" => true,
    "show_ui" => true,
    "show_in_rest" => false,
    "rest_base" => "",
    "has_archive" => false,
    "show_in_menu" => true,
    "exclude_from_search" => false,
    "capability_type" => "post",
    "map_meta_cap" => true,
    "hierarchical" => false,
    "rewrite" => array( "slug" => "proveedor", "with_front" => false ),
    "query_var" => true,
    "menu_icon" => "dashicons-awards",
    "supports" => array( "title", "editor", "thumbnail", 'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes' ),
  );

  register_post_type( "proveedor", $args );


}
/* fin de registro de post-type
/* Register taxonomies */
// add_action( 'init', 'comparahosting_register_taxonomies' );

// function comparahosting_register_taxonomies()
// {
//   $labels = array(
//     "name"          => __("Tipos de Hosting", ""),
//     "singular_name" => __("Tipo de Hosting", ""),
//   );

//   $args = array(
//     "label"              => __("Tipos de Hosting", ""),
//     "labels"             => $labels,
//     "public"             => TRUE,
//     "hierarchical"       => TRUE,
//     "label"              => "Tipos de Hosting",
//     "show_ui"            => TRUE,
//     "show_in_menu"       => TRUE,
//     "show_in_nav_menus"  => TRUE,
//     "query_var"          => TRUE,
//     "rewrite"            => array(
//       'hierarchical' => TRUE, // We use hierarchy for creating the rewrite rules
//       'with_front'   => FALSE
//     ),
//     "show_admin_column"  => FALSE,
//     "show_in_rest"       => FALSE,
//     "rest_base"          => "",
//     "show_in_quick_edit" => FALSE,
//   );
//   register_taxonomy("tipo", array("proveedor"), $args);

// }}

// Register Custom Taxonomy
function custom_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Taxonomies', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Taxonomy', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Taxonomy', 'text_domain' ),
		'all_items'                  => __( 'All Items', 'text_domain' ),
		'parent_item'                => __( 'Parent Item', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Item:', 'text_domain' ),
		'new_item_name'              => __( 'New Item Name', 'text_domain' ),
		'add_new_item'               => __( 'Add New Item', 'text_domain' ),
		'edit_item'                  => __( 'Edit Item', 'text_domain' ),
		'update_item'                => __( 'Update Item', 'text_domain' ),
		'view_item'                  => __( 'View Item', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
		'popular_items'              => __( 'Popular Items', 'text_domain' ),
		'search_items'               => __( 'Search Items', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
		'no_terms'                   => __( 'No items', 'text_domain' ),
		'items_list'                 => __( 'Items list', 'text_domain' ),
		'items_list_navigation'      => __( 'Items list navigation', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'tipo', array( 'proveedor' ), $args );

}
add_action( 'init', 'custom_taxonomy', 0 );
/* Fin de Codigo parea custom taxonomies */


/* registro de post-type Opiniones */

add_action( 'init', 'comparahosting_register_post_type_opiniones' );

function comparahosting_register_post_type_opiniones(){
  /**
   * Post type: Opiniones
   */
  $labels = array(
    "menu_name"     => __( "Opiniones", "" ),
    "name"          => __( "Opiniones", "" ),
    "singular_name" => __( "Opinión", "" ),
  );

  $args = array(
    "exclude_from_search" => true,
    "has_archive"         => false,
    "label"               => __( "Opiniones", "" ),
    "labels"              => $labels,
    "menu_icon"           => "dashicons-star-filled",
    "public"              => false,
    "query_var"           => false,
    'show_ui'             => true,
  );

  register_post_type( "opiniones", $args );
}
/*fin de registro de post-type*/

/* Creacion de Custom PostType Paises  */
/* Register Post Type: Paises*/
add_action( 'init', 'comparahosting_register_post_type_paises' );

function comparahosting_register_post_type_paises()
{

  /**
   * Post type: Paises
   */
  $labels = array(
    "name" => __( "Paises", "" ),
    "singular_name" => __( "pais", "" ),
    "menu_name" => __( "Paises", "" ),
  );

  $args = array(
    "label" => __( "Paises", "" ),
    "labels" => $labels,
    "description" => "",
    "public" => true,
    "publicly_queryable" => true,
    "show_ui" => true,
    "show_in_rest" => false,
    "rest_base" => "",
    "has_archive" => false,
    "show_in_menu" => true,
    "exclude_from_search" => false,
    "capability_type" => "post",
    "map_meta_cap" => true,
    "hierarchical" => false,
    "rewrite" => array( "slug" => "pais", "with_front" => false ),
    "query_var" => true,
    "menu_icon" => "dashicons-location-alt",
    "supports" => array( "title", "editor", "thumbnail" ),
  );

  register_post_type( "pais", $args );


}
/* fin de registro de post-type paises */



/* Creacion de Custom PostType Planes  */
/* Register Post Type: Planes*/
add_action( 'init', 'comparahosting_register_post_type_planes' );

function comparahosting_register_post_type_planes()
{

  /**
   * Post type: Planes
   */
  $labels = array(
    "name" => __( "Planes", "" ),
    "singular_name" => __( "plan", "" ),
    "menu_name" => __( "Planes", "" ),
  );

  $args = array(
    "label" => __( "Planes", "" ),
    "labels" => $labels,
    "description" => "",
    "public" => true,
    "publicly_queryable" => true,
    "show_ui" => true,
    "show_in_rest" => false,
    "rest_base" => "",
    "has_archive" => false,
    "show_in_menu" => true,
    "exclude_from_search" => false,
    "capability_type" => "post",
    "map_meta_cap" => true,
    "hierarchical" => false,
    "rewrite" => array( "slug" => "plan", "with_front" => false ),
    "query_var" => true,
    "menu_icon" => "dashicons-welcome-add-page",
    "supports" => array( "title", "editor", "thumbnail" ),
  );

  register_post_type( "plan", $args );


}
/* fin de registro de post-type Planes */


/* Creacion de Custom PostType Cupones  */
/* Register Post Type: Cupones */
add_action( 'init', 'comparahosting_register_post_type_cupones' );

function comparahosting_register_post_type_cupones()
{

  /**
   * Post type: Planes
   */
  $labels = array(
    "name" => __( "Cupones", "" ),
    "singular_name" => __( "cupon", "" ),
    "menu_name" => __( "Cupones", "" ),
  );

  $args = array(
    "label" => __( "Cupones", "" ),
    "labels" => $labels,
    "description" => "",
    "public" => true,
    "publicly_queryable" => true,
    "show_ui" => true,
    "show_in_rest" => false,
    "rest_base" => "",
    "has_archive" => false,
    "show_in_menu" => true,
    "exclude_from_search" => false,
    "capability_type" => "post",
    "map_meta_cap" => true,
    "hierarchical" => false,
    "rewrite" => array( "slug" => "cupon", "with_front" => false ),
    "query_var" => true,
    "menu_icon" => "dashicons-tickets",
    "supports" => array( "title", "editor", "thumbnail" ),
  );

  register_post_type( "cupon", $args );


}
/* fin de registro de post-type Cupones */

?>