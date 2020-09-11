<?php

    function banner_paises_sidebar( ){

        $var_content_html = '';
        $var_js = '';

        $var_content_html .=    '
                                    <div class="top5_sidebar" style="margin-top: 30px !important;">
                                        <a href="'. get_home_url() .'/#ch-page-section-3" >
                                            <img class="imag_banner_side" src="'.get_stylesheet_directory_uri() . '/img/elementos/banner_paises_sidebar.png" />
                                        </a>
                                    </div>
                                ';


        $var_return = $var_content_html . $var_js;
        return $var_return;

    }

    add_shortcode('banner_paises_sidebar', 'banner_paises_sidebar');

?>