<?php



/************** WIDGET CLASS **********************/


// Creating the widget 
class Contextos_Widget extends WP_Widget {
  
	function __construct() {
	     parent::__construct('contextos_widget', __('Layers', 'contextos_widget_domain'), 
	  
	// Widget description
	array( 'description' => __( 'Add a menu of reading layers' ), ) 
	);
	}
  
	// Creating widget front-end
	  
	public function widget( $args, $instance ) {
	
		if(get_post_type() == 'reading') { 
			$title = apply_filters( 'widget_title', $instance['title'] );
			echo $args['before_widget'];
			if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];
			
			echo "<ul>";

			if($names = get_option('contextos_layername')) {
			foreach($names as $name) {
			    if($name != "") {
			        $nameslug = strtolower(str_replace(" ","_",$name));
				echo "<li><a href='#' class='togglelayer' rel='{$nameslug}'>{$name}</a></li>";
			      } 
			    }
			}
			
			echo "</ul>";
			echo $args['after_widget'];
		}
	}
          
	// Widget Backend 
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
		$title = $instance[ 'title' ];
		}
		else {
		$title = __( 'New title', 'contextos_widget_domain' );
		}
		// Widget admin form
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php 
	}
      
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
	 
// Class Contextos_widget ends here
} 




/************** REGISTER THE WIDGET **********************/
function Contextos_Widget() {
	register_widget( 'Contextos_Widget' );
}
add_action( 'widgets_init', 'Contextos_Widget' );
