<!-- Header Area Start -->

<header id="header">
	<!-- Header Topbar Start -->
	<?php
	if( hoskia_opt('hoskia_header_top') ):
	?>
	<div class="header--topbar">
		<div class="container">
			<?php 
			// Header Social
			if( hoskia_opt('hoskia_header_social') ){
				echo hoskia_social(
					array(
						'ul_class'  => 'header--social nav navbar-nav hidden-xs',
					)
				);
			}
			?>
			
			<?php 
			// Header Contact Info Start
			if( hoskia_opt( 'hoskia_header_topcontact' ) ):
			?>
			<ul class="header--contact-info nav navbar-nav navbar-right">
				<?php
				// Phone Number
				$mob   = hoskia_opt('hoskia_header_mobile'); 
				$email = hoskia_opt('hoskia_header_email'); 
				if( $mob ){
				
				$rep = array(
					' ',
					'-'
				);
				$repto = array(
					'',
					''
				);
				
				$numberHrf = str_replace( $rep, $repto, $mob );
				
				echo '<li><a href="tel:'.esc_attr( $numberHrf ).'"><i class="fa fm fa-phone-square"></i>'.esc_html( $mob ).'</a></li>';
				}
				// Email 
				if( $email ){

					echo '<li class="hidden-xxs"><a href="mailto:'.esc_attr( $email ).'"><i class="fa fm fa-envelope"></i>'.esc_html( $email ).'</a></li>';
				}
				?>
				
			</ul>
			<?php 
			endif;
			// Header Contact Info End
			?>
		</div>
	</div>
	<?php 
	endif;
	// Header Topbar End 
	?>
	
	<!-- Header Navbar Start -->
	<nav class="header--navbar navbar bg-color--alabaster" data-sticky="true">
		<div class="container">
			<!-- Header Navbar Header Start -->
			<div class="navbar-header">
				<?php 
				//Header Nav Cart Links Start
				
				if( hoskia_opt( 'hoskia_header_shopcart' ) && is_hoskia_woocommerce_activated() ):
				$cartCount = hoskia_woocommerce_cart_count();
				?>
				<ul class="header--nav-links cart nav navbar-nav hidden-lg hidden-md">
					<li>
						<?php echo wp_kses_post( $cartCount ); ?>
					</li>
				</ul>
				<?php 
				endif;
				// Header Nav Cart Links End

				// Header Nav Links Login link
				if( hoskia_opt('hoskia_header_btnurl') ):
				
				
				$logbtnimgicon = hoskia_opt( 'hoskia_logbtn_imgicon' );
				$logbtnicon    = hoskia_opt( 'header-logbtn-icon' );
				$tooltip       = hoskia_opt( 'header-logbtn-tooltip' );
				$getIcon = '';
				
				// Button Icon
				if( is_array( $logbtnimgicon ) && empty( $logbtnimgicon['url'] )  ){
					$getIcon = '<i class="fa '.esc_attr( $logbtnicon ).'"></i>';
				}else{
					$getIcon = hoskia_img_tag(
						array(
							'url' => esc_url( $logbtnimgicon['url'] ),
							
						)
					);
				}
				
				// Button Tool Tip
				if( $tooltip ){
					$tooltip = 'title="'.esc_attr( $tooltip ).'"';
				}else{
					$tooltip = '';
				}
				
				?>
				<ul class="header--nav-links client-area nav navbar-nav hidden-lg hidden-md hidden-xxs">
					<li><a <?php echo wp_kses_post( $tooltip ); ?> href="<?php echo esc_url( hoskia_opt('hoskia_header_btnurl')  ); ?>"><?php echo wp_kses_post( $getIcon ); ?></a></li>
				</ul>
				<?php 
				endif;
				?>				
				<!-- Header Navbar Toggle Button Start -->
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#headerNav">
					<span class="sr-only"><?php esc_html_e( 'Toggle navigation', 'hoskia' ); ?></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<!-- Header Navbar Toggle Button End -->
				
				<?php
				// Header Logo 
				if( hoskia_theme_logo() ){
					echo hoskia_theme_logo();
				}

				?>
			</div>
			<div id="headerNav" class="header--nav navbar-collapse collapse NavHoverIntent">
				<?php 
				// Header Nav Cart Links Start
				if( hoskia_opt( 'hoskia_header_shopcart' ) && is_hoskia_woocommerce_activated() ):
				?>
				<ul class="header--nav-links cart nav navbar-nav navbar-right hidden-sm hidden-xs">
					<li>
						<?php echo wp_kses_post( $cartCount );?>
					</li>
				</ul>
				<?php 
				endif;
				// Header Nav Cart Links End

				// Header Nav Links Start
				if( hoskia_opt('hoskia_header_btnurl') ):
				?>
				<ul class="header--nav-links client-area nav navbar-nav navbar-right hidden-sm hidden-xs ">
					<?php //$cont_poup_text_btn =  '<a ' . wp_kses_post( $tooltip ) . 'href="' . esc_url( hoskia_opt('hoskia_header_btnurl') ) . '">' . wp_kses_post( $getIcon ) . '</a>'; ?>
					<li><?php echo do_shortcode( '[caldera_form_modal id="CF5e680254d7395"]'. wp_kses_post( $getIcon ) .'[/caldera_form_modal]' );?></li>
				</ul>
				<?php 
				endif;

				// Header Nav Links End

				// Header Nav Links
				if( has_nav_menu('primary-menu') ){
					$args = array(
						'theme_location' => 'primary-menu',
						'menu_class' 	 => 'header--nav-links nav navbar-nav navbar-right',
						'depth' 		 => '3',
						'fallback_cb' 	 => 'hoskia_bootstrap_navwalker::fallback',
						'walker' 		 => new hoskia_bootstrap_navwalker(),
					);
					wp_nav_menu( $args );
				}
				?>
			</div>
			<!-- Header Nav End -->
		</div>
	</nav>
	<!-- Header Navbar End -->
</header>
<!-- Header Area End -->