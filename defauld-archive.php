<?php 
/**
 * @Packge 	   : Hoskia
 * @Version    : 1.0
 * @Author 	   : ThemeLooks
 * @Author URI : https://www.themelooks.com/
 *
 */
 
	// Block direct access
	if( !defined( 'ABSPATH' ) ){
		exit( 'Direct script access denied.' );
	}

	//  Call Header
	get_header();

	/**
	 * 
	 * Hook for Blog, single, page, search, archive pages
	 * wrapper start with wrapper div, container, row.
	 *
	 * Hook hoskia_wrp_start
	 *
	 * @Hooked hoskia_wrp_start_cb
	 *  
	 */
	do_action( 'hoskia_wrp_start' );

	/**
	 * 
	 * Hook for Blog, single, search, archive pages
	 * column start.
	 *
	 * Hook hoskia_blog_col_start
	 *
	 * @Hooked hoskia_blog_col_start_cb
	 *  
	 */
	do_action( 'hoskia_blog_col_start' );

	/**
	 * 
	 * Hook for post or page items wrapper start.
	 *
	 * Hook hoskia_post_items_wrp_start
	 *
	 * @Hooked hoskia_post_items_wrp_start_cb
	 *  
	 */
	do_action( 'hoskia_post_items_wrp_start' );

	if( have_posts() ){
		while( have_posts() ){
			the_post();
			// Post Contant
			get_template_part( 'templates/content', get_post_format() );
		}
		// Pagination
		get_template_part( 'templates/pagination' );
		// Reset Data
		wp_reset_postdata();
	}else{
		get_template_part( 'templates/content', 'none' );
	}

	/**
	 * 
	 * Hook for post or page items wrapper end.
	 *
	 * Hook hoskia_post_items_wrp_end
	 *
	 * @Hooked hoskia_post_items_wrp_end_cb
	 *  
	 */
	do_action( 'hoskia_post_items_wrp_end' );

	/**
	 * 
	 * Hook for Blog, single, search, archive pages
	 * column end.
	 *
	 * Hook hoskia_blog_col_end
	 *
	 * @Hooked hoskia_blog_col_end_cb
	 *  
	 */
	do_action( 'hoskia_blog_col_end' );

	/**
	 * 
	 * Hook for Blog, single blog, search, archive pages sidebar.
	 *
	 * Hook hoskia_blog_sidebar
	 *
	 * @Hooked hoskia_blog_sidebar_cb
	 *  
	 */
	do_action( 'hoskia_blog_sidebar' );
 	
 	/**
	 * Hook for Blog, single, page, search, archive pages
	 * wrapper end with wrapper div, container, row.
 	 *
 	 * Hook hoskia_wrp_end
 	 * @Hooked  hoskia_wrp_end_cb
 	 *
 	 */
 	do_action( 'hoskia_wrp_end' );
 	
	 // Call Footer
	 get_footer();
?>