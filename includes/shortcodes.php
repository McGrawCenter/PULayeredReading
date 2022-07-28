<?php

/**************** shortcodes ***************/

function layered_readings_menu( $atts ){

	$args = array(
	    'taxonomy' => 'reading_cat',
	    'hide_empty' => false,
	);

	$terms = get_terms( $args );
	
	$html = "<ul id='readings-gallery'>";

	foreach($terms as $term) {
	
		$term_name = $term->name;

		$html .= "<li><h3>{$term_name}</h3>";
		
		$args2 = array(
		    'numberposts' => -1,
		    'post_type'   => 'reading',
		    'tax_query' => array(
			array(
			  'taxonomy' => 'reading_cat',
			  'field' => 'term_id', 
			  'terms' => $term->term_id,
			  'include_children' => false
			)
		     )
		);
		
		if($readings = get_posts( $args2 )) {
		 $html .= "<ul>";
		 foreach($readings as $reading) {
		  $permalink = get_permalink($reading->ID);
		  $thumbnail = get_the_post_thumbnail_url( $reading->ID, 'full' );
		  $html .= " <li><a href='{$permalink}'>{$reading->post_title}</a></li>";
		 }
		 $html .= "</ul>";
		}
		
		
		
		
		$html .= "</li>";		
	
	}
	$html .= "</ul>";
	return $html;
}
add_shortcode( 'readings-menu', 'layered_readings_menu' );
