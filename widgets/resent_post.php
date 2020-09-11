<?php 
 class recent_post_widget extends WP_Widget {
   
 function __construct() {
 parent::__construct(
   
 // Base ID of your widget
 'recent_post_widget', 
   
 // Widget name will appear in UI
 __('RecentPostCPH Widget', 'recent_post_widget_domain'), 
   
 // Widget description
 array( 'description' => __( 'Sample widget based on WPBeginner Tutorial', 'recent_post_widget_domain' ), ) 
 );
 }
   
 // Creating widget front-end
   
 public function widget( $args, $instance ) {
 $cantidad_post = apply_filters( 'widget_cantidad_post', $instance['cantidad_post'] );
 $cantidad_post = $cantidad_post + 1;
 $the_query = new WP_Query( 'posts_per_page='.$cantidad_post );
 $header = '<div class="recent-posts--widget"><ul class="nav">';
 $footer = '</ul></div>';
 $title = '<h4 class="h4_title">Publicaciones Recientes</h4>';
 $content_post= "";
 $id = get_the_ID();
 $count = 0;
     while ($the_query->have_posts()) : $the_query->the_post(); 
     if($id != get_the_ID()){
     switch ($count) {
         case 0:
            $content_post = $content_post.'
         <li>
         <a href="'.get_the_permalink().'" class="a-recent">'.get_the_post_thumbnail(get_the_ID(), 'full' ).'</a>				
         <div class="content recent_content">
             <p class="recent_p">por <a href="'.esc_url( get_author_posts_url( get_the_author_meta('ID') ) ).'" class="recent_p">'.get_the_author().'</a>   / '.esc_html( get_the_date()).'</p>
             <h3 class="h6 "><a href="'.get_the_permalink().'" class="recent_color inline_two">'.get_the_title().'</a></h3>
         </div>
        </li>
        ';
        break;
         
         default:
         $content_post = $content_post.'
         <li>
         <a href="'.get_the_permalink().'" class="img">'.get_the_post_thumbnail(get_the_ID(), 'thumbnail' ).'</a>				
         <div class="content">
             <p class="recent_p" >por <a href="'.esc_url( get_author_posts_url( get_the_author_meta('ID') ) ).'" class="recent_p">'.get_the_author().'</a>   / '.esc_html( get_the_date()).'</p>
             <h3 class="h6 "><a href="'.get_the_permalink().'" class="recent_color inline_two">'.get_the_title().'</a></h3>
         </div>
        </li>
        ';
        break;
     }

    $count++;
    }
    endwhile;

    echo $header.$title.$content_post."<li></li>".$footer;
    wp_reset_postdata();
 }
           
 // Widget Backend 
 public function form( $instance ) {
 if ( isset( $instance[ 'cantidad_post' ] ) ) {
 $cantidad_post = $instance[ 'cantidad_post' ];
 }
 else {
 $cantidad_post = __( '3', 'recent_post_widget_domain' );
 }
 // Widget admin form
 ?>
 <p>
 <label for="<?php echo $this->get_field_id( 'cantidad_post' ); ?>"><?php _e( 'Catidad :' ); ?></label> 
 <input class="widefat" id="<?php echo $this->get_field_id( 'cantidad_post' ); ?>" name="<?php echo $this->get_field_name( 'cantidad_post' ); ?>" type="text" value="<?php echo esc_attr( $cantidad_post ); ?>" />
 </p>
 <?php 
 }
       
 // Updating widget replacing old instances with new
 public function update( $new_instance, $old_instance ) {
 $instance = array();
 $instance['cantidad_post'] = ( ! empty( $new_instance['cantidad_post'] ) ) ? strip_tags( $new_instance['cantidad_post'] ) : '';
 return $instance;
 }
  
 // Class recent_post_widget ends here
 } 
  
  
 // Register and load the widget
 function wpb_load_widget() {
     register_widget( 'recent_post_widget' );
 }
 add_action( 'widgets_init', 'wpb_load_widget' );

?>