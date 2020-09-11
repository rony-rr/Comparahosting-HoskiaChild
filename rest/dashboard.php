 <?php 
function hostingData_script(){
    /// PROCESS POST
    include "inc/method_post.php";
    // Vista HTML
    include "view/dashboard_view.php";

var_dump(json_encode(get_option('catalogos_hosting_data')));
// var_dump( get_stylesheet_directory_uri() );
}
?>