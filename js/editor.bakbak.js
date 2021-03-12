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
			selection = tinyMCE.activeEditor.selection.getContent();

			var x = editor.windowManager.open( {
			      title: 'Gloss '+selection,
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
				label  : 'Type',
				values : getValues('layers'),
				minWidth: 350,
				onselect: function( e ) {
				  listbox = x.find('#post_id');
				  formItem = listbox.parent();
				  listbox.remove();
				  formItem.append({
				    label: 'Post',
				    type: 'listbox',
				    name: 'post_id',
				    values: getValues(e.target.settings.value)
				  });
				  }
				},		      			      
			       {
				type   : 'listbox',
				name   : 'post_id',
				label  : 'Post',
				values : getValues(),
				minWidth: 350
				}], 
				
			      onsubmit: function( e ) {
			      console.log(e.data);
				editor.insertContent( "<span class='"+e.data.type+" layer' data-post='"+e.data.post_id+"'>"+selection+"</span>" );
			      }
			    });
			
            }
        });

    });

})();
