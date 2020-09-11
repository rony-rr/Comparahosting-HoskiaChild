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

	// Before wrapper Preloader
	if( !function_exists('hoskia_site_preloader') ){
		function hoskia_site_preloader(){
			if( hoskia_opt('hoskia_display_preloader') ):
			?>
				<div id="preloader">
			        <div class="preloader--spinner"></div>
			    </div>
			<?php
			endif;
		}
	}

	// Header menu hook function
	if( !function_exists( 'hoskia_header_cb' ) ){
		function hoskia_header_cb(){
			if( !is_404() ){
				get_template_part( 'templates/header', 'menu' );
				get_template_part( 'templates/header-menu', 'bottom' );
			}
		}
	}

	// Footer area hook function
	if( !function_exists( 'hoskia_footer_area' ) ){
		function hoskia_footer_area(){
			if( !is_404() ){
				//
				if( hoskia_opt( 'hoskia_footertop_switch' ) ){
					get_template_part( 'templates/footer', 'top' );
				}
				//
				get_template_part( 'templates/footer' );	
			}
		}
	}

	// Footer back to top hook function
	if( !function_exists( 'hoskia_back_to_top' ) ){
		function hoskia_back_to_top(){
			if( hoskia_opt( 'hoskia_display_bcktotop' ) ):
				?>
				<div id="backToTop">
		            <a href="body" class="AnimateScrollLink"><i class="fa fa-angle-up"></i></a>
		        </div>
				<?php
			endif;
		}
	}

	// Blog, single, page, search, archive pages wrapper start hook function.
	if( !function_exists('hoskia_wrp_start_cb') ){
		function hoskia_wrp_start_cb(){
			echo '<div id="pageContent" class="pd--100-0"><div class="container"><div class="row">';
		}
	}
	// Blog, single, page, search, archive pages wrapper end hook function.
	if( !function_exists('hoskia_wrp_end_cb') ){
		function hoskia_wrp_end_cb(){
			echo '</div></div></div>';
		}
	}

	// Blog, single, search, archive pages column start hook function.
	if( !function_exists('hoskia_blog_col_start_cb') ){
		function hoskia_blog_col_start_cb(){
			$sidebarOpt = hoskia_opt( 'hoskia_blog_sidebar' );
			$pageSidbar = hoskia_opt( 'hoskia_page_layoutopt' );
			$pageSidbarPos = hoskia_opt( 'hoskia_page_sidebar' );
			$gridOpt	= hoskia_blog_grid();
			
			
			if( !is_page() ){
				$pullRight  = hoskia_pull_right( $sidebarOpt , '2' );

				if( $sidebarOpt != '1' ){
					$col = '12'.$pullRight;

					$post_type = get_post_type();
					if($post_type == 'post'){
						$col = '9'.$pullRight;
					}
				}else{

					if( !is_single() && $gridOpt != '1' ){
						$col = '12';
					}else{
						$col = '12';
					}

				}
			}else{
				
				$pullRight  = hoskia_pull_right( $pageSidbarPos , '2' );
				
				$defaultcol = '12';
				
				if( !hoskia_is_ccap() ){
					if( $pageSidbar != '1' && $pageSidbarPos != '1' ){
						$col = '9'.$pullRight;
					}else{

						$col = $defaultcol;
					}
				}else{
					$col = $defaultcol;
				}
			}


			echo '<article class="page--main-content col-md-'.esc_attr( $col ).'">';
		}
	}
	// Blog, single, search, archive pages column end hook function.
	if( !function_exists('hoskia_blog_col_end_cb') ){
		function hoskia_blog_col_end_cb(){
			echo '</article>';
		}
	}

	// post or page items wrapper hook function.
	if( !function_exists('hoskia_post_items_wrp_start_cb') ){
		function hoskia_post_items_wrp_start_cb(){
			$gridOpt	= hoskia_blog_grid();

			$row = '';
			if( !is_single() && $gridOpt != '1' ){
				$row = 'row MasonryRow'.' ';
			}
			echo '<div class="'.esc_attr( $row ).'post--items">';
		}
	}
	// post or page items wrapper hook function.
	if( !function_exists('hoskia_post_items_wrp_end_cb') ){
		function hoskia_post_items_wrp_end_cb(){
			echo '</div>';
		}
	}

	// Blog post thumbnail hook function.
	if( !function_exists('hoskia_blog_posts_thumb_cb') ){
		function hoskia_blog_posts_thumb_cb(){
			// Thumbnail Show
			if( has_post_thumbnail() ){
				
				
				$anchorStart = '<a href="'.esc_url( get_the_permalink() ).'">';
				
				$anchorEnd = '</a>';
				
				$anchorStart = ( !is_single() ) ?  $anchorStart : '';
				$anchorEnd   = ( !is_single() ) ?  $anchorEnd : '';
				//
				$html = '';
				$html .= '<div class="post--img">';
				$html .= $anchorStart;
				
				$html .= hoskia_img_tag(
					array(
						'url' => esc_url( get_the_post_thumbnail_url() ),
						'class' => 'center-block m--0'
					)
				);
								
				$html .= $anchorEnd;
				$html .= '</div>';

				echo wp_kses_post( $html );

			}
			// Thumbnail check and video and audio thumb show
			if( !is_single() && !has_post_thumbnail() ){
				$html = '';
				if( has_post_format( array( 'video' ) ) ){
					
					$html .= '<div class="post--img blog-post-video">';
					$html .= hoskia_embedded_media( array( 'video', 'iframe' ) );
					$html .= '</div>';

				}else{

					if( has_post_format( array( 'audio' ) ) ){
						
						$html .= '<div class="post--img blog-post-audio">';
						$html .= hoskia_embedded_media( array( 'audio', 'iframe' ) );
						$html .= '</div>';
					}
				}
				
				echo apply_filters( 'embedded_media', $html );
				

			}
		}
	}

	// Blog post title hook function.
	if( !function_exists('hoskia_blog_posts_title_cb') ){
		function hoskia_blog_posts_title_cb(){
			if( get_the_title() ){

				$html = '';
				$html .= '<div class="post--title">';
				$html .= '<h2 class="h4"><a href="'.esc_url( get_the_permalink() ).'">'.esc_html( get_the_title() ).'</a></h2>';
				$html .= '</div>';

				echo wp_kses_post( $html );

			}
		}
	}

	// Blog posts meta hook function.
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
				<?php
				if( get_the_author() ):
				?>
				<span><?php esc_html_e( 'by', 'hoskia' ); ?> <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta('ID') ) ); ?>"><?php the_author(); ?></a></span>
				<?php 
				echo wp_kses_post( $divide );
				endif;
				//
				if( get_the_date() ):
				?>

				<span><a href="<?php echo esc_url( hoskia_blog_date_permalink() ); ?>"><?php echo esc_html( get_the_date() ); ?></a></span>
				<?php 
				echo wp_kses_post( $divide );
				endif;
				//
				if( hoskia_posted_comments() ):
				?>
				<span><?php echo wp_kses_post( hoskia_posted_comments() ); ?></span>
				<?php 
				endif;
				?>
			</div>
			<?php
		}
	}

	// Blog posts excerpt hook function.
	if( !function_exists('hoskia_blog_posts_excerpt_cb') ){
		function hoskia_blog_posts_excerpt_cb(){
			?>
			<div class="post--content">
				<?php 
				// Post excerpt
				echo hoskia_excerpt_length( hoskia_opt('hoskia_blog_postExcerpt') );

				// Link Pages
				hoskia_link_pages();
				?>
			</div>
			
			<div class="post--action">
				<a href="<?php the_permalink(); ?>" class="btn btn-primary"><?php esc_html_e( 'Read More', 'hoskia' ); ?></a>
			</div>
			<?php
		}
	}

	// Blog posts content hook function.
	if( !function_exists('hoskia_blog_posts_content_cb') ){
		function hoskia_blog_posts_content_cb(){
			?>
			<div class="post--content clearfix">
				<?php 
				the_content();

				// Link Pages
				hoskia_link_pages();
				?>
			</div>
			<?php
			/**
			 * Blog single Post social Share 
			 * @Hook  hoskia_blog_posts_share
			 *
			 * @Hooked hoskia_blog_posts_share_cb
			 * 
			 *
			 */
			if( hoskia_opt( 'hoskia_hide_shareBox' ) ){
				do_action( 'hoskia_blog_posts_share' );
			}

		}
	}

	// Page content hook function.
	if( !function_exists('hoskia_page_content_cb') ){
		function hoskia_page_content_cb(){
			?>
			<div class="post--content clearfix">
				<?php 
				the_content();

				// Link Pages
				hoskia_link_pages();
				?>
			</div>
			<?php
			// comment template.
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
		}
	}

	// Blog page sidebar hook function.
	if( !function_exists('hoskia_blog_sidebar_cb') ){
		function hoskia_blog_sidebar_cb(){

			$sidebar = hoskia_opt( 'hoskia_blog_sidebar' );

			if( $sidebar != '1' ){
				get_sidebar();
			}			
		}
	}


	// Page sidebar hook function.
	if( !function_exists('hoskia_page_sidebar_cb') ){
		function hoskia_page_sidebar_cb(){

			if( ! hoskia_is_ccap() ){
				$sidebar = hoskia_opt( 'hoskia_page_sidebar' );
				$pageSidebar = hoskia_opt( 'hoskia_page_layoutopt' );
				if( $pageSidebar != '1' ){
					if( $pageSidebar != '3' ){
						if( $sidebar != '1' ){
							get_sidebar('page');
						}
						
					}else{
						if( $sidebar != '1' ){

							get_sidebar();
						}
					}

				}
			}
		}
	}

	// Blog single post  social share hook function.
	if( !function_exists('hoskia_blog_posts_share_cb') ){
		function hoskia_blog_posts_share_cb(){
			if( function_exists('hoskia_social_sharing_buttons') ){
				echo '<div class="post--action clearfix">';
					hoskia_social_sharing_buttons( 'nav social', '<li><span><i class="fa fm fa-share-square-o"></i>Share On</span></li>' );
				echo '</div>';

			}
			
		}
	}

	// Blog single post meta category, tag, next-previous link and comments form hook function.
	if( !function_exists('hoskia_blog_single_meta_cb') ){
		function hoskia_blog_single_meta_cb(){

				// Categories 
				echo hoskia_post_cats();
				// Tags
				echo hoskia_post_tags();
				?>      
				<div class="posts--pager">
                    <ul class="pager">
                        <li class="previous"><?php next_post_link( '%link', '<i class="fa fm fa-long-arrow-left"></i>Newer Post ', false ); ?></li>
                        <li class="next"><?php previous_post_link( '%link', 'Older Post <i class="fa flm fa-long-arrow-right"></i>', false ); ?></li>
                    </ul>
                </div>
				<?php
				// Author biography
				if( '' !== get_the_author_meta('description') ){
					get_template_part( 'templates/biography' );
				}
				// comment template.
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}
			
		}
	}

	// Blog 404 page hook function.
	if( !function_exists('hoskia_fof_cb') ){
		function hoskia_fof_cb(){
			get_template_part( 'templates/404' );			
		}
	}


?>