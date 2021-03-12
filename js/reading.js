
jQuery( document ).ready(function() {

  jQuery('body').append("<div id='flyout' class='hidden'><div id='flyout-head'><a href='#' class='flyout-close'>&times;</a></div><div id='flyout-content'></div></div>");





	  /************************
	  * turn on a layer
	  ************************/

	  jQuery(document).on('click','.togglelayer',function(e){
	  
	    //jQuery("#flyout").switchClass("shown","hidden");
	    
	    var rel = jQuery(this).attr('rel');
	    jQuery('span').removeClass('active');
	    jQuery('.'+rel).addClass('active');
	    /*
	    var layerclass = jQuery(this).attr('rel');

	    jQuery("span").removeClass("active");
	    jQuery("a").removeClass("active");
	    jQuery(".togglelayer img").removeClass("active");
	    jQuery('.'+layerclass).toggleClass('active');

	    activelayer = layerclass;
	    jQuery("#flyout").addClass(activelayer);
	    */
	    e.preventDefault();
	  });
	  
	  
	/****************************
	* populate a flyout with a post content
	*****************************/

	function getContextosPost(postid) {
	  
	    var url = contextosvars.rest+"wp/v2/posts/"+postid;
	    jQuery('#flyout-content').empty();
	    jQuery.get(url, function(data){
	      jQuery('#flyout-content').append('<h2>'+data.title.rendered+'</h2>');
	      jQuery('#flyout-content').append(data.content.rendered);
	    })
	    
	}	  



	/****************************
	* click on an active layer
	*****************************/
	
	jQuery(document).on('click','.layer.active',function(e){
	
	    var postid = jQuery(this).attr('data-post');
	    getContextosPost(postid);
	    
	    jQuery('#flyout').removeClass();
	    jQuery('#flyout').addClass('hidden');
	    
	    var type = jQuery(this).attr('data-type');
	    jQuery('#flyout').addClass(type);
	
	    if(jQuery('#flyout').hasClass('hidden')) {
	      jQuery('#flyout').switchClass('hidden','shown', 200, "easeInOutQuad");
	    }
	    e.preventDefault();
	});







	/****************************
	* close the flyout
	*****************************/
	
	  jQuery(document).on('click','.flyout-close',function(e) {
	    jQuery('#flyout').switchClass('shown','hidden', 200, "easeInOutQuad");
	    e.preventDefault();
	  });
	  
	  
	  


});	







