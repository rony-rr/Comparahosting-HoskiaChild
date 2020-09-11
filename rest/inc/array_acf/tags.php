<?php

    $array_tags = [];
    
    foreach($tags as $key => $value) {
        $array_tags[$key] = $value;
    }
    
    update_option('tags_vyg', $array_tags);