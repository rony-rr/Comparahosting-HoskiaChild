<!DOCTYPE html>
<html <?php language_attributes() ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	
    <?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php endif; ?>

    <?php wp_head(); ?>
</head>
<style>
    @media (max-width: 1600px) { 
        .text_nostros{
            margin-top: 0 !important;
            margin-left: 0 !important;
            position: initial !important;
            margin-right: 0 !important;
            font-style: italic;
        }

        .name_autor{
            margin-left: 0 !important;
            margin-top: 0 !important;
            position: initial !important;
        }

        .content_icons{
            display: flex;
            margin-top: 50px;
            text
        }

        .imgpe1 {
            position: inherit !important;
            margin-left: 0 !important;
            height: auto !important;
        }
        .imgpe2 {
            position: inherit !important;
            margin-left: 0 !important;
            height: auto !important;
        }
        .imgpe3 {
            position: inherit !important;
            margin-left: 0 !important;
            height: auto !important;
        }
        .imgpe4 {
            position: inherit !important;
            margin-left: 0 !important;
            height: auto !important;
        }
        .clasnone{
            display : none !important;
        }

        .img_nostros{
            float: left !important;
        }
    }

.text_nostros{
margin-top: -231px;
margin-left: 542px;
text-align: justify;
position: absolute;
margin-right: 270px;
font-style: italic;
}

.name_autor{
    margin-left: 760px;
    margin-top: -101px;
    position: absolute;
}
</style>

<body <?php body_class(); ?>>

    <?php 
    /**
     * Preloader Start
     *
     * @Hook hoskia_preloader
     *
     * @Hooked hoskia_site_preloader 10
     *
     */
    do_action( 'hoskia_preloader' );
    ?>
    
    <div class="wrapper">
    <?php 
    /**
     * Header Area Start
     * Header menu
     * Header Bottom
     * 
     * @Hook hoskia_header
     *
     * @Hooked hoskia_header_cb 10
     */
	if( !is_page_template( 'template-comingsoon.php' ) ){
		do_action( 'hoskia_header' );
	}
	
    ?>
    
