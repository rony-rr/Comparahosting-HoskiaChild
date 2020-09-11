<?php
/// CREATE MENU 
add_action('admin_menu', 'GetData_hosting');
function GetData_hosting(){
add_menu_page('Options Comparahosting', 'Options Comparahosting', 'manage_options', 'hostingData_script', 'hostingData_script');
}
/// ADMIN GET DATA
    // ADMIN DATA GETLANG
     include "dashboard.php";

?>