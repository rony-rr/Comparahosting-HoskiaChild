<?php
    $array_payment_methods = [];

    foreach($payment_methods as $key => $value){
        $array_payment_methods[$value->id] = $value->name;
    }
    
    update_option('payment_methods_vyg', $array_payment_methods);
