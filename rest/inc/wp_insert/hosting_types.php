<?php
    $hostingTypeTaxName = "tipo";

    foreach($hosting_types as $hosting_type) {
        $hostingTypeName    =   $hosting_type->nombre;
        $id    =   $hosting_type->id;
        $term               =   term_exists($hostingTypeName, $hostingTypeTaxName);

        if($term === NULL) {
            $idterm = wp_insert_term(
                $hostingTypeName,
                $hostingTypeTaxName,
                [
                    'description'   =>  '',                    
                ]
            );
           update_option('IdTypeHosting_'.$id, $idterm['term_id']);
        }
    }
    