<?php
/*
Plugin Name: PU Layered Reading Platform
Description: A platform for layered annotation of readings
Version: 2.0
License: GPL2
*/
   
require_once( 'includes/customtype.php');
require_once( 'includes/shortcodes.php');
require_once( 'includes/widget.php');
require_once( 'includes/editor.php');
 
   
class PULayeredReading {


	  function __construct() {
	     add_filter('tiny_mce_before_init', array( $this, 'tags_tinymce_fix') );
	     
	     
	     add_action( 'wp_enqueue_scripts', 	array( $this,'pulr_add_scripts') );
	     add_action( 'admin_enqueue_scripts', 	array ($this,'pulr_admin_add_scripts') );
	     
	     add_action('wp_ajax_pulr_get_posts', array($this, 'pulr_ajax_list_posts') );
	     add_action( 'admin_menu', array( $this, 'add_settings_page') ); 
	     add_action( 'admin_init', array( $this, 'register_settings') );
	     
	     
	     
	     // this generates a css page that contains the colors for the layers
	     add_action( 'init', array( $this, 'generate_css')  );
	     
	  }
	  
	  
	  

	/*****************************
	* Add css and js
	*****************************/
	function pulr_add_scripts() {
	
	    if(get_post_type() == 'reading') { 
	     wp_enqueue_script( 'jquery-effects-core');
	     
	     wp_enqueue_script( 'reading_js', plugins_url( '/js/reading.js', __FILE__ ), array('jquery'));
	     $data = array('rest'=> rest_url());
	     wp_localize_script( 'reading_js', 'contextosvars', $data );
	     }
	    
	    wp_register_style('pulr-css', plugins_url('css/style.css',__FILE__ ));
	    wp_enqueue_style('pulr-css');
	    
	    wp_register_style('pulr-layer-css', site_url('?pulr_layers_css',__FILE__ ));
	    wp_enqueue_style('pulr-layer-css');	    
	    	    
	    wp_enqueue_style('dashicons');
	}





 
	function generate_css() {
	     if( isset( $_GET['pulr_layers_css'] ) ) {
	     
	     	$hexes = get_option('pulr_layerhex');
		$names = get_option('pulr_layername');
		
		header("Content-Type: text/css");
		foreach($names as $index=>$name) {
		  if($name != "") {
		    list($r, $g, $b) = sscanf($hexes[$index], "#%02x%02x%02x");
		    // background colors in editor
		    echo "#tinymce .".strtolower(str_replace(" ","_",$name))." { background: rgba(".$r.",".$g.",".$b.",0.7); }\n";
		    // background colors on page when active
		    echo ".active.".strtolower(str_replace(" ","_",$name))." { background: rgba(".$r.",".$g.",".$b.",0.7); }\n";
		    // background colors of the flyout
		    echo "#flyout.".strtolower(str_replace(" ","_",$name))." { background: ".$hexes[$index]."; }\n";
		  }
		}
			
	       die();
	     }
	}



	/*****************************
	* Add css for Dashboard pages
	*****************************/
	function pulr_admin_add_scripts() {
	    add_editor_style(site_url().'/?pulr_layers_css');
	    wp_enqueue_script( 'layers-settings-js', plugin_dir_url( __FILE__ ) . '/js/settings.js', array(), '1.0' );
	}




	/*********************************
	* ajax - get data to populate the popup widget in the editor
	*********************************/
	function pulr_ajax_list_posts() {
	
	    $returnObj = array('layers' => array(), 'posts'=> array());
	
	    if($names = get_option('pulr_layername')) {
	       
	    foreach($names as $name) {
	        if($name != "") {
	            $nameslug = strtolower(str_replace(" ","_",$name));
 		    $o = new StdClass();
	            $o->text = $name;
	            $o->value = $nameslug;
	            $returnObj['layers'][] = $o;
	            } 
	        }
	    }

	        
	    $args = array(
	     'numberposts' => -1,
	     'post_type'=> 'post',
	     'orderby' => 'title',
	     'order' => 'ASC'
	    );
	      
	    if($posts = get_posts($args)) {
	     foreach($posts as $post) {
	        $p = new StdClass();
	        if(strlen($post->post_title) > 48) { $post->post_title = substr($post->post_title,0,48)."...";}
	        $p->text = $post->post_title;
	        $p->value = $post->ID;
	      
	        $returnObj['posts'][] = $p;
	      }
	    }
	    header('Content-Type: application/json');
	    echo json_encode($returnObj);          
	    wp_die();
	    die();


	}
	
	
	
	
	
	/************************************** SETTINGS ****************************************/
	
	
	/*********************************
	* add settings page
	*********************************/
	function add_settings_page() {
	  add_options_page( 'Layers', 'Layers', 'manage_options', 'layers',  array( $this, 'render_settings_page') );
	}
	
	/*********************************
	* the content of the settings page
	*********************************/
	function render_settings_page() {
	
	$hexes = get_option('pulr_layerhex');
	$names = get_option('pulr_layername');
	
	?>
	  <div>
	  <h2>Layers Settings</h2>
	  <form method="post" action="options.php">
	  <?php settings_fields( 'myplugin_options_group' ); ?>
	  <p>Set the color and name for up to 10 layers. These layers will appear in the highlighter tool in the editor. Colors should be hex values, such as #EEEEEE or #EEE.</p>
	  
	  <table>
	   <tr valign="top">
	    <th>Color code / Hex</th>
	    <th></th>
	    <th>Name</th>
	  </tr>
	  
	  <?php
	  foreach($hexes as $index=>$hex) {
	  ?>
	  <tr valign="top">
	    <td><input type="text" id="pulr_layerhex_<?php echo $index; ?>" class="layercolorhex" name="pulr_layerhex[]" value="<?php echo $hexes[$index]; ?>" /></td>
	    <td style='width:50px;'><div class='swatch' style='background:<?php echo $hexes[$index]; ?>;height:30px;'></div></td>
	    <td><input type="text" id="pulr_layername_<?php echo $index; ?>" name="pulr_layername[]" value="<?php echo $names[$index]; ?>" /></td>
	  </tr>
	  <?php
	  }
	  
	  ?>

	  </table>
	  <?php  submit_button(); ?>
	  </form>
	  </div>
	<?php

	}

	/*********************************
	* register settings
	*********************************/
	function register_settings() {
	   add_option( 'pulr_layerhex', array('#f9cd88','#92d6af','#8bb1be','','','','','','',''));
	   add_option( 'pulr_layername', array('Function','Grammar','Structure','','','','','','',''));
	   register_setting( 'myplugin_options_group', 'pulr_layerhex', array($this, 'pulr_validate_settings' ) );
	   register_setting( 'myplugin_options_group', 'pulr_layername', array($this, 'pulr_validate_settings' ) );
	}
	
	/*********************************
	* validate
	*********************************/
	function pulr_validate_settings( $input ) {
	    foreach($input as $i) {
	      $i = sanitize_text_field( $i );
	    }
	    return $input;
	}
	
	
	
	/*******************************
	* STOP WORDPRESS REMOVING TAGS
	*******************************/
	function tags_tinymce_fix( $options )
	{
	    if ( ! isset( $options['extended_valid_elements'] ) ) {
		$options['extended_valid_elements'] = 'span[class|data-post|data-type]';
	    } else {
		$options['extended_valid_elements'] .= ',span[class|data-post|data-type]';
	    }
 	    return $options;
	}
	
	
	//<span class="medical layer" data-post="252" data-type="medical">
	

}   
   
new PULayeredReading(); 


