
jQuery( document ).ready(function() {



  jQuery('.layercolorhex').keyup(function(e){
    var x = jQuery(this).val();
    if(x.length == 4 || x.length == 7) { 
      console.log(x);
      jQuery(this).parent().parent().find('.swatch').css('background',x);
    }
    
  });



});	







