/* Translate */			
var translate = new Array();
translate['TitleSwitrans'] = 'Switrans2 :: MCT SAS';

/* Preloader */
var hidePreloader = function(){
	var hide = function(){
		dojo.fadeOut({
				node:"preloader",
				duration:700,
				onEnd: function(){								
					dojo.style("preloader", "display", "none");	
				}
		}).play();
	};
	// Set a timeout to ensure the preloader is visible.
	setTimeout(hide, 5000);
}; 

function showPreloader() {
	var ps = dojo.position('preloaderContent');
	var ws = dojo.window.getBox();
	dojo.style("preloaderContent", "top" , (ws.h/2-ps.h/2)+"px");
	dojo.style("preloaderContent", "left", (ws.w/2-ps.w/2)+"px");
	dojo.style("preloaderContent", "visibility" , "visible");
};
	
/* TabContainer */			
function openTab(idTab, titleTab, urlTab)
{
	var tabContainer = dijit.byId("workSpace");
  	if(dijit.byId(idTab))
    {       
    	 tabContainer.selectChild(dijit.byId(idTab));     
	}else{ 
		var pane = new dijit.layout.ContentPane({ 
			id: idTab,
			title: titleTab,
			href: urlTab, 
			closable: true,
			/* onClose: function(){ // confirm() returns true or false, so return that. 
				return confirm("Do you really want to Close this?"); 
			} */
	    });    
		tabContainer.addChild(pane);
		tabContainer.selectChild(pane);
	}
}

function isNumeric(num){
   return (parseFloat(num) - 0) == num && num.length > 0;
}

