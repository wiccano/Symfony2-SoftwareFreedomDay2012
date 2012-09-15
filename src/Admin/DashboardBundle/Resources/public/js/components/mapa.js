function mapGenerate(params)
{
	var map = 
	{		
   		show: function (params) 
		{			
			map.id = params.id;
			map.url = params.url;
			map.type = params.type; 
			map.showcrumbs = params.showcrumbs;
			map.showcombopoints = params.showcombopoints;
			map.headerinpopup = params.headerinpopup;
			map.showreloadedbutton = params.showreloadedbutton;
			map.reloaded = params.reloaded;
			map.miliseconds = params.miliseconds;
			
			map.center = new google.maps.LatLng(parseFloat(4.609719798584),parseFloat(-74.081753110352));
			map.zoom = 6;
			map.clickable = false;
				
			map.oForm = $("#Form_"+map.id);
			map.oMap = $("#mapa_"+map.id);	
			map.oLoader = $("#loader_"+map.id);	

			// Button reload 
			if(map.showreloadedbutton == 1)
			{
				$("#reload_"+map.id).button({icons: { primary: "ui-icon-refresh"}}).click(function() 
				{	
					map.showloader();					
					map.callback();					
				});
			}
			
			// Button automatic reload 
			if(map.reloaded == 1)
			{
				$("#pause_"+map.id).button({ label: "Reanudar", icons: { primary: "ui-icon-play"}});				
				var reload = function () {
					if(!$("#Form_"+map.id+"_pause")){
							timer.stop();
					}else{
						if($("#Form_"+map.id+"_pause").val() == 1){											
							map.showloader();					
							map.callback();	
						}
					}
				};
				var timer = $.timer(reload , map.miliseconds , true);	
			
				$("#pause_"+map.id).click(function() {
					if($("#Form_"+map.id+"_pause").val() == 1){
						$("#Form_"+map.id+"_pause").val("0");	
						$("#pause_"+map.id).button({ label: "Reanudar", icons: { primary: "ui-icon-play" } });
						
					}else{
						$("#Form_"+map.id+"_pause").val("1");
						$("#pause_"+map.id).button({ label: "Pausar", icons: { primary: "ui-icon-pause" } });
					}
				});
			}
			
			// Button info
			if(map.headerinpopup == 1)
			{
				$("#header_"+map.id).button({icons: { primary: "ui-icon-comment", secondary: "ui-icon-triangle-1-s" }}).click(function() 
				{	
					$("#map_info_"+map.id).toggle();					
				});		
			}
			
			// Create loader
			map.oLoader.width($('#content_'+map.id).width());
			map.oLoader.height($('#content_'+map.id).height());
			map.showloader();
			
			// Show map
			map.oMap.gmap({ 	
				'center': map.center,
				'zoom': map.zoom, 
				'mapTypeId': google.maps.MapTypeId.HYBRID,
				'callback': map.callback() 
			});
		}, 
					
		callback: function () 
		{
			if(map.url != "")
			{
				$.ajax({
			        type: 'POST',
			        dataType:"json",
			        url: Routing.generate(map.url),
			        data: map.oForm.serialize(),
			        success: function(data)
			        { 
			        	if(data.error){
	 						map.hideloader();
	 						alert(data.error);
		 				}else{				
							switch (map.type)
							{
							  case 'R': map.drawroutes(data); break;
							  case 'P': map.drawpoints(data); break;
							  default:  alert("Tipo de mapa sin identificar. Por favor comuniquese con los administradores del sistema");
							}
						}	
			        }
		        });					
			}else{
				map.hideloader();
			}
		},
        
        drawpoints: function(data) 
		{ 
			map.oMap.gmap('clear', 'markers');
			var options = "";
			$.each( data.items, function(i, marker) 
			{							
				var position = new google.maps.LatLng(marker.latitud, marker.longitud);
				map.markerCentral(map.id +'_'+i, position, marker.labelpoint, marker.title, marker.icon);	
				if(map.showcombopoints == 1){
					options += '<option value="' + i + '">' + marker.documento + '</option> ';
				}		
			});
			if(map.showcombopoints == 1){
				map.drawFilterPoints(options);
			}	
			map.hideloader();
		},
		
		drawFilterPoints: function(options) 
		{ 
			options += '<option value="" Selected ="Selected">Seleccione Operaci&oacute;n</option> ';	
			var htmlSelect ='<select name="combo_points_' + map.id + '" id="combo_points_' + map.id + '" style="width: 200px;"> ' + options +	'</select>';
											
			$("#divcombo_points_"+map.id).html(htmlSelect).find("select").selectmenu({
				style:'dropdown', 
				menuWidth: 400,
				select: function(event, options) {
					map.oMap.gmap('find', 'markers', { 'property': 'id', 'value': map.id+"_"+options.value }, function(markerAux, found) {
						markerAux.set('animation', 0);
						if( map.id + "_" + options.value == markerAux.id ){
							markerAux.set('animation', google.maps.Animation.BOUNCE);
							map.oMap.gmap('openInfoWindow', { content : markerAux.content }, markerAux);
							
							/*var infoW = new google.maps.InfoWindow({});
      						infoW.setContent(markerAux.content);
							google.maps.event.addListener(infoW,'closeclick', function() {
								markerAux.set('animation', 0);
							});
							infoW.open(map.oMap, markerAux);*/
						}
			        });
				}
			});
		},
		
		drawroutes: function(data) 
		{ 
			var routes = map.routes(data);			
			$("#map_canvas").gmap('clear', 'overlays > Polyline');
			$.each( routes.routes, function(i, road) 
			{									
				var property = map.properties(i);
				map.oMap.gmap('addShape', 'Polyline', {
					'path': road, 
					'strokeColor': property.color, 
					'strokeWeight': property.strokeWeight, 
					'clickable': map.clickable	
				});
			});				
			
			map.oMap.gmap('clear', 'markers');		
			$.each( routes.pointsLayer, function(i, obj) 
			{
				switch (obj.type){
					case 'Numeric': 	var icon = 'http://gmaps-samples.googlecode.com/svn/trunk/markers/green/marker' + obj.label + '.png';
										var title = '';
										break;
					default:  	  		var icon = ''; 
										var title = '';
				}	
				
				if(obj.type == 'Central'){
		       		var property = map.properties(i);
		       		map.markerCentral(map.id +'_'+i, obj.position, obj.label, title, property.icon);
		       	}else{
		       		map.marker(obj.position, title, icon);
		       	}		       					
			});		       	
			map.hideloader();
		}, 
		
		routes: function(data)
		{		
			var routes = [];
			var pointsLayer = [];
						
			map.oMap.gmap('option', 'zoom', map.center);
			map.oMap.gmap('option', 'zoom', map.zoom);			
			
			$.each( data.items, function(i, dataRoute) 
			{													
				var route = [];
				var points = 0;
				var pointLayerCentral = '';
				$.each( dataRoute, function(im, marker) 
				{
					if(map.isnumeric(marker.latitud) && map.isnumeric(marker.longitud)){
						if(points == 0){					
							pointLayerCentral = { 
								position: new google.maps.LatLng(marker.latitud, marker.longitud),
								label: marker.labelpoint, 
								type: 'Central'
							};												
							map.oMap.gmap('option', 'center', new google.maps.LatLng(marker.latitud, marker.longitud));
							map.oMap.gmap('option', 'zoom', 6);
						}
						if(map.showcrumbs == 1){ 
							if(marker.crumb > 0){
								var pointLayer = { 
									position: new google.maps.LatLng(marker.latitud, marker.longitud),
									label: marker.crumb, 
									type: 'Numeric'
								};		
								pointsLayer.push(pointLayer);
							}
						}
						var point = new google.maps.LatLng(marker.latitud, marker.longitud);
						route.push(point); 
						points++;	
					}
				});
				routes.push(route);
				if(pointLayerCentral){
					pointsLayer.push(pointLayerCentral);
				}
			});
			
			var result = {
				routes: routes,
				pointsLayer: pointsLayer
			}
			return result;		
		},	
		
		marker: function (position, title, icon) 
		{
			map.oMap.gmap('addMarker', { 
			    	'position': position,
			    	'title': title, 
			    	'icon': icon,
			    	'cursor': 'default'						
			});	    
		},
		
		markerCentral: function(id, position, content, title, icon)
		{
			map.oMap.gmap('addMarker', { 
			    	'id': id,
			    	'position': position,
			    	'title': title, 
			    	'icon': icon,
			    	'cursor': 'default',
			    	'content': content,
			    	'animation': google.maps.Animation.DROP
			}).click(
				function() 
				{							
					map.oMap.gmap('openInfoWindow', { content : content }, this);
				}
			);	
			
			// 	google.maps.event.addListener(marker, 'dblclick', function(){
			//	if(map.getZoom() == 12){
			//			map.setZoom(6);
			//			map.setCenter(new google.maps.LatLng(parseFloat(4.609719798584),parseFloat(-74.081753110352)));
			//			map.setMapTypeId(google.maps.MapTypeId.HYBRID);
			//		}else{
			//			map.setZoom(12);
			//	    	map.setCenter(marker.getPosition());	
			//	    	map.setMapTypeId(google.maps.MapTypeId.ROADMAP);
			//	    	var popup = new google.maps.InfoWindow();
			//        	popup.setContent(content);
			//        	popup.open(map, this);
			//		}	    
			//	});
				
		},
			
		showloader: function()
		{
			jQuery(map.oLoader).show();	
		},

		hideloader: function()
		{
			jQuery(map.oLoader).hide();	
		},
		
		properties: function(numruta)
		{			
			var properties = new Array(); 		
			properties[0] = { color: '#FF0000', strokeWeight: 6, icon: '' };
			properties[1] = { color: '#0000A0', strokeWeight: 5, icon: 'http://gmaps-samples.googlecode.com/svn/trunk/markers/blue/blank.png' };
			properties[2] = { color: '#FFB914', strokeWeight: 4, icon: 'http://gmaps-samples.googlecode.com/svn/trunk/markers/orange/blank.png' };
			if(numruta > properties.length){
				map.hideloader();
				alert("No se han definido propiedades ruta"+ numruta +" .Por favor comuniquese con los administradores del sistema");
				return;		
			}
			return properties[numruta];
		},
				
		isnumeric: function(num)
		{
			return (parseFloat(num) - 0) == num && num.length > 0;				
		}			
	}
	map.show(params);	
}
