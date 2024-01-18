<?php



/************************** ADD BUTTON TO TINYMCE *******************************/


class EatMe {

// https://www.gavick.com/blog/wordpress-tinymce-custom-buttons

	function __construct() {
	    add_filter("mce_external_plugins", array( $this, "layeredreading_add_tinymce_plugin") );
	    add_filter('mce_buttons', array( $this, 'layeredreading_register_my_tc_button') );
	    add_action('admin_head', array( $this, 'layeredreading_add_my_tc_button') );
	}


	function layeredreading_add_tinymce_plugin($plugin_array) {
	    $plugin_array['layeredreading_tc_button'] = plugins_url( '../js/editor.js', __FILE__ );
	    return $plugin_array;
	}




	function layeredreading_register_my_tc_button($buttons) {
	   array_push($buttons, "highlighter");
	   return $buttons;
	}



	function layeredreading_add_my_tc_button() {
	    global $typenow;
	    // check user permissions
	    if ( !current_user_can('edit_posts') && !current_user_can('edit_pages') ) {
	    return;
	    }


	}



}

new EatMe();
