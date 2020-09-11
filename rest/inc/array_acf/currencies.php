<?php

    $array_currencies = [];
    
    foreach($currencies as $key => $value) {                
        $array_currencies[''.$value->id] = ''.$value->name;
    }
    
    update_option('currencies_vyg', $array_currencies);