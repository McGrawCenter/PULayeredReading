<?php

// Creating the widget 
class contextos_widget extends WP_Widget {

 
	// The construct part  
	function __construct() {
	    parent::__construct('contextos_widget', __('Reading Widget', 'contextos_widget_domain'), 
		array( 'description' => __( 'A widget that lists the reading layers', 'contextos_widget_domain' ), ) 
		);
	}
	  
	// Creating widget front-end
	public function widget( $args, $instance ) {
	    $title = apply_filters( 'widget_title', $instance['title'] );
		 
	    echo $args['before_widget'];
	    if ( ! empty( $title ) )
	    echo $args['before_title'] . $title . $args['after_title'];
	    echo __( 'This will be a list', 'contextos_widget_domain' );
	    echo $args['after_widget'];
	}
		  
 
// Class wpb_widget ends here
} 


function contextos_load_widget() {

    register_widget( 'contextos_widget' );
}

die('the widget');
add_action( 'widgets_init', 'contextos_load_widget' );
