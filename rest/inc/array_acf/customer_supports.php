<?php

    $array_customer_supports = [];

    foreach($customer_supports as $key => $value){
        $array_customer_supports[$value->id] = $value->name;
    }

    update_option('customer_supports_vyg', $array_customer_supports);
