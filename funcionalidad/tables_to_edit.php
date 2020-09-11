<?php

function get_string_between($string, $start, $end)
{
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}



function proconTable($atts, $content = null)
{
    $pros = get_string_between($content, '[procon]', '[/procon]');
    $checks = get_string_between($content, '[check_list]', '[/check_list]');
    $cross = get_string_between($content, '[cross_list]', '[/cross_list]');


    $checks = explode(';', $checks);
    $cross = explode(';', $cross);
    $vorteile = __("Vorteile1", "paperback");
    $nachteile = __("Nachteile1", "paperback");

    $limit = 4;

    $output = "";
    $output .= "<div class='col-md-12'>";
    $output .= "<table class='table procontable'>";
    $output .= "<tr class='table-light'>";
    $output .= '<th style="width:50%"><div class="procon_title_icon"><i class="procon_green_circle fa fa-check-circle"></i><span class="procon_title" >' . $vorteile . '</span></div></th>';
    $output .= '<th style="width:50%"><div class="procon_title_icon"><i class="procon_red_circle fa fa-times-circle"></i><span class="procon_title" >' . $nachteile . '</span></div></th>';


    for ($i = 0; $i < $limit; $i++) {
        $output .= "<tr style='background:none;'>";

        $output .= ($checks[$i]) ? "<td style='vertical-align: top;'> <i class='fa  fa-check' style='color:#27ae60; display:inline-block; float:left; margin-top:6px;'></i><span class='procon_list' style='display:inline-block'> " . $checks[$i] . "</span></td>" : "<td></td>";
        $output .= ($cross[$i]) ? "<td style='vertical-align: top;'> <i class='fa fa-times' style='color:#f35245; display:inline-block; float:left; margin-top:6px;'></i><span class='procon_list' style='display:inline-block'> " . $cross[$i] . "</span></td>" : "<td></td>";
        $output .= "</tr>";
    }

    $output .= "</table>";

    return '' . $output . '';
}
add_shortcode('proconTable', 'proconTable');


?>