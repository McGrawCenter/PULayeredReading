(function() {
console.log('editor');


    tinymce.PluginManager.add('linguaviva_tc_button', function( editor, url ) {



        editor.addButton( 'highlight1', {
            text: 'Structure',
	    tooltip : 'Insert structural highlight',
            icon: false,
            onclick: function() {
			selection = tinyMCE.activeEditor.selection.getContent();
			editor.insertContent("<span class='structure layer'>"+selection+"</span>");
            }
        });
        
        editor.addButton( 'highlight2', {
            text: 'Function',
	    tooltip : 'Insert functional highlight',
            icon: false,
            onclick: function() {
			selection = tinyMCE.activeEditor.selection.getContent();
			editor.insertContent("<span class='function layer'>"+selection+"</span>");
            }
        });
        
        editor.addButton( 'highlight3', {
            text: 'Grammar',
	    tooltip : 'Insert grammar highlight',
            icon: false,
            onclick: function() {
			selection = tinyMCE.activeEditor.selection.getContent();
			editor.insertContent("<span class='grammar layer'>"+selection+"</span>");
            }
        });  
        
        
        editor.addButton('gloss', {
            icon: false,
            text: 'SLANG',
            onclick : function(e) {
                    editor.windowManager.open({
                    	 title: 'Add functional highlight',
                        file: ajaxurl + '?action=fp_plugin_function',
                        width : 400 + parseInt(editor.getLang('highlight.delta_width', 0)),
                        height : 400 + parseInt(editor.getLang('highlight.delta_height', 0))
                        });
                    var content = editor.selection.getContent({format : 'html'});
                        editor.execCommand('mceInsertContent', false, content);
                
            
            }
        });     
        
        
        /*        
        editor.addButton('gloss', {
            icon: false,
            text: 'THE_TEXT_OF_THE_BUTTON',
            onclick: function (e) {
                editor.windowManager.open( {
                    title: 'ADD SLANG',
                    body: [{
                        type: 'textbox',
                        name: 'title',
                        placeholder: 'PLACE_HOLDER_TEXT',
                        multiline: true,
                        minWidth: 700,
                        minHeight: 50,
                    },
                    {
                        type: 'button',
                        name: 'link',
                        text: 'Insert/Edit link',
                        onclick: function( e ) {
                            //get the Wordpess' "Insert/edit link" popup window.
                            var textareaId = jQuery('.mce-custom-textarea').attr('id');
                            wpActiveEditor = true; //we need to override this var as the link dialogue is expecting an actual wp_editor instance
                            wpLink.open( textareaId ); //open the link popup
                            return false;
                        },
                    }],
                    onsubmit: function( e ) {
			selection = tinyMCE.activeEditor.selection.getContent();
			editor.insertContent("<span class='slang layer'>"+selection+"</span>");e
                       //editor.insertContent( '<div class="CLASS_NAME">' + e.data.title + '</div>');
                    }
                });
            }
        });        

        

        editor.addButton( 'gloss', {
            text: 'Gloss',
	    tooltip : 'Insert Gloss',
            icon: false,
            onclick: function() {
			selection = tinyMCE.activeEditor.selection.getContent();

			editor.windowManager.open( {
			      title: 'Gloss '+selection,
			      body: [
{
				type: 'container',
				name: 'container',
				label: 'container',
				html: 'Enter a translation or other gloss for <i>'+selection+'</i>.<br />You may also enter the full URL of an image on the web.'
			      },
			      {
				type: 'textbox',
				name: 'gloss',
				label: 'Message'
			      }],
			      onsubmit: function( e ) {
				editor.insertContent( "[gloss message=\""+e.data.gloss+"\"]"+selection+"[/gloss]" );
			      }



			    });

            }
        });
        
        */
        
        
        


    });



})();
