<?php

    if(isset($_POST['lang'])) {
        include_once( ABSPATH . 'wp-admin/includes/image.php' );
        include "curl_packages.php";
        include "function/save_img.php";
        include "function/have_posts.php";

        /// objets
        $countries          =   $response->countries;           // POST
        $currencies         =   $response->currencies;          // ACF
        $hosting_types      =   $response->hosting_types;       // TAX
        $customer_supports  =   $response->customer_supports;   // ACF

        $payment_methods    =   $response->payment_methods;     // la informacion se guarda en payment_methods_vyg  get_option, esto remplazara ACF
        
        $tags               =   $response->tags;                // ACF
        $providers          =   $response->providers;           // PostType
        $plan_features      =   $response->plan_features;       // Catalog Only
        $plans              =   $response->plans;               // PostType
        $plan_types         =   $response->plan_types;               // PostType
        $coupons            = $response->coupons;           // coupons


        $custom_plan_features = [];
        foreach($plan_features as $po){
                $custom_plan_features[$po->id] = $po->name;
        }
        $type_plan__ = [];
        foreach($plan_types as $po){
            $type_plan__[$po->id] = $po->name;
        }
        
       update_option('type_plan__', $type_plan__);
        // countries
       include "wp_insert/countries.php";
        // currencies
    //    include "array_acf/currencies.php";
        // hosting_types
      include "wp_insert/hosting_types.php";     // Insert Taxonimias
        // customer_supports 
      include "array_acf/customer_supports.php"; // Save Option Customer
        // payment_methods 
      include "array_acf/payment_methods.php";    //   Save Option Payment  
        // tags
        //  include "array_acf/tags.php";             //   Save Option Tags
        // providers
      include "wp_insert/providers.php";
        // plans
        include "wp_insert/plans.php";
        //coupons
         include "wp_insert/coupons.php";
    }