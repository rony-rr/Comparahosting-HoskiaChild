jQuery(document).ready(function() {

    // en el menu aparecio este error de li de momento se corrige con esto
    jQuery('ul#menu-primary-menu li').removeClass('active');

    // selector de redireccion en blog

    jQuery('ul#menu-primary-menu li > a').each( function(item){

        var url_related = document.location.origin;
        if( jQuery( this ).attr('title') == "Blog" ){
            jQuery( this ).removeAttr('data-toggle');
            jQuery( this ).attr('href', url_related+'/blog/');
        }        

    });

    // simulate_toggle();
    adjust_hei_cards_cupons_anual();
    adjust_hei_cards_cupons_mensual();
    

    jQuery('.pricing--item').removeClass('col-md-3').addClass('col-md-4');
    jQuery('.pricing--item').removeClass('col-sm-6').addClass('col-sm-12');
    jQuery('div #servicesTab').addClass('row');

    // jQuery('div.active')
    function readjust_banner_primary(){

        //reacomodando altura de container de banner's
        var altura_container_banner = jQuery(window).height() - 88;
        jQuery('body.home #banner.banner--section').css({ 
                                                            "height" : altura_container_banner, 
                                                            "max-height" : altura_container_banner, 
                                                            "min-height" : altura_container_banner 
                                                        });
        jQuery('body.home #banner.banner--section .banner--bg').css({ 
                                                                        "height" : altura_container_banner, 
                                                                        "max-height" : altura_container_banner, 
                                                                        "min-height" : altura_container_banner 
                                                                    });
        jQuery('body.home #banner.banner--section .banner--bg').css({ 
                                                                                        "height" : altura_container_banner, 
                                                                                        "max-height" : altura_container_banner, 
                                                                                        "min-height" : altura_container_banner 
                                                                                    });
        jQuery('body.home #banner.banner--section .banner--slider').css({ 
                                                                            "height" : altura_container_banner, 
                                                                            "max-height" : altura_container_banner, 
                                                                            "min-height" : altura_container_banner 
                                                                        });


        jQuery('body.home #banner .banner--slider.owl-carousel.owl-loaded').attr("data-carousel-loop", "false");
        let var_locat = jQuery(location).attr("href");
        jQuery('body.home #banner .banner--slider .banner--item').each( function(item){
            let banner_element = jQuery( this );

            let this_element_i = banner_element.find('.banner--content h2.h1');

            if( this_element_i.html() == "Wordpress" ){
                // console.log( this_element_i.html() );
                let url_banner_img = var_locat + "wp-content/themes/hoskia-child/img/banners/wordpress.png";
                // banner_element.children('.banner--bg').css({ "background-image": url_banner_img  });
                banner_element.children('.banner--bg').attr("data-bg-img", url_banner_img);
            }

            if( this_element_i.html() == "Compartido" ){
                // console.log( this_element_i.html() );
                let url_banner_img = var_locat + "wp-content/themes/hoskia-child/img/banners/compartido.png";
                // banner_element.children('.banner--bg').css({ "background-image": url_banner_img });
                banner_element.children('.banner--bg').attr("data-bg-img", url_banner_img);
            }

            if( this_element_i.html() == "Servidores Dedicados" ){
                // console.log( this_element_i.html() );
                let url_banner_img = var_locat + "wp-content/themes/hoskia-child/img/banners/dedicados.png";
                // banner_element.children('.banner--bg').css({ "background-image": url_banner_img });
                banner_element.children('.banner--bg').attr("data-bg-img", url_banner_img);
            }

            if( this_element_i.html() == "VPS" ){
                // console.log( this_element_i.html() );
                let url_banner_img = var_locat + "wp-content/themes/hoskia-child/img/banners/vps.png";
                // banner_element.children('.banner--bg').css({ "background-image": url_banner_img });
                banner_element.children('.banner--bg').attr("data-bg-img", url_banner_img);
            }

        });
    }
    
    function refres_banners_carousel(){
        var $owlCarousel = jQuery('.owl-carousel');
        $owlCarousel.trigger('refresh.owl.carousel');

    }


    jQuery('.nav-list-top5-class .ch-categories-item a').click(function() {

        if (jQuery(this).hasClass('unactive')) {
            var new_selected_nav = jQuery(this).attr('class').split(' ')[0];
            var old_selected_nav = jQuery('.nav-list-top5-class .ch-categories-item a.active').attr('class').split(' ')[0];
            //alert(new_selected_nav + old_selected_nav);
            jQuery('.nav-list-top5-class .ch-categories-item a.active').removeClass('active').addClass('unactive');
            jQuery(this).removeClass('unactive').addClass('active');

            jQuery('div.' + new_selected_nav).show();
            jQuery('div.' + old_selected_nav).hide();


        } else {
            null;
        }

    });


    /* alineando a posts items en pagina de blog */

    jQuery(window).resize(function () {
        acoplate_blog_posts_titles_height();
    });
       
    acoplate_blog_posts_titles_height();  
    
    function acoplate_blog_posts_titles_height(){

        if ( jQuery(window).width() < 768 ) {
            readjust_banner_primary();
            refres_banners_carousel();
        }

        if ( jQuery(window).width() >= 768 ) {

            var maximum = 0;
            jQuery('body.blog .post--items div.col-sm-4 div.post--item').each(function(){
                var value = parseFloat(jQuery(this).css("height"));
                maximum = (value > maximum) ? value : maximum;
            });
            maximum = 585;
            jQuery('body.blog .post--items div.col-sm-4 div.post--item').css({ "height": maximum + 20 });
            
            maximum = 0;
            jQuery('body.blog .post--items div.col-sm-4 div.post--item .post--img').each(function(){
                var value = parseFloat(jQuery(this).css("height"));
                maximum = (value > maximum) ? value : maximum;
            });
            maximum = 200;
            jQuery('body.blog .post--items div.col-sm-4 div.post--item .post--img').css({ "height": maximum });

            jQuery('body.blog .post--items div.col-sm-4 div.post--item .post--title h2').css({ "font-size": "20px" });
            maximum = 0;
            jQuery('body.blog .post--items div.col-sm-4 div.post--item .post--title').each(function(){
                var value = parseFloat(jQuery(this).css("height"));
                maximum = (value > maximum) ? value : maximum;
            });
            jQuery('body.blog .post--items div.col-sm-4 div.post--item .post--title').css({ "height": maximum });

            maximum = 0;
            jQuery('body.blog .post--items div.col-sm-4 div.post--item .post--img a img').each(function(){
                var value = parseFloat(jQuery(this).css("height"));
                maximum = (value > maximum) ? value : maximum;
            });
            var mwidth = 360;
            maximum = 200;
            jQuery('body.blog .post--items div.col-sm-4 div.post--item .post--img a img').css({ "height": maximum, "width": mwidth });            
            
            jQuery('body.blog .post--items div.col-sm-4 div.post--item .post--action').css({ 
                                                                                            "position": "absolute",
                                                                                            "bottom": "50px"		
                                                                                            });

        }

        if ( jQuery(window).width() >= 768 ) {

            var maximum = 0;
            jQuery('body.search.search-results .post--items div.col-sm-4 div.post--item').each(function(){
                var value = parseFloat(jQuery(this).css("height"));
                maximum = (value > maximum) ? value : maximum;
            });
            maximum = 585;
            jQuery('body.search.search-results .post--items div.col-sm-4 div.post--item').css({ "height": maximum + 20 });
            
            maximum = 0;
            jQuery('body.search.search-results .post--items div.col-sm-4 div.post--item .post--img').each(function(){
                var value = parseFloat(jQuery(this).css("height"));
                maximum = (value > maximum) ? value : maximum;
            });
            maximum = 200;
            jQuery('body.search.search-results .post--items div.col-sm-4 div.post--item .post--img').css({ "height": maximum });

            jQuery('body.search.search-results .post--items div.col-sm-4 div.post--item .post--title h2').css({ "font-size": "20px" });
            maximum = 0;
            jQuery('body.search.search-results .post--items div.col-sm-4 div.post--item .post--title').each(function(){
                var value = parseFloat(jQuery(this).css("height"));
                maximum = (value > maximum) ? value : maximum;
            });
            jQuery('body.search.search-results .post--items div.col-sm-4 div.post--item .post--title').css({ 
                                                                                                                "height": maximum,
                                                                                                                "display": "flex",
                                                                                                                "justify-content": "center",
                                                                                                                "align-items": "center",
                                                                                                                "align-content": "center",
                                                                                                                "text-align": "left",
                                                                                                                "margin-bottom": "8px" 
                                                                                                            });

            maximum = 0;
            jQuery('body.search.search-results .post--items div.col-sm-4 div.post--item .post--img a img').each(function(){
                var value = parseFloat(jQuery(this).css("height"));
                maximum = (value > maximum) ? value : maximum;
            });
            var mwidth = 360;
            maximum = 200;
            jQuery('body.search.search-results .post--items div.col-sm-4 div.post--item .post--img a img').css({ "height": maximum, "width": mwidth });            
            
            jQuery('body.search.search-results .post--items div.col-sm-4 div.post--item .post--action').css({ 
                                                                                            "position": "absolute",
                                                                                            "bottom": "50px"		
                                                                                            });

        }

        if ( jQuery(window).width() > 991 ) {
            /* alineando seccion de posts de home */

            var maximum = null;
            jQuery("#ch-post__block .ch-card-info").each(function() {
                var value = parseFloat(jQuery(this).css("height"));
                maximum = (value > maximum) ? value : maximum;
            });
            jQuery("#ch-post__block .ch-card-info").css({ "height": maximum });

            maximum = 0;
            jQuery("#ch-post__block .ch-card-info a img").each(function() {
                var value = parseFloat(jQuery(this).css("height"));
                maximum = (value > maximum) ? value : maximum;
            });
            jQuery("#ch-post__block .ch-card-info a img").css({ "height": maximum });

            maximum = 0;
            jQuery("#ch-post__block .ch-card-info h4.mt-4.px-4").each(function() {
                var value = parseFloat(jQuery(this).css("height"));
                maximum = (value > maximum) ? value : maximum;
            });
            jQuery("#ch-post__block .ch-card-info h4.mt-4.px-4").css({ "height": maximum });


            maximum = 0;
            jQuery("#ch-post__block .ch-card-info p.ch-card-describe.px-4").each(function() {
                var value = parseFloat(jQuery(this).css("height"));
                maximum = (value > maximum) ? value : maximum;
            });
            jQuery("#ch-post__block .ch-card-info p.ch-card-describe.px-4").css({ "height": maximum });

            // fin de función
        }


        if ( jQuery(window).width() >= 768 && jQuery(window).width() < 992 ) {
            jQuery('body.blog .post--items div.col-sm-4').each(function(item){
                if( jQuery(this).hasClass('col-sm-4') && !jQuery(this).hasClass('col-sm-6') ){
                    jQuery(this).removeClass('col-sm-4').addClass('col-sm-6');
                }
            });
            jQuery('body.search.search-results .post--items div.col-sm-4').each(function(item){
                if( jQuery(this).hasClass('col-sm-4') && !jQuery(this).hasClass('col-sm-6') ){
                    jQuery(this).removeClass('col-sm-4').addClass('col-sm-6');
                }
            });
        }else{
            jQuery('body.blog .post--items div.col-sm-4').each(function(item){
                if( jQuery(this).hasClass('col-sm-6') && !jQuery(this).hasClass('col-sm-4') ){
                    jQuery(this).removeClass('col-sm-6').addClass('col-sm-4');
                }
            });
            jQuery('body.search.search-results .post--items div.col-sm-4').each(function(item){
                if( jQuery(this).hasClass('col-sm-6') && !jQuery(this).hasClass('col-sm-4') ){
                    jQuery(this).removeClass('col-sm-6').addClass('col-sm-4');
                }
            });
        }



    }

    // Fin de función 




    //add btn class to a tag

    jQuery(".cardview-button-custom-style").addClass("btn");



    // codigo para manejar seccion de mapa y posts
    jQuery(".map-content .inner-fila .columns-fila2 h5").click(function() {

        var value_id = jQuery(this).attr("id");
        that = jQuery(this);
        jQuery(".map-content .inner-fila .columns-fila2 h5").removeClass("selected");
        that.removeClass("no-selected");
        that.addClass("selected");

        jQuery("div.map-content .inner-fila .columns-fila1 div.selected").removeClass("selected").addClass("no-selected");
        jQuery("div.map-content .inner-fila .columns-fila1 div#" + value_id).removeClass("no-selected").addClass("selected");
        
        jQuery("div.header-items-map h3 p.selected").removeClass("selected").addClass("no-selected");
        jQuery("div.header-items-map h3 p." + value_id).removeClass("no-selected").addClass("selected");

        jQuery(".map-content .inner-fila .columna-1-fila1 img.img-selected").removeClass("img-selected");
        jQuery(".map-content .inner-fila .columns-fila1 img." + value_id).addClass("img-selected");

        jQuery(".header-items-map .tooltiptext").html(that.html());

    });

    // Fin de funcion en la area de map


    // codigo para ordenar lista de paises en el map

    var elementos = jQuery('.columns-fila2.lista-paises a').get();

    elementos.sort(function(a, b) {
        var A = jQuery(a).text().toUpperCase();
        var B = jQuery(b).text().toUpperCase();
        return (A < B) ? -1 : (A > B) ? 1 : 0;
    });

    // for (let i = 0; i < elementos.length; i++) {
    //     if (i > 0) {

    //         elemento_actual = elementos[i];
    //         elemento_reemplazo = elementos[i + 3];

    //         elementos[i] = elemento_reemplazo;
    //         elementos[i + 3] = elemento_actual;
    //     }
    // }

    jQuery.each(elementos, function(id, elemento) {

        jQuery('.columns-fila2.lista-paises').append(elemento);

    });



    let var_countries_acc = 0;
    jQuery(".columns-fila2.lista-paises a").each(function(index) {

        if (var_countries_acc == 10) {
            jQuery(this).addClass("eleven_country");
        }

        if (var_countries_acc == 11) {
            jQuery(this).addClass("twelve_country");
        }


        var_countries_acc = var_countries_acc + 1;
    });

    // fin de codigo


    // codigo para manipular contenido en seccion de posts

    jQuery("#ch-post__block .second-show").hide();
    jQuery("#ch-post__block .third-show").hide();
    jQuery("#ch-post__block .four-show").hide();
    jQuery(".view-more-posts-related-button").attr("href", "https://www.comparahosting.com/blog/");

    /*
    jQuery(".view-more-posts-related-button").click(function() {
        if (jQuery("#ch-post__block .first-show").hasClass("active")) {
            jQuery("#ch-post__block .first-show").removeClass("active");
            jQuery("#ch-post__block .first-show").hide();
            jQuery("#ch-post__block .second-show").show();
            jQuery("#ch-post__block .second-show").addClass("active");
        } else if (jQuery("#ch-post__block .second-show").hasClass("active")) {
            jQuery("#ch-post__block .second-show").removeClass("active");
            jQuery("#ch-post__block .second-show").hide();
            jQuery("#ch-post__block .third-show").show();
            jQuery("#ch-post__block .third-show").addClass("active");
        } else if (jQuery("#ch-post__block .third-show").hasClass("active")) {
            jQuery("#ch-post__block .third-show").removeClass("active");
            jQuery("#ch-post__block .third-show").hide();
            jQuery("#ch-post__block .four-show").show();
            jQuery("#ch-post__block .four-show").addClass("active");
            jQuery(".view-more-posts-related-button").html("Ver más");
        } else {
            jQuery(".view-more-posts-related-button").attr("href", "https://comparahosting.x-dev.net/");
        }
    });
    */



    jQuery('.categoria-tit').click(function() {
        jQuery('.categoria-tit-list ul').slideToggle("fast");
        jQuery(this).find(".right").toggleClass("fa-angle-up fa-angle-down");
    });

    jQuery('.beneficios-tit').click(function() {
        jQuery('.beneficios-tit-list').slideToggle("fast");
        jQuery(this).find(".right").toggleClass("fa-angle-up fa-angle-down");
    });

    jQuery('.atencion-cli').click(function() {
        jQuery('.atencion-cli-list').slideToggle("fast");
        jQuery(this).find(".right").toggleClass("fa-angle-up fa-angle-down");
    });

    jQuery('.metodos-pago').click(function() {
        jQuery('.metodos-pago-list').slideToggle("fast");
        jQuery(this).find(".right").toggleClass("fa-angle-up fa-angle-down");
    });

    jQuery('.pais-').click(function() {
        jQuery('.pais-list').slideToggle("fast");
        jQuery(this).find(".right").toggleClass("fa-angle-up fa-angle-down");
    });


    function simulate_toggle() {
        jQuery('.categoria-tit-list ul').slideToggle("fast");
        jQuery(this).find(".right").toggleClass("fa-angle-up fa-angle-down");

        jQuery('.beneficios-tit-list').slideToggle("fast");
        jQuery(this).find(".right").toggleClass("fa-angle-up fa-angle-down");

        jQuery('.atencion-cli-list').slideToggle("fast");
        jQuery(this).find(".right").toggleClass("fa-angle-up fa-angle-down");

        jQuery('.metodos-pago-list').slideToggle("fast");
        jQuery(this).find(".right").toggleClass("fa-angle-up fa-angle-down");

        jQuery('.pais-list').slideToggle("fast");
        jQuery(this).find(".right").toggleClass("fa-angle-up fa-angle-down");
    }


    /* Control de cards de cupones mensual-anual */

    jQuery('#mensual-toggle-btn').click(function(){
        jQuery('.3-cards').show();
        jQuery('.2-cards').hide();

        adjust_hei_cards_cupons_mensual();
    });
    
    jQuery('#anual-toggle-btn').click(function(){
        jQuery('.2-cards').show();
        jQuery('.3-cards').hide();

        adjust_hei_cards_cupons_anual();
    });

    /* Fin de control */


    /* Asignacion en margenes de carousel js  */

    jQuery(window).load(function() {
        var margin_r = parseInt(jQuery('.section--compare .owl-item').css("margin-right"));
        jQuery('.section--compare .owl-item').css({ "margin-right": "0" });
        var _1_ = jQuery('.section--compare .owl-item').width();
        var _2_ = _1_ + margin_r;
        jQuery('.section--compare .owl-item').width(_2_);
    });

    var altura_contenedor_carousel_comp_cards = jQuery('.container--compare-cards').height();
    altura_contenedor_carousel_comp_cards = altura_contenedor_carousel_comp_cards / 2;

    /* En asignacion  */


    /* ajuste de altura de las cards de cupones  */
       
    function adjust_hei_cards_cupons_mensual() {
        
        var maximum = null;

        jQuery('div.mensual-cards .pricing--content .pricing--features').each(function(){
            var value = parseFloat(jQuery(this).css("height"));
            maximum = (value > maximum) ? value : maximum;
        });

        jQuery('div.mensual-cards .pricing--content .pricing--features').css({"height": maximum});
    }

    function adjust_hei_cards_cupons_anual() {
        
        var maximum = null;

        jQuery('div.anual-cards .pricing--content .pricing--features').each(function(){
            var value = parseFloat(jQuery(this).css("height"));
            maximum = (value > maximum) ? value : maximum;
        });

        jQuery('div.anual-cards .pricing--content .pricing--features').css({"height": maximum});
    }

  

    /* fin de ajuste de cards cupones */





    /* Peticiones bajo API AJAX */

    //esta variable almacena el contenido que trae por defecto la categoria
    let contenedor_por_term = jQuery('#build-by-term-find').html();


    function call_js_function_ajax_request(e) {

                // console.log('entro a la peticion');
                e.preventDefault();

                var ats = [];
        
                jQuery('input[name="at[]"]:checked').map(function(){
                    ats.push( jQuery(this).val() );
                });
        
        
                var pays = [];
        
                jQuery('input[name="pay[]"]:checked').each(function(){
                    pays.push( this.value );
                });
        
                var formData = {
                    'action' : 'get_results_filterpage',
                    'gar' : jQuery('select[name=gar]').val(),
                    'dom' : jQuery('select[name=dom]').val(),
                    'ssl' : jQuery('select[name=ssl]').val(),
                    'at' : ats.length > 0 ? ats : ' ',
                    'pay' : pays.length > 0 ? pays : ' ',
                    'ps' : jQuery('select[name=ps]').val(),
                    'a' : jQuery('input[name=a]').val(),
                    'current_category_slug' : jQuery('.current_cate').attr('id'),
                    'category_current_id' : jQuery('.current_cate').attr('term_id'),
                };

                // console.log(formData);
        
                jQuery.ajax({
                    url: hoskia_ajax.ajaxurl,  //variable por defecto para apuntar a admin-ajax.php
                    type: 'POST',
                    data: formData,
                    dataType:"html",
                    
                    beforeSend: function(){
                        jQuery('#loading_ajax_filter').css({"display":"flex"});
                        jQuery('#container-results-filterpage .resultados').css({"opacity":"0.5"});                        
                    },
                    
                    success: function( data ){
                      //Resultado desde el servidor
                      //Se ejecutan las siguientes acciones
                      //console.log( data );
                      jQuery('.loading_msg').html('Listo!');

                      var text_clean = String(data).replace(/\s+/g,'');
                      //   console.log( text_clean );

                      if( text_clean == 'Nohayposts' ){
                          
                        jQuery('#loading_ajax_filter').css({"display":"none"});
                        jQuery('#container-results-filterpage .resultados').remove();
                        jQuery('#container-results-filterpage').append(contenedor_por_term);

                      }else {

                        jQuery('#loading_ajax_filter').css({"display":"none"});
                        jQuery('#container-results-filterpage .resultados').remove();
                        jQuery('#container-results-filterpage').append(data);

                      }
                      
                    },
                    
                    error: function(response) {
                      //En caso de error se ejecuta lo siguiente
                      console.log(response);
                      jQuery('.loading_msg').html('Listo!');
                      jQuery('#container-results-filterpage').append('<br /><h5 class="tittle_result">Ocurrio un error al procesar la solicitud</h5>');
                    },
                    
                    complete: function( data ){
                      //Al completar la solicitud se ejecuta este codigo
                      jQuery('.loading_msg').css('color','green');
                      jQuery( ".detail-card " ).trigger( "click" );
                      jQuery( ".detail-card a" ).trigger( "click" );
                      
                    }
                
                })
                .done(function(data) {
                    //Si la solicitud se ejecuto con exito se ejecuta esto
                    // console.log('SUCCESS BLOCK');
                    // console.log(data);
                    
                    // Pila de funciones del DOM
                    call_reload_carousel_ajax();
                    change_values_filtering_plans_comparecards(); 
                    activate_utility_filters_modal_view();
                    loop_elements_by_add_counter_index_();
                    operate_quit_from_x();
                    // build_compare_cards_filter_var();
                })
                .fail(function(data) {
                    //Si hay un fallo esto de aqui
                    // console.log('ERROR');
                    // console.log(data);
                });
              
    }

    jQuery('.find_button_btn').click(function(e){
        
        call_js_function_ajax_request(e);

    });

    jQuery('select[name=gar], select[name=dom], select[name=ssl], select[name=ps], input[name="at[]"], input[name="pay[]"]').change(function(e){
        call_js_function_ajax_request(e);
    });


    /* Ajuste de Carrousel en las funciones de AJAX */
    function call_reload_carousel_ajax(){

        var root_element = jQuery('div.carrousel--compare-cards div.card-col');

        var count_items = 0;

        root_element.each(function(){

            count_items = count_items + 1;

        });

        var checkData = function (data, value) {
            return typeof data === 'undefined' ? value : data;
        };
        
        
        var $owlCarousel = jQuery('.owl-carousel');
        
        $owlCarousel.each(function () {
            var $t = jQuery(this);
            
            $t.owlCarousel({
                items: 5,
                margin: checkData( $t.data('carousel-margin'), 15 ),
                loop: false,
                smartSpeed: 1200,
                autoplay: checkData( $t.data('carousel-autoplay'), false ),
                autoplaySpeed: checkData( $t.data('carousel-smartspeed'), 1200 ),
                mouseDrag: count_items > 5 ? true : false,
                autoplayHoverPause: checkData( $t.data('carousel-hover-pause'), false ),
                nav: count_items > 5 ? true : false,
                navText: ['<i class="fa fa-long-arrow-left"></i>', '<i class="fa fa-long-arrow-right"></i>'],
                dots: checkData( $t.data('carousel-dots'), false ),
                responsive: {"0":{"items":"1"},"576":{"items": "1"},"768":{"items":5},"960":{"items":5}}
            });
        });

        if( count_items < 6 ){
            jQuery('.owl-nav div').hide();
        }else{
            jQuery('.owl-nav div').show();
        }


    }
    /* Fin de ajuste */

    /* Fin de funciones AJAX */



    /* Compare Filters Add Click function */

    // se acciona el boton que muestra el modal y su contenido de filtros
    function activate_utility_filters_modal_view(){
        
        jQuery('.end-button-comparacard.button-plus').click( function(){ 
        
            // variables de modal y contenedor de comparacion
            var modal_filtro = jQuery('#modal-results-filters');
            var content_carousel = jQuery('.section--compare.container--compare-cards.container--comparacards--view');
    
            // se muestra el modal y se oculta el comparador
            modal_filtro.css({ "visibility":"visible", "marginTop":"50px", "opacity":"1" });
            modal_filtro.show();
            content_carousel.hide();   

            
        });

    }
    activate_utility_filters_modal_view();
    // fin de funcion
    
    // array que contiene los items totales del comparador segun la busqueda 
    var index_arr_el_prov = [];

    // loop que recorre los items y los guarda en el array
    function build_compare_cards_filter_var(){

        index_arr_el_prov = [];
        
        jQuery('div.compare-card.result_filter_compare').each(function(){

            index_arr_el_prov.push( jQuery(this) );
    
        });

    }   
    build_compare_cards_filter_var(); 
    // end loop
    
    // accionar el boton de aplicar filtros seleccionados
    jQuery('#aplicar-filtros-seleccionados').click(function(){

        activate_filters_selecteds();
        activate_filters_selecteds();

    });

    function activate_filters_selecteds(){
        // variable de componentes modal y contenedor de carrusel
        var modal_filtro = jQuery('#modal-results-filters');
        var content_carousel = jQuery('.section--compare.container--compare-cards.container--comparacards--view');

        //se oculta el modal de filtros
        modal_filtro.css({ "visibility":"hidden", "marginTop":"-50px", "opacity":"0" });
        modal_filtro.hide();
        //se muestra el contenedor de comparacion
        content_carousel.show();

        // call a la funcion que define los filtros que se muestran u ocultan  
        show_hide_elements_by_filter_modal();

        // llamada a la funcion que hace un recuento de los proveedores que son visibles segun la eleccion del usuario
        // en esta misma funcion se redefine el carrusel y sus items 
        var new_items = count_show_elements_by_filter_modal();

        // se verifica que los items seleccionados sean mayores a 0 para recargar el carrusel
        if ( new_items > 0 ){

            // llamada a la funcion que aplica la nueva configuracion del carrusel
            call_reload_carousel_filtros( new_items );

        }

        // Pila de funciones del DOM
        change_values_filtering_plans_comparecards(); 
        activate_utility_filters_modal_view();
        loop_elements_by_add_counter_index_();
        operate_quit_from_x();
    }
    /* End functions */


    /* Funcion de agregar y quitar visualizacion de elementos segun filtros */
    function show_hide_elements_by_filter_modal(){
        
        var root_element = jQuery('.filter-content input[type="checkbox"]');

        root_element.each(function(){
            
            var id_component_this = jQuery(this).attr('name');

            if ( jQuery(this).is(":checked") ) {
                
                // los proveedores ya no requieren
                // var show_component = jQuery( '.' + id_component_this ).parent();
                // show_component.show();

                // Filtros
                var show_features = jQuery('div[feature='+ id_component_this +']');
                show_features.show();

            }
            else{
                
                // los proveedores ya no requieren ser ocultados
                // var hide_component = jQuery( '.' + id_component_this ).parent();
                // hide_component.hide();

                //filtros
                var hide_features = jQuery('div[feature='+ id_component_this +']');
                hide_features.hide();

            }
            

        });

    }
    /* End funcion */


    /* Contar elementos visibles y mostrar nuevo carrusel filtrado */
    function count_show_elements_by_filter_modal(){

        // se rompe el carrusel y se acciona un evento que limpia el comparador 
        jQuery('.owl-carousel').trigger('destroy.owl.carousel');
        // se limpia el contenedor del comparador 
        jQuery('div.owl-carousel').html('');

        // si quisiera solo eliminar un item del carrusel para ya no mostrarlo nunca mas seria con este hook de owl
        //jQuery(".owl-carousel").trigger('remove.owl.carousel', [item]).trigger('refresh.owl.carousel');

        //contador del loop para saber el index del item que se esta verificando actualmente
        var counter_index_arr = 0;
        
        // se seleccionan los inputs relacionados a los proveedores
        var root_element = jQuery('.filter-content div#filtrar-proveedores input[type="checkbox"]');

        // contador de items visibles segun la seleccion del usuario
        var count_items = 0;

        // loop que recorre los inputs relacionados a los proveedores
        root_element.each(function(){

            if ( jQuery(this).is(":checked") ) {
                
                //si esta seleccionado el proveedor se agrega 1 a la cuenta y el item se anade al comparador
                count_items = count_items + 1;
                jQuery('div.owl-carousel').append(index_arr_el_prov[counter_index_arr]);

            }else{

                // no hace nada si no esta seleccionado
                null;

            }   
            
            //incrementa en 1 el contador del loop que a su vez es el index siguiente del array de items del comparador
            counter_index_arr++;            

        });

        // retorna la cuenta de items que seran visibles
        return count_items;
    }
    /* Fin de conteo */


    /* Ajuste de Carrousel en las funciones de filtros */
    function call_reload_carousel_filtros(number_items){

        // se verifica la data de configuracion en el div del comparador
        var checkData = function (data, value) {
            return typeof data === 'undefined' ? value : data;
        };        
        
        // se recupera el componente del carrusel
        var $owlCarousel = jQuery('.owl-carousel');
        
        // se implementa el carrusel en un loop que verifica si hay mas de un componente ejecutando el carrusel
        $owlCarousel.each(function () {
            
            var $t = jQuery(this);
            
            $t.owlCarousel({
                items: 5,
                margin: checkData( $t.data('carousel-margin'), 15 ),
                loop: false,
                smartSpeed: 1200,
                autoplay: checkData( $t.data('carousel-autoplay'), false ),
                autoplaySpeed: checkData( $t.data('carousel-smartspeed'), 1200 ),
                mouseDrag: number_items > 5 ? true : false,
                autoplayHoverPause: checkData( $t.data('carousel-hover-pause'), false ),
                nav: number_items > 5 ? true : false,
                navText: number_items > 5 ? ['<i class="fa fa-long-arrow-left"></i>', '<i class="fa fa-long-arrow-right"></i>'] : '',
                dots: checkData( $t.data('carousel-dots'), false ),
                responsive: {"0":{"items":"1"},"576":{"items": "1"},"768":{"items":5},"960":{"items":5}}
            });

        });

        // $owlCarousel.trigger('refresh.owl.carousel');
        // se ajusta la opacidad del carrusel para que no se oculte por default
        $owlCarousel.css({"opacity":"1"});


        // se verifica que el numero de items sea coherente para mostrar u ocultar las navs 
        if( number_items < 6 ){
            jQuery('.owl-nav div').hide();
        }else{
            jQuery('.owl-nav div').show();
        }

    }
    /* Fin de ajuste */


    // Llamada a la funcion de construccion de inputs  para filtrar proveedores
    caption_providers_for_inputs_modal();


    /* Funcion de generacion de inputs en modal de filtros */
    function caption_providers_for_inputs_modal(){
        
        var counter_ea = 0;
        jQuery('div.compare-card.result_filter_compare').each(function() {           
            
            var id_tmp = jQuery(this).attr('id');
            var input_adding =  ' \
                                    <input class="check_provi" id="'+ id_tmp +''+ counter_ea +'" type="checkbox" name="' + id_tmp + '" value="'+ id_tmp +'" checked> \
                                    <label class="label_provi" for="'+ id_tmp +''+ counter_ea +'"> <img class="imagen_1" src="'+ jQuery(this).attr('prove-logo') + '" /> <img class="imagen_2" src="'+ jQuery(this).attr('prove-logo-gris') +'" /> </label><br></br> \
                                ';

            jQuery('#filtrar-proveedores').append('<div style="text-align: center; width: 100%; padding-left: 10px; position: relative; margin-bottom: 12px; ">' + input_adding + '</div>');
            
            counter_ea++;            

        });

    }    
    /* End funcion */



    // Llamada a la funcion de construccion de inputs  para filtrar features
    if( typeof ar !== "undefined" ){

        caption_features_for_inputs_modal(ar);

    }else{

        caption_features_for_inputs_modal(null);

    }

    /* Funcion de generacion de inputs en modal de filtros */
    function caption_features_for_inputs_modal(obj){

        if( obj === null ){
            
            return null;

        }else{

            var counter_cat_filtros = 0;
            obj.forEach(function(item){
                // console.log(item);

                var nombre_categoria = item.name_cat.replace(/ /g, "");
            
                jQuery('#modal-results-filters .filter-content').append('<div id="control-features-' + counter_cat_filtros + '" class="filtrar-features features-filter ctrl "><img style="width: 30px; margin: auto 10px auto 5px;" src="' + item.img + '" />' + item.name_cat + '<span class="count_features">' + "0" + '</span><span class="separation_burbuja"></span><i class="fa fa-minus right coloque_fig"></i></div>');
                jQuery('#modal-results-filters .filter-content').append('<div id="filters-'+ nombre_categoria +'" class="filtrar-features features-filter childs control-features-' + counter_cat_filtros + '" padre="control-features-' + counter_cat_filtros + '"></div>');
                
                                    
                /* Construcción de inputs de filtros por categoría */
                jQuery('div#features-fields-compare .adding-element').each(function() {
    
    
                    var feature = jQuery(this).attr('feature');
                    var display_status = jQuery(this).css("display");
                    var texto_label = jQuery(this).children().html();
                    // console.log(feature);

                    item.in_cat.forEach(function(feature_ie){ 
                    
                        var name_feature_finding = feature_ie.replace(/ /g, "");

                        if( name_feature_finding == feature ){

                            // console.log(name_feature_finding);
                            if( display_status == "none" ){
        
                                var input_adding =  ' \
                                                    <input id="' + feature +'" class="input-anadido-js" type="checkbox" name="' + feature + '" value="'+ feature +'" > \
                                                    <label class="label-anadido-js" style="" for="'+ feature +'"> <span>' + texto_label + '</span> </label><br></br> \
                                                ';
                
                                jQuery('#filters-'+ nombre_categoria).append('<div class="no-overflow" style="width: 100%;">' + input_adding + '</div>');
                
                            }
                            else{
                
                                var input_adding =  ' \
                                                    <input id="' + feature +'" class="input-anadido-js" type="checkbox" name="' + feature + '" value="'+ feature +'" checked> \
                                                    <label class="label-anadido-js" style="" for="'+ feature +'"> <span>' + texto_label + '</span> </label><br></br> \
                                                ';
                
                                jQuery('#filters-'+ nombre_categoria).append('<div class="no-overflow" style="width: 100%;">' + input_adding + '</div>');
                
                            }
    
                        }
                    
                    });


                });
                /* Fin de constructor de inputs */
    
                
                counter_cat_filtros++;
    
    
            });

        }
        
    }    
    /* End funcion */

    /* Funcion de contador de filtros seleccionados y burbuja de conteo */
    function counter_bubbles_features(){
        
        jQuery('.filter-content .filtrar-features input[type="checkbox"]').change(function(){

            let padre_span = jQuery( this ).parent().parent().attr('padre');
            let counter_this = jQuery('#' + padre_span + ' span.count_features').html();
        
            if( jQuery(this).is(":checked") ){
        
                counter_this++;
                jQuery('#' + padre_span + ' span.count_features').html( counter_this );
                if( counter_this <= 0 )
                { jQuery('#' + padre_span + ' span.count_features').hide(); }
                else{ jQuery('#' + padre_span + ' span.count_features').show(); }
        
            }
            else{
        
                counter_this--;
                jQuery('#' + padre_span + ' span.count_features').html( counter_this );
                if( counter_this <= 0 )
                { jQuery('#' + padre_span + ' span.count_features').hide(); }
                else{ jQuery('#' + padre_span + ' span.count_features').show(); }
        
            }
        
        });

    } 
    counter_bubbles_features(); 
    
    function init_hide_counters_bubbles(){

        jQuery('span.count_features').each(function(){
            
            jQuery( this ).hide();

        });
    }
    init_hide_counters_bubbles();
    /* END Funcion */

    // Control de animaciones en el modal de filtros
    jQuery('div.filtrar-features.features-filter.ctrl').click(function() {
        var identifier_div = jQuery( this ).attr("id");
        jQuery('.' + identifier_div).slideToggle("fast");
        jQuery(this).find(".right").toggleClass("fa-minus fa-plus");
    });
    jQuery('div.filtrar-features.features-filter.ctrl').trigger("click");
    //Fin de control de vista


    /* Changing vals of plan select in select comboboxes */
    function change_values_filtering_plans_comparecards(){
        
        jQuery('.card-col .plains-providers-select-compare select').change(function(){
        
            // seleccionar el elemento actualmente elejido
            var select_actual = jQuery( this );
            var valor_actual = jQuery( this ).val();
    
            select_actual.children().each(function(){
                
                var clase_segun_opcion = jQuery( this ).attr("value");
                // se oculta el elemento segun opcion seleccionado
                jQuery('.card-col .' + clase_segun_opcion).hide();
    
            });
    
            // se muestra al usuario la informacion actualmente elejida
            jQuery(".card-col ." + valor_actual).show();
    
    
        });

    }

    change_values_filtering_plans_comparecards();    
    /* end function */


    /* hide and show filteres */
    jQuery(".hide-filters").click(function(){
        
        jQuery(".no-display-comparador").hide();
        
    });

    jQuery(".show-filters").click(function(){
        
        jQuery(".no-display-comparador").show();
        
    });


    /* control de vista de caracteristicas */
    jQuery("#features-modal-filter-ctrl").click(function(){
        
        jQuery(this).addClass("active");
        jQuery("#providers-modal-filter-ctrl").removeClass("active");

        jQuery("#filtrar-proveedores").hide();
        jQuery(".filtrar-features.features-filter.ctrl").css({"display":"flex"});
        jQuery(".filtrar-features.features-filter.childs").hide();
        
    });

    jQuery("#providers-modal-filter-ctrl").click(function(){
        
        jQuery(this).addClass("active");
        jQuery("#features-modal-filter-ctrl").removeClass("active");

        jQuery(".filtrar-features").hide();
        jQuery("#filtrar-proveedores").css({"display":"grid"});
        
    });
    /* fin de vista */


    //agrego las redirecciones de los navs del banner slider de home 
    jQuery('h3.h3').each(function(){
        var cont_var = jQuery(this).html();

        if( cont_var == "Hosting para CMS" ){
            jQuery(this).replaceWith( '<a href="https://compa.x-dev.net/tipo/hosting-wordpress/"><h3 class="h3">'+ cont_var +'</h3></a>' );
        }

        if( cont_var == "Web hosting" ){
            jQuery(this).replaceWith( '<a href="https://compa.x-dev.net/tipo/web-hosting/"><h3 class="h3">'+ cont_var +'</h3></a>' );
        }

        if( cont_var == "Hosting VPS" ){
            jQuery(this).replaceWith( '<a href="https://compa.x-dev.net/tipo/hosting-vps/"><h3 class="h3">'+ cont_var +'</h3></a>' );
        }

        if( cont_var == "Servidores Dedicados" ){
            jQuery(this).replaceWith( '<a href="https://compa.x-dev.net/tipo/servidores-dedicados/"><h3 class="h3">'+ cont_var +'</h3></a>' );
        }
        
    });
    // fin 


    // se reacomoda el titulo de las paginas de paisesen el header
    var titulo_plantilla_paises = jQuery(".pais-template-default .page-header--title .h1").html();
    jQuery('.pais-template-default #pageHeader').css({"height": "242px"});
    jQuery(".pais-template-default .page-header--title .h1").html("Hosting " + titulo_plantilla_paises + ": Descubre y compara empresas para hostear tu sitio web");
    jQuery(".pais-template-default .page-header--title .h1").css({"width":"65%"});
    jQuery(".pais-template-default #pageHeader .container").css({"transform": "translateY(-30px)"});



    // funcion de recarga del carrusel inicial al cargar el dom
    function _call_reload_carousel_init_load_(){

        // evento que dispara la destruccion del carrusel
        jQuery('.carrousel--compare-cards').trigger('destroy.owl.carousel');

        // root de elementos de items de comparacion 
        var root_element = jQuery('div.carrousel--compare-cards div.card-col');

        // conteo de items visibles
        var count_items = 0;

        // loop de elementos visibles
        root_element.each(function(){

            count_items = count_items + 1;

        });

        // variable de verificacion de elementos de data del div del comparador
        var checkData = function (data, value) {
            return typeof data === 'undefined' ? value : data;
        };
        
        // elemento del comparador
        var $owlCarousel = jQuery('.owl-carousel');
        
        $owlCarousel.each(function () {
            var $t = jQuery(this);
            
            $t.owlCarousel({
                items: 5,
                margin: checkData( $t.data('carousel-margin'), 15 ),
                loop: false,
                smartSpeed: 1200,
                autoplay: checkData( $t.data('carousel-autoplay'), false ),
                autoplaySpeed: checkData( $t.data('carousel-smartspeed'), 1200 ),
                mouseDrag: count_items > 5 ? true : false,
                autoplayHoverPause: checkData( $t.data('carousel-hover-pause'), false ),
                nav: count_items > 5 ? true : false,
                navText: ['<i class="fa fa-long-arrow-left"></i>', '<i class="fa fa-long-arrow-right"></i>'],
                dots: checkData( $t.data('carousel-dots'), false ),
                responsive: {"0":{"items":"1"},"576":{"items": "1"},"768":{"items":5},"960":{"items":5}}
            });
        });

        // se plica la configuracion y ademas se asegura la visualizacion del comparador
        $owlCarousel.css({"opacity":"1"});

        // se verifica la cantidad de items para mostrar las navs
        if( count_items < 6 ){
            jQuery('.owl-nav div').hide();
        }else{
            jQuery('.owl-nav div').show();
        }


    }
    // fin de funcion

    // si es el documento de categorias o paises entonces se llama a la funcion de recarga del carrusel.
    if( jQuery('body.archive').length ){
        
        _call_reload_carousel_init_load_();

    }
    if( jQuery('body.single-pais').length ){
        
        _call_reload_carousel_init_load_();

    }
    // end de if



    // Script de control de events de modal - wizard

    // variable de almacenamiento de los values del wizard
    const a = [];

    // funcion que recupera los valores del wizard 
    function get_values_to_wizard(){

            var value = jQuery("#CF5e680254d7395_1 input:checkbox:checked").val();
            var type  = jQuery("#CF5e680254d7395_1 input:checkbox:checked").attr("data-calc-value");
            a.push(a[type] = value);   
        
    }
    // end de funcion

    // funcion que recupera todos los valores para la redireccion
    function get_all_values_wizard(){
            
            var value = jQuery("#CF5e680254d7395_1 input:checkbox:checked").val();
            var type  = jQuery("#CF5e680254d7395_1 input:checkbox:checked").attr("data-calc-value");
            
            a.push(a[type] = value); 
            console.log( a );
            
            // se valida si se hara la redireccion o no
            if( a["visitas_estimadas"] != undefined){
                    
                    // console.log( a );
                    window.location =  "https://" + window.location.hostname + "/tipo/"  + a["tipo-hosting"] + "?" + "cantidad_sitios=" + a['cantidad_sitios'] + "&metodo_pago=" + a['metodo_pago'] + "&presupuesto=" + a['presupuesto'] + "&trafico=" + a['visitas_estimadas'];
                    // string_uri = "https://" + window.location.hostname + "/tipo/"  + a["tipo-hosting"] + "?" + "cantidad_sitios=" + a['cantidad_sitios'] + "&metodo_pago=" + a['a'] + "&presupuesto=" + a['presupuesto'] + "&trafico=" + a['trafico'];
                    // console.log( string_uri );
            }

    }
    // end de funcion

    
    // se verifica la carga del documento y las llamadas a funciones de values
    jQuery(window).load(function(){

        jQuery('#abc').click(function(){ 
            
            get_values_to_wizard();

        });

        jQuery('#end_wizard_post').click(function(){
            
            get_all_values_wizard();

        });
        
    });
    // end de fucnion


    // se ajustan caracteristicas css de conteneodres en filtros
    jQuery('.row.resultados.detail-card.result_filter_details ').each(function(){

        jQuery( this ).css({"border-top":"solid 12px #3f5efb"});
        jQuery( this).css({"margin-top":"0px"});
        return false;

    });


    jQuery('.row.resultados.list-card.result_filter_list').each(function(){
        
        jQuery( this ).css({"border-top":"solid 12px #3f5efb"});
        jQuery( this).css({"margin-top":"0px"});
        return false;

    });
    // fin de ajustes


    // anclas de redireccion a paginas especiales
    //jQuery('.contact-info--content').html( '<a href="http://compa.x-dev.net/acerca/" >' + jQuery('.contact-info--content').html() + '</a>' );
    //
    

    var count_each_footer_links = 0;

    jQuery('.contact-info--item').each(function(item) { 
        
        if(count_each_footer_links == 0) 
        { 
            jQuery( this ).html( '<a style="display: flex;" href="http://compa.x-dev.net/acerca/" >' + jQuery( this ).html() + '</a>' ); 
        }  
        if(count_each_footer_links == 2 ){
            jQuery( this ).html( '<a style="display: flex;" href="https://compa.x-dev.net/politicas-de-privacidad/" >' + jQuery( this ).html() + '</a>' );
        }


        count_each_footer_links++;   
    
    });


    /* Sticky Logos */  
    if( jQuery('body.archive').length ){
        
        scrollable_logos_carousel();

    }
    if( jQuery('body.single-pais').length ){
        
        scrollable_logos_carousel();

    }
    
    function scrollable_logos_carousel(){
        
        jQuery(window).scroll(function(){
            
            var stickyComponenteTop = jQuery('#control_comparador_container').offset().top;
            // console.log( stickyComponenteTop );

            var alto_calculado = jQuery(window).scrollTop();

            if( alto_calculado > stickyComponenteTop ) {

                    var incremento_alto = (jQuery(window).scrollTop() - stickyComponenteTop);
                    incremento_alto = incremento_alto + 77;
                    var return_top = incremento_alto+'px';
                    // console.log( return_top );

                    jQuery('.sticky-image-comparacard').css({position: 'fixed', top: return_top});
                    jQuery('.sticky-image-comparacard').css('display', 'block');
            
            } else {

                    jQuery('.sticky-image-comparacard').css({position: 'static', top: '0px'});
                    jQuery('.sticky-image-comparacard').css('display', 'none');
            
            }

        });

    }
    /* fin de Sticky */

    /* botón de quitar proveedores */

    function loop_elements_by_add_counter_index_(){

        var countador = 0;

        jQuery('.quit-elements-by-x').each(function(){
            
            jQuery( this ).parent().parent().parent().attr("counter-index", countador);

            countador++;

        });
    
    }

    loop_elements_by_add_counter_index_();
    
    function operate_quit_from_x(){

        jQuery('.quit-elements-by-x').click(function(){ 
            
            let index_objeto_actual = jQuery( this ).parent().parent().parent().attr("counter-index");
            jQuery(".owl-carousel").trigger('remove.owl.carousel', [index_objeto_actual]).trigger('refresh.owl.carousel');

            let objeto_en_input_modal = jQuery( this ).parent().parent().parent().attr("id");
            console.log( objeto_en_input_modal );
            jQuery( 'input[name="'+objeto_en_input_modal+'"]').prop("checked", false);
            loop_elements_by_add_counter_index_();

        });        

    }

    operate_quit_from_x();
    /* Fin de add botons */

    /* animacion para llamar la atención en Comparador */
    function animatable_image_add_filters(){
        
        setInterval(function(){
            
            jQuery("#image-paste-to-plus-features-sticky-arrow").animate({'margin-left':'10px'},500)
            jQuery("#image-paste-to-plus-features-sticky-arrow").animate({'margin-left':'-10px'},500)
        
        },1000);

    }

    animatable_image_add_filters();
    /* fin de animación */

    //se ejecuta este script para dimensionar al mimo tamano las crads de cupones
    function heightControlle() {
        
        var maximum = null;

        jQuery('div.content-control').each(function(){
            var value = parseFloat(jQuery(this).css("height"));
            maximum = (value > maximum) ? value : maximum;
        });

        jQuery('div.content-control').css({"height": maximum});
    }

    // call de la funcion para ejecutar el script en la pila de funciones del objeto
    heightControlle();



    /* Replicar funcionalidad de botón que activa modal */

    function _wizard_replicate_call_(){
        
        var var_href = jQuery('a.caldera-forms-modal').attr("href");
        var var_data_form =  jQuery('a.caldera-forms-modal').attr("data-form");

        jQuery('li.searchavanzada a').attr("href", var_href).attr("data-form", var_data_form);
        jQuery('li.searchavanzada a').attr("data-form", var_data_form);
        
    }

    _wizard_replicate_call_();


    // verificar si es blog page y ejecutar JS
    if( jQuery('body.blog').length ){

        /* Insertar texto en el titulo de la pagina Blog */
        jQuery("<h4>Nuestra biblioteca virtual sobre hosting y más.</h4>").insertAfter('body.blog #pageHeader .container .page-header--title .h1');
        

        /* Reescribir texto en el botón leer más */
        jQuery('body.blog .post--item .post--action a').html('Leer más');

        function loop_spans_blog_reduce_(){        

            jQuery('body.blog .post--item .post--meta').each(function(){

                var reduce_count = 0;
                var spans_var = jQuery( this ).children("span");

                spans_var.each( function(){

                    if( reduce_count != 2 )
//                     jQuery( this ).css({"visibility":"hidden"});
                    reduce_count++;

                });

                // var attr = jQuery(this).attr("href");

                // if( typeof attr !== undefined && attr !== false ){

                // }

            });
        
        }
        // Ejecutar función
        loop_spans_blog_reduce_();


    }
    // Fin de Script
    

    // verificar si es plantilla de país y ejecutar JS
    if( jQuery('body.single-pais').length ){
    
        var cut_pais = jQuery('#extension_de_dominio').html();
        cut_pais = cut_pais.substr(0, 3).toLowerCase();

        jQuery('.hero_archive__description').html('Descubre dondé hostear tu dominio ' + cut_pais);
    
    }
    // Fin de Script

    /*Faq section links*/
    var count_each_faq_links = 0;

    jQuery('.features-grid--item').each(function(item) { 
        
        if(count_each_faq_links == 0) 
        { 
            jQuery( this ).html( '<a  href="https://compa.x-dev.net/que-es-el-hosting-para-que-sirve-y-que-tipos-hay/"  >' + jQuery( this ).html() + '</a>' ); 
        }  
        if(count_each_faq_links == 1 ){
            jQuery( this ).html( '<a  href="https://compa.x-dev.net/que-es-un-cms-y-para-que-sirve/" >' + jQuery( this ).html() + '</a>' );
        }

        if(count_each_faq_links == 2 ){
            jQuery( this ).html( '<a  href="https://compa.x-dev.net/que-es-un-dominio-explicacion-en-palabras-faciles/" >' + jQuery( this ).html() + '</a>' );
        }

        if(count_each_faq_links == 4 ){
            jQuery( this ).html( '<a  href="https://compa.x-dev.net/que-es-wordpress/" >' + jQuery( this ).html() + '</a>' );
        }

        if(count_each_faq_links == 3 ){
            jQuery( this ).html( '<a style="color: #FFFFFF;" href="https://compa.x-dev.net/certificados-de-seguridad-ssl-que-son-y-por-que-los-necesito/" >' + jQuery( this ).html() + '</a>' );
        }


        count_each_faq_links++;   
    
    });



    var count_each_faqs_links2 = 0;

    jQuery('.features-grid--content p').each(function(item) { 
        

        if(count_each_faqs_links2 == 3 ){
            jQuery( this ).html( '<a style="font-style: Montserrat" href="https://compa.x-dev.net/certificados-de-seguridad-ssl-que-son-y-por-que-los-necesito/" > <a style="font-style: Italic;color: #FFFFFF;"> Secure Socket Layer </a>, en inglés, es un título o credencial digital que tiene como objetivo identificar un dominio y un servidor web, es decir, autentificar la identidad de un sitio web para evitar problemas de privacidad del usuario' + jQuery( this ).html() + '</a>' );
        }


        count_each_faqs_links2++;   
    
    });

/*FIN DE SECCION FAQ*/

    if( jQuery('body.archive').length ){

        jQuery.urlParam = function(){
            var resultado_parametro = new RegExp('[\?&]' + 'ctrl_llg' + '=([^&#]*)').exec(window.location.href);
            if( resultado_parametro != null ){
                return resultado_parametro[1] || 0;
            }            
        }

        if( jQuery.urlParam('GETparameter') != 0 && jQuery.urlParam('GETparameter') != null )
        {
            jQuery(window).load(function() {
                jQuery( ".compare-card" ).trigger( "click" );
                jQuery( ".compare-card a" ).trigger( "click" );
                jQuery('.owl-carousel').trigger('destroy.owl.carousel');
                _call_reload_carousel_init_load_();   
                jQuery(".owl-carousel").trigger('refresh.owl.carousel');   
            });
        }
    
    }


    if( jQuery('body.post-template-default.single.single-post').length ){

        jQuery('div.post--action.clearfix ul.nav.social li span').html('<i class="fa fm fa-share-square-o"></i> Compartir en');
        jQuery('div.posts--cat ul.nav li span').html('<i class="fa fm fa-th-list"></i> Categoría: ');
        jQuery('div.posts--pager ul.pager li.previous a').html('<i class="fa fm fa-long-arrow-left"></i> Anterior');
        jQuery('div.posts--pager ul.pager li.next a').html('<i class="fa flm fa-long-arrow-right"></i> Siguiente');
        let cut_title_string = jQuery('div.page-header--title > h1.hero_archive__title').html();
        jQuery('div.page-header--title > h1.hero_archive__title').html( cut_title_string.slice(0, -1) );

    }

    if( ( jQuery('body.blog').length /*|| jQuery('body.search.search-results').length*/ ) && !jQuery('body.post-template-default.single.single-post').length ){

        jQuery('div#pageContent article.page--main-content.col-md-9').removeClass("col-md-9").addClass("col-md-12");
        jQuery('div#pageContent aside.page--sidebar.col-md-3').removeClass("col-md-3").css({"display":"none"});

        var counter_article_items_blog = 0;
        var width_item = 0;
        jQuery('div#pageContent article.page--main-content.col-md-12 div.post--items div.col-sm-4').each(function(){

            if( width_item == 0 ){

                width_item = jQuery( this ).width();
                
            }

            if( counter_article_items_blog == 0 ){

                counter_article_items_blog++;

            } else if( counter_article_items_blog == 1 ){

                jQuery( this ).css({"left":width_item});
                counter_article_items_blog++;

            }else if( counter_article_items_blog == 2 ){

                jQuery( this ).css({"left":width_item*2});
                counter_article_items_blog = 0;

            }

        });

    }


    //procedimiento para carrusel de cupones

    var executed_task_carrusel_coupon = false;

    jQuery(window).resize(function () {
        if( !executed_task_carrusel_coupon ){
            acoplate_coupon_carrusel();
        }
    });
    
    if( !executed_task_carrusel_coupon ){
        acoplate_coupon_carrusel();
    }    
    
    function acoplate_coupon_carrusel(){

        if ( jQuery(window).width() <= 991 ) {

            jQuery('div.cupon_element_cp').each( function(item){

                var element_to_insert = jQuery( this );
                if( element_to_insert.css("display") == "block" ){
                    
                    jQuery( this ).remove();
                    jQuery('.carrusel-de-cupones').append( element_to_insert ); 
                
                }
                

            }); 
            jQuery('.carrusel-de-cupones').css({ "display":"block" }); 
            executed_task_carrusel_coupon = true;          

        }

    }

    // Fin de función 
    

    
    if( jQuery('body.blog').length ){

        // Quitar elementos con visibilidad oculta
        function order_element_spandate_in_blog(){
                
            if ( jQuery(window).width() <= 991 ) {
                jQuery('.post--item .post--summery .post--meta span').each(function(item){
//                     if( jQuery( this ).css("visibility") == "hidden" ){

                        if( jQuery(window).width() <= 767 ){
                            jQuery('.post--item .post--summery .post--meta').css({"font-size":'14px'});
                        }else{
                            jQuery('.post--item .post--summery .post--meta').css({"font-size":'18px'});
                        }
//                         jQuery( this ).css({"display":"none", "visibility":"hidden"});
                        jQuery('.post--item .post--summery .post--meta').css({"text-align":'left'});
                        
//                     }
                });
            }else{
                jQuery('.post--item .post--summery .post--meta span').each(function(item){
//                     if( jQuery( this ).css("visibility") == "hidden" ){
//                         jQuery( this ).css({"display":"none", "visibility":"hidden"});
//                     }
                });
            }

        }

        order_element_spandate_in_blog();

        jQuery(window).resize(function (){
            order_element_spandate_in_blog();
        });

    }


    jQuery('body.post-template-default.single.single-post aside.page--sidebar.col-md-3 div.page--sidebar-widget .search--widget form').prepend('<h4 class=".h4_title" style="font-size: 17px; color: #303d48;">Buscar</h4>');


    // resize to single-proveedor page
    var altura_page_proveedor = jQuery(window).height() - 122;
    jQuery('body.proveedor-template-default.single.single-proveedor .banner_header_single_proveedor').height( altura_page_proveedor/1.2 );
    // jQuery('body.proveedor-template-default.single.single-proveedor div.container div.row.page--container > div').height( altura_page_proveedor );


    if( jQuery('body.proveedor-template-default.single.single-proveedor').length ){

        jQuery('body.proveedor-template-default.single.single-proveedor div.section3 .toggle_btn_providers_control ul li').click(function(){

            var identificador = jQuery( this ).attr('id');
            jQuery( 'body.proveedor-template-default.single.single-proveedor div.section3 div.planes_pricing_post .planes_section_container .plan_card').hide();
            jQuery( 'body.proveedor-template-default.single.single-proveedor div.section3 div.planes_pricing_post .planes_section_container .plan_card.item_' + identificador ).show();

        });

        jQuery('.section4 .post--comments-form #respond .post--comments-title h3').html('Deja un comentario');
        jQuery('.section4 .post--comments-form #respond > p').html('¿Qué está pasando en tu mente sobre esta publicación?');
        jQuery('.section4 .post--comments-form #respond > form .form-group .form-control[placeholder="Your Comment *"]').attr("placeholder", "Tu comentario *");
        jQuery('.section4 .post--comments-form #respond > form .form-group .form-control[placeholder="Name *"]').attr("placeholder", "Tu nombre *");
        jQuery('.section4 .post--comments-form #respond > form .form-group .form-control[placeholder="Email *"]').attr("placeholder", "Tu correo *");
        jQuery('.section4 .post--comments-form #respond > form .form-group .form-control[placeholder="Website"]').hide();
        jQuery('.section4 .post--comments-form #respond > form .form-group.col-md-4').removeClass('col-md-4');
        jQuery('.section4 .post--comments-form #respond > form .col-md-12 .checkbox label').html('<input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" value="yes" type="checkbox"> Tu dirección de correo electrónico no será publicada. Los campos obligatorios están marcados con *');
        jQuery('.section4 .post--comments-form #respond > form .col-md-12').css({"margin-left":"25px"});
        jQuery('.section4 .post--comments-form #respond > form .form-submit button').html("Dejar comentario");
        
    }

});



/*


*/