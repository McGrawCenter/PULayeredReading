

// data we are passing to the editor: layers and posts
jQuery.get(ajaxurl + '?action=contextos_get_posts', function(data){ 
   tinyMCE.activeEditor.settings.myKeyValueList = data;
});
			



(function() {

    tinymce.PluginManager.add('linguaviva_tc_button', function( editor, url ) {

	function getValues(part) {
	   if(part=='layers') { return editor.settings.myKeyValueList.layers;  }
	   else { return editor.settings.myKeyValueList.posts;  }
	}


 
        editor.addButton( 'highlighter', {
            text: 'Highlighter',
	    tooltip : 'Insert highlight',
            icon: false,
            onclick: function() {
            
            		console.log(tinyMCE.activeEditor.selection);
            
            
			selection = tinyMCE.activeEditor.selection.getContent();

			var x = editor.windowManager.open( {
			      title: 'Gloss',
			      body: [
			      {
				type: 'container',
				name: 'container',
				label: 'container',
				html: 'Select the type of highlight and a post to link to.'
			      },
			      {
				type   : 'listbox',
				name   : 'type',
				label  : 'Layer',
				values : getValues('layers'),
				minWidth: 350
				},		      			      
			       {
				type   : 'listbox',
				name   : 'post_id',
				label  : 'Post',
				values : getValues(),
				minWidth: 350
				}], 
				
			      onsubmit: function( e ) {
				editor.insertContent( "<span class='"+e.data.type+" layer' data-post='"+e.data.post_id+"' data-type='"+e.data.type+"'>"+selection+"</span>" );
			      }
			    });
			
            }
        });

    });

})();
