<?php

/**************** shortcodes ***************/

function categorized_layered_readings_menu( $atts ){

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
add_shortcode( 'categorized_readings-menu', 'categorized-layered_readings_menu' );


function readings_menu( $atts ){

	$args = array(
	    'numberposts' => -1,
	    'post_type'   => 'reading'
	);
	
	if(isset($atts['title'])) { $title = $atts['title']; }
	else { $title = "Readings" }

	if($readings = get_posts( $args )) {
	 $html = "<div class='readings-menu'>"
	 if($title != "") { $html .= "<h3>{$title}</h3>"; }
	 $html .= "<ul id='layered-readings-menu'>";
	 foreach($readings as $reading) {
	  $permalink = get_permalink($reading->ID);
	  $thumbnail = get_the_post_thumbnail_url( $reading->ID, 'full' );
	  $html .= " <li><a href='{$permalink}'>{$reading->post_title}</a></li>";
	 }
	 $html .= "</ul></div>";
	}

	return $html;
}
add_shortcode( 'readings-menu', 'readings_menu' );
