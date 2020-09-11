<?php 
/**
 * @Packge     : Hoskia
 * @Version    : 1.0
 * @Author     : ThemeLooks
 * @Author URI : https://www.themelooks.com/
 *
 */
 
    // Block direct access
    if( !defined( 'ABSPATH' ) ){
        exit( 'Direct script access denied.' );
    }
?>

        <?php 
        /**
         * Footer Area
         *
         * @Footer
         * @Back To Top Button
         *
         * @Hook hoskia_footer
         *
         * @Hooked  hoskia_footer_area 10
         * @Hooked hoskia_back_to_top 20 
         *
         */
		if( !is_page_template( 'template-comingsoon.php' ) ){
			do_action( 'hoskia_footer' );
		}
        ?>
        
    </div>
    <!-- Wrapper End -->
    
    <?php wp_footer(); ?>
    
</body>
</html>