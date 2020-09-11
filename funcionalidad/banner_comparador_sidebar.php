<?php

    function banner_comparador_sidebar( ){

        $var_content_html = '';
        $var_js = '';

        $var_content_html .=    '
                                    <div class="top5_sidebar">
                                        <h4 class="h4_title">Comparativa de proveedores</h4>
                                        <a href="'. get_home_url() .'/tipo/hosting-compartido/?ctrl_llg=123456" >
                                            <img class="imag_banner_side" src="'.get_stylesheet_directory_uri() . '/img/elementos/banner_comparador_sidebar.png" />
                                        </a>
                                    </div>
                                ';


        $var_return = $var_content_html . $var_js;
        return $var_return;

    }

    add_shortcode('banner_comparador_sidebar', 'banner_comparador_sidebar');

?>