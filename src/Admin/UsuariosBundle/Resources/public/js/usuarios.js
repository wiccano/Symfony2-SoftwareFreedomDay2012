/*
 * Usuarios.js
 */
function addUsuario() 
{ 
	if (formAddUsuario.validate())
	{
		var resultDialog = new dijit.Dialog({title: "Switrans2 :: MCT SAS", style : "width: 450px"});
		var xhrArgs =
		{ 
			url: Routing.generate('AdminUsuarios_addUsuario'),
	        form: dojo.byId("formAddUsuario"),
	        handleAs: "text", 
	        load: function(data)
	        { 
		      	data = data.replace(/^\s*|\s*$/g,"");
	      		if(data == 'OK'){      			
	      			formAddUsuario.reset();
	      			reloadDataGrid('AdminUsuarios_pageGridUsuarios', 'gridUsuarios');
	      			resultDialog.set("content",translate['usuario_creado']);
					resultDialog.show();
				}else{
		      		resultDialog.set("content",data);
					resultDialog.show();	
		      	}	
			},
		    error:  function(error){
				resultDialog.set("content",error);
				resultDialog.show();
			}
		}
		dojo.xhrPost(xhrArgs);
	}
}