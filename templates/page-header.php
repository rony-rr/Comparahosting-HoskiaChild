<?php
// Block direct access
if( !defined( 'ABSPATH' ) ){
    exit( 'Direct script access denied.' );
} 
/**
 * @Packge     : Hoskia
 * @Version    : 1.0
 * @Author     : ThemeLooks
 * @Author URI : https://www.themelooks.com/
 *
 */
 
	if( hoskia_meta('header_overlay') ){
		$overlay = 'bg--overlay';
	}else{
		$overlay = '';
	}

	// bg 
	$bg = '';
	if( hoskia_meta( 'page_header_settings' ) && hoskia_meta( 'page_header_settings' ) != 'global' ){
		if( hoskia_meta( 'header_bgimg' ) ){
			$bg = hoskia_data_bg_attr( esc_url( hoskia_meta( 'header_bgimg' ) ) );
		}
	}else{
		if( get_header_image() ){
			$bg = hoskia_data_bg_attr( get_header_image() );
		}
		
	}
	
	// Global Class
	if( hoskia_meta( 'page_header_settings' ) != 'pageset' ){
		$globalHeader = 'globpageheader ';
		
		if( hoskia_opt('hoskia_allHeader_overlay') ){
			$overlay = 'bg--overlay';
		}else{
			$overlay = '';
		}	
		
	}else{
		$globalHeader = '';
	}
 
    $class = 'class="'.esc_attr( $globalHeader.$overlay ).'"';
?>

<!-- Page Header Area Start -->
<div id="pageHeader" <?php echo wp_kses_post( $class.$bg ); ?> >
    <div class="container">
        <?php 
		// Page Header Title	
		echo '<div class="page-header--title">';	
		if(  is_hoskia_woocommerce_activated() && is_shop() ){
			echo '<h1 class="h1">';
				woocommerce_page_title();
			echo '</h1>';
			
		}else{

			if ( is_archive() ){
				$term = get_queried_object();
				?>
				<div class="hero_archive__content">
				<h1 class="hero_archive__title">Descúbre y compara empresas de <?php single_term_title(); echo get_field('imagen_header_taxonomy'); ?></h1>
				<p class="hero_archive__description">¿Estás buscando un <?php single_term_title() ?>? ComparaHosting te brinda las mejores comparativas de hosting en español.</p>
				</div>
				
				<?php
				echo "<style>#pageHeader.globpageheader {
					background-image: url(".get_field('imagen_header_taxonomy',$term).") !important;
					}</style>";
					
			}elseif ( is_home() ){
				$page_id  = get_queried_object_id();
				echo '<h1 class="h1">'.esc_html__( 'Blog', 'hoskia' ).'</h1>';

				echo "<style>#pageHeader.globpageheader {
					background-image: url(".get_field('imagen_de_header_pages_blog',$page_id ).") !important;
					}
					#pageHeader{
						height: 200px !important;
					}
					</style>";
			}elseif(is_search()){
				echo '<h1 class="h1">'.esc_html__( 'Search Result', 'hoskia' ).'</h1>';
			} else{
				$posttitle_position = hoskia_opt('hoskia_blog_posttitle_position');
				$postTitlePos = false;
				if( is_single() ){
					$type_post__ = get_post_type(  get_the_ID());
					if( $posttitle_position && $posttitle_position != '1' ){

						$postTitlePos = true;
					}
					
				}

				if( $postTitlePos != true ){
					if($type_post__ == "pais"){
					?>
				<div class="hero_archive__content">
				<p></p>
				<h1 class="hero_archive__title">Hosting <?php the_title(); ?><br> </h1>
				<p class="hero_archive__description">Descubre y compara empresas para hostear tu sitio web.</p>
				</div>
				<?php
				}else{
					?> <h1 class="hero_archive__title"><?php the_title(); ?> :</h1> <?php
				}
				}
				
			}
		}
		echo '</div>';

    	// Page Header Breadcrumb
    	if( hoskia_opt( 'hoskia_enable_breadcrumb' ) ){
	    	hoskia_breadcrumbs(
	    		array(
	    			'breadcrumbs_classes' => 'breadcrumb',
	    		)
	    	);
    	}
    	?>
    </div>
</div>
<?php
$type_post__ = get_post_type(  get_the_ID());
if($type_post__ == "pais"){
echo "<style>#pageHeader.globpageheader {
background-image: url(".get_field('imagen_header').") !important;
}
#pageHeader{
	height: 200px !important;
}
</style>";
}


?>