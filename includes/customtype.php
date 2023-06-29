<?php
add_action('init', 'create_reading_post_type' );
add_action('init', 'create_toolbox_taxonomies' ); 

     
	
	function create_reading_post_type() {
	  $labels = array(
	    'name'               => 'Reading',
	    'singular_name'      => 'Readings',
	    'menu_name'          => 'Readings',
	    'name_admin_bar'     => 'Readings',
	    'add_new'            => 'Add New',
	    'add_new_item'       => 'Add New Readings',
	    'new_item'           => 'New Readings',
	    'edit_item'          => 'Edit Reading',
	    'view_item'          => 'View Reading',
	    'all_items'          => 'All Readings',
	    'search_items'       => 'Search Readings',
	    'parent_item_colon'  => 'Parent Reading',
	    'not_found'          => 'No Reading Found',
	    'not_found_in_trash' => 'No Reading Found in Trash'
	  );

	  $args = array(
	    'labels'              => $labels,
	    'show_in_rest' => true,
	    'public'              => true,
	    'exclude_from_search' => false,
	    'publicly_queryable'  => true,
	    'show_ui'             => true,
	    'show_in_nav_menus'   => true,
	    'show_in_menu'        => true,
	    'show_in_admin_bar'   => true,
	    'menu_position'       => 22,
	    'menu_icon'           => 'dashicons-admin-appearance',
	    'capability_type'     => 'post',
	    'hierarchical'        => true,
	    'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'page-attributes' ),
	    'has_archive'         => true,
	    'rewrite'             => array( 'slug' => 'reading' ),
	    'query_var'           => true
	  );

	  register_post_type( 'reading', $args );
	}




	function create_toolbox_taxonomies() {

		$labels = array(
			'name'              => 'Categories',
			'singular_name'     => 'Category',
			'search_items'      => 'Search Categories',
			'all_items'         => 'All Categories',
			'parent_item'       => 'Parent Layer',
			'parent_item_colon' => 'Parent Layer:',
			'edit_item'         => 'Edit Layer',
			'update_item'       => 'Update Layer',
			'add_new_item'      => 'Add New Layer',
			'new_item_name'     => 'New Layer Name',
			'menu_name'         => 'Categories',
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'reading_cat' ),
		);

		register_taxonomy('reading_cat', array('reading'), $args);
		
		
		
		
		
		
		
		$labels = array(
			'name'              => 'Tags',
			'singular_name'     => 'Tag',
			'search_items'      => 'Search Tags',
			'all_items'         => 'All Tags',
			'parent_item'       => 'Parent Tag',
			'parent_item_colon' => 'Parent Tag:',
			'edit_item'         => 'Edit Tag',
			'update_item'       => 'Update Tag',
			'add_new_item'      => 'Add New Tag',
			'new_item_name'     => 'New Tag Name',
			'menu_name'         => 'Tags',
		);

		$args = array(
			'hierarchical'      => false,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'reading_tag' ),
		);

		register_taxonomy('reading_tag', array('reading'), $args);	
	}
	
