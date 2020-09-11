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

	/**
	 *
	 * Before Wrapper
	 *
	 * @Preloader
	 *
	 */
	add_action( 'hoskia_preloader', 'hoskia_site_preloader', 10 );

	/**
	 * Header
	 *
	 * @Header Menu
	 * @Header Bottom
	 * 
	 */

	add_action( 'hoskia_header', 'hoskia_header_cb', 10 );

	/**
	 * Hook for footer
	 *
	 */
	add_action( 'hoskia_footer', 'hoskia_footer_area', 10 );
	add_action( 'hoskia_footer', 'hoskia_back_to_top', 20 );

	/**
	 * Hook for Blog, single, page, search, archive pages wrapper.
	 */
	add_action( 'hoskia_wrp_start', 'hoskia_wrp_start_cb', 10 );
	add_action( 'hoskia_wrp_end', 'hoskia_wrp_end_cb', 10 );

	/**
	 * Hook for Blog, single, search, archive pages column.
	 */
	add_action( 'hoskia_blog_col_start', 'hoskia_blog_col_start_cb', 10 );
	add_action( 'hoskia_blog_col_end', 'hoskia_blog_col_end_cb', 10 );

	/**
	 * Hook for post or page items wrapper.
	 */
	add_action( 'hoskia_post_items_wrp_start', 'hoskia_post_items_wrp_start_cb', 10 );
	add_action( 'hoskia_post_items_wrp_end', 'hoskia_post_items_wrp_end_cb', 10 );

	/**
	 * Hook for blog posts thumbnail.
	 */
	add_action( 'hoskia_blog_posts_thumb', 'hoskia_blog_posts_thumb_cb', 10 );

	/**
	 * Hook for blog posts title.
	 */
	add_action( 'hoskia_blog_posts_title', 'hoskia_blog_posts_title_cb', 10 );

	/**
	 * Hook for blog posts meta.
	 */
	add_action( 'hoskia_blog_posts_meta', 'hoskia_blog_posts_meta_cb', 10 );

	/**
	 * Hook for blog posts excerpt.
	 */
	add_action( 'hoskia_blog_posts_excerpt', 'hoskia_blog_posts_excerpt_cb', 10 );

	/**
	 * Hook for blog posts content.
	 */
	add_action( 'hoskia_blog_posts_content', 'hoskia_blog_posts_content_cb', 10 );

	/**
	 * Hook for blog sidebar.
	 */
	add_action( 'hoskia_blog_sidebar', 'hoskia_blog_sidebar_cb', 10 );
	/**
	 * Hook for blog single post social share option.
	 */
	add_action( 'hoskia_blog_posts_share', 'hoskia_blog_posts_share_cb', 10 );
	/**
	 * Hook for blog single post meta category, tag, next - previous link and comments form.
	 */
	add_action( 'hoskia_blog_single_meta', 'hoskia_blog_single_meta_cb', 10 );
	/**
	 * Hook for page content.
	 */
	add_action( 'hoskia_page_content', 'hoskia_page_content_cb', 10 );
	/**
	 * Hook for page sidebar.
	 */
	add_action( 'hoskia_page_sidebar', 'hoskia_page_sidebar_cb', 10 );
	/**
	 * Hook for 404 page.
	 */
	add_action( 'hoskia_fof', 'hoskia_fof_cb', 10 );

?>