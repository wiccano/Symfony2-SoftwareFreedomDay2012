// usage: log('inside coolFunc', this, arguments);
// paulirish.com/2009/log-a-lightweight-wrapper-for-consolelog/
window.log = function f(){ log.history = log.history || []; log.history.push(arguments); if(this.console) { var args = arguments, newarr; args.callee = args.callee.caller; newarr = [].slice.call(args); if (typeof console.log === 'object') log.apply.call(console.log, console, newarr); else console.log.apply(console, newarr);}};

// make it safe to use console.log always
(function(a){function b(){}for(var c="assert,count,debug,dir,dirxml,error,exception,group,groupCollapsed,groupEnd,info,log,markTimeline,profile,profileEnd,time,timeEnd,trace,warn".split(","),d;!!(d=c.pop());){a[d]=a[d]||b;}})
(function(){try{console.log();return window.console;}catch(a){return (window.console={});}}());


// place any jQuery/helper plugins in here, instead of separate, slower script files.
/* ------------------------------------------------------------------------
	s3Slider
	
	Developped By: Boban KariÅ¡ik -> http://www.serie3.info/
        CSS Help: MÃ©szÃ¡ros RÃ³bert -> http://www.perspectived.com/
	Version: 1.0
	
	Copyright: Feel free to redistribute the script/modify it, as
			   long as you leave my infos at the top.
------------------------------------------------------------------------- */

(function($){  

    $.fn.s3Slider = function(vars) {       
        
        var element     = this;
        var timeOut     = (vars.timeOut != undefined) ? vars.timeOut : 6000;
        var current     = null;
        var timeOutFn   = null;
        var faderStat   = true;
        var mOver       = false;
        var items       = $("#" + element[0].id + "Content ." + element[0].id + "Image");
		var itemsImg	= $("#" + element[0].id + "Content ." + element[0].id + "Image img");
        var itemsSpan   = $("#" + element[0].id + "Content ." + element[0].id + "Image span");
            
        items.each(function(i) {
    
            $(items[i]).mouseover(function() {
               mOver = true;
            });
            
            $(items[i]).mouseout(function() {
                mOver   = false;
                fadeElement(true);
            });
            
        });
        
        var fadeElement = function(isMouseOut) {
            var thisTimeOut = (isMouseOut) ? (timeOut/2) : timeOut;
            thisTimeOut = (faderStat) ? 10 : thisTimeOut;
            if(items.length > 0) {
                timeOutFn = setTimeout(makeSlider, thisTimeOut);
            } else {
                console.log("Poof..");
            }
        }
        
        var makeSlider = function() {
            current = (current != null) ? current : items[(items.length-1)];
            var currNo      = jQuery.inArray(current, items) + 1
            currNo = (currNo == items.length) ? 0 : (currNo - 1);
            var newMargin   = $(element).width() * currNo;
            if(faderStat == true) {
                if(!mOver) {
                    $(items[currNo]).fadeIn((timeOut/6), function() {
							$(itemsImg[currNo]).delay(1150).animate({"opacity": "1"}, (timeOut/6));
							$(itemsImg[currNo]).delay(1150).animate({"filter": "alpha(opacity=100)"}, (timeOut/6));
							$(itemsImg[currNo]).delay(1150).animate({"-moz-opacity": "1"}, (timeOut/6));
							$(itemsImg[currNo]).delay(1150).animate({"-khtml-opacity": "1"}, (timeOut/6));
							
                        if($(itemsSpan[currNo]).css('bottom') == 0) {
                            $(itemsSpan[currNo]).slideUp((timeOut/6), function() {
                                faderStat = false;
                                current = items[currNo];
                                if(!mOver) {
                                    fadeElement(false);
                                }
                            });
                        } else {
                            $(itemsSpan[currNo]).slideDown((timeOut/6), function() {
                                faderStat = false;
                                current = items[currNo];
                                if(!mOver) {
                                    fadeElement(false);
                                }
                            });
                        }
                    });
                }
            } else {
                if(!mOver) {
                    if($(itemsSpan[currNo]).css('bottom') == 0) {
                       		$(items[currNo]).fadeOut((timeOut/6), function(){
								$(itemsImg[currNo]).css('opacity', '0');
							});
							
							$(items[currNo]).fadeOut((timeOut/6));
							$(itemsSpan[currNo]).slideDown((timeOut/6), function() {
                                faderStat = true;
                                current = items[(currNo+1)];
                                if(!mOver) {
                                    fadeElement(false);
                                }
                            });
                    } else {
                        $(items[currNo]).fadeOut((timeOut/6), function(){
								$(itemsImg[currNo]).css('opacity', '0');							
							});
							$(items[currNo]).fadeOut((timeOut/6));	
							$(itemsSpan[currNo]).slideUp((timeOut/6), function() {
                        		
                                faderStat = true;
                                current = items[(currNo+1)];
                                if(!mOver) {
                                    fadeElement(false);
                                }
                        	});
                    }
                }
            }
        }
        
        makeSlider();

    };  

})(jQuery);  



///****PRELOADER IMGS***///

$.fn.preloader = function(options){
	
	var defaults = {
		             delay:200,
					 preload_parent:"a",
					 check_timer:300,
					 ondone:function(){ },
					 oneachload:function(image){  },
					 fadein:500 
					};
	
	// variables declaration and precaching images and parent container
	 var options = $.extend(defaults, options),
	 root = $(this) , images = root.find("img").css({"visibility":"hidden",opacity:0}) ,  timer ,  counter = 0, i=0 , checkFlag = [] , delaySum = options.delay ,
	 
	 init = function(){
		
		timer = setInterval(function(){
			
			if(counter>=checkFlag.length)
			{
			clearInterval(timer);
			options.ondone();
			return;
			}
		
			for(i=0;i<images.length;i++)
			{
				if(images[i].complete==true)
				{
					if(checkFlag[i]==false)
					{
						checkFlag[i] = true;
						options.oneachload(images[i]);
						counter++;
						
						delaySum = delaySum + options.delay;
					}
					
					$(images[i]).css("visibility","visible").delay(delaySum).animate({opacity:1},options.fadein,
					function(){ $(this).parent().removeClass("preloader");   });
					
					
					
				 
				}
			}
		
			},options.check_timer) 
		 
		 
		 } ;
	
	images.each(function(){
		
		if($(this).parent(options.preload_parent).length==0)
		$(this).wrap("<a class='preloader' />");
		else
		$(this).parent().addClass("preloader");
		
		checkFlag[i++] = false;
		
		
		}); 
	images = $.makeArray(images); 
	
	
	var icon = jQuery("<img />",{
		
		id : 'loadingicon' ,
		src : 'imgPreloader.gif'
		
		}).hide().appendTo("body");
	
	
	
	timer = setInterval(function(){
		
		if(icon[0].complete==true)
		{
			clearInterval(timer);
			init();
			 icon.remove();
			return;
		}
		
		},100);
	
	}

					
					
		//##############################
		// jQuery Custom Radio-buttons and Checkbox; basically it's styling/theming for Checkbox and Radiobutton elements in forms
		// By Dharmavirsinh Jhala - dharmavir@gmail.com
		// Date of Release: 13th March 10
		// Version: 0.8
		/*
		 USAGE:
			$(document).ready(function(){
				$(":radio").behaveLikeCheckbox();
			}
		*/
		
		var elmHeight = "20";	// should be specified based on image size
		
		// Extend JQuery Functionality For Custom Radio Button Functionality
		jQuery.fn.extend({
		dgStyle: function()
		{
			// Initialize with initial load time control state
			$.each($(this), function(){
				var elm	=	$(this).children().get(0);
				elmType = $(elm).attr("type");
				$(this).data('type',elmType);
				$(this).data('checked',$(elm).attr("checked"));
				$(this).dgClear();
			});
			$(this).mousedown(function() { $(this).dgEffect(); });
			$(this).mouseup(function() { $(this).dgHandle(); });	
		},
		dgClear: function()
		{
			if($(this).data("checked") == true)
			{
				$(this).css("backgroundPosition","center -"+(elmHeight*2)+"px");
				}
			else
			{
				$(this).css("backgroundPosition","center 0");
				}	
		},
		dgEffect: function()
		{
			if($(this).data("checked") == true)
				$(this).css({backgroundPosition:"center -"+(elmHeight*3)+"px"});
			else
				$(this).css({backgroundPosition:"center -"+(elmHeight)+"px"});
		},
		dgHandle: function()
		{
			var elm	=	$(this).children().get(0);
			if($(this).data("checked") == true)
				$(elm).dgUncheck(this);
			else
				$(elm).dgCheck(this);
			
			if($(this).data('type') == 'radio')
			{
				$.each($("input[name='"+$(elm).attr("name")+"']"),function()
				{
					if(elm!=this)
						$(this).dgUncheck(-1);
				});
			}
		},
		dgCheck: function(div)
		{
			$(this).attr("checked",true);
			$(div).data('checked',true).css({backgroundPosition:"center -"+(elmHeight*3)+"px"});
		},
		dgUncheck: function(div)
		{
			$(this).attr("checked",false);
			if(div != -1)
				$(div).data('checked',false).css({backgroundPosition:"center 0"});
			else
				$(this).parent().data("checked",false).css({backgroundPosition:"center 0"});
		}
		});					