/*
 * Datagrid.js
 */
function dg_send(url, grid, form, page, tamano, orderby, orderdirection) 
{
	var oForm = $("#"+form);
	var oGrid = $("#"+grid);
	var oLoader = $("#loader_"+grid);
	
	$('#Form_'+grid+'_page').val(page);
	$('#Form_'+grid+'_tamano').val(tamano);
	$('#Form_'+grid+'_orderby').val(orderby);
	$('#Form_'+grid+'_orderdirection').val(orderdirection); 

	$(oLoader).width($(oGrid).width())
	$(oLoader).height($(oGrid).height())
	jQuery(oLoader).show();
    
    $.ajax({
		type: "POST",
		url: Routing.generate(url),
		data: ($(oForm).serialize()+'&datagrid='+grid),
		success: function(data){
			data = data.replace(/^\s*|\s*$/g,"");
			$(oGrid).html(data);				
		},
		error: function(XMLHttpRequest, textStatus, errorThrown){
			jQuery(oLoader).hide();
			$("#dialog-modal").html("Error: "+XMLHttpRequest.status + ' ' + XMLHttpRequest.statusText);
			$("#dialog-modal").dialog("open");
		}
	});
}

function dg_delitem(urlreload, urldelete, grid, form, deletekey)
{
	if (confirm("¿Está seguro que desea eliminar?")) {
 		var oForm = $("#"+form);
		var oGrid = $("#"+grid);
		var oLoader = $("#loader_"+grid);   	
		
		$('#Form_'+grid+'_deletekey').val(deletekey);
		
		$(oLoader).width($(oGrid).width())
		$(oLoader).height($(oGrid).height())
		jQuery(oLoader).show();
	    
	    $.ajax({
			type: "POST",
			url: Routing.generate(urldelete),
			data: $(oForm).serialize(),
			success: function(data){
				data = data.replace(/^\s*|\s*$/g,"");
				if(data == 'OK'){  
					dg_reload(urlreload, grid, form);
				}else{
					jQuery(oLoader).hide();
					$("#dialog-modal").html(data);
					$("#dialog-modal").dialog("open");
				}			
			},
			error: function(XMLHttpRequest, textStatus, errorThrown){
				jQuery(oLoader).hide();
				$("#dialog-modal").html("Error: "+XMLHttpRequest.status + ' ' + XMLHttpRequest.statusText);
				$("#dialog-modal").dialog("open");
			}
		});
	
  	}
}

function dg_reload(url, grid, form)
{ 
	dg_send(url, grid, form, 
				$('#Form_'+grid+'_page').val(),
				$('#Form_'+grid+'_tamano').val(),
				$('#Form_'+grid+'_orderby').val(),
				$('#Form_'+grid+'_orderdirection').val()
			); 	
}
