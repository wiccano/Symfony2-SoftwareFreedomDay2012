/* Author:

*/
// remap jQuery to $
(function($){})(window.jQuery);

/* trigger when page is ready */
$(document).ready(function (){
	
					(function($){
					  $.fn.showdelay = function(){
						var delay = 0;
						return this.each(function(){
						  $(this).delay(delay).fadeIn(300);
						  delay += 300;
						});
					  };
					})(jQuery);

	
	/**ALL FADEIN ANIMATION INTROS**/
		$('#head').fadeIn('slow', function() {
				// Animation complete 1
				/* CHECK IF EXITS THE HOME SLIDER */ 
				if ($('#sliderBox').length){ 
						$('#sliderBox').fadeIn('slow');	
				}else{
					if ($('.internal').length){
						$('.internal').animate({"opacity": "1"}, "slow");
					}else{
						$('.full').animate({"opacity": "1"}, "slow");
					}
				};

			$('.middle, #servHome img').fadeIn('fast', function() {
						// Animation complete 2	
							$('.news').animate({"opacity": "1"}, "slow");
						});		
			$('#footCont').fadeIn('slow');	
				
		});	
	
			/*DROPDOWN*/
				/*	$('nav ul.navs li').hover(function() {
						$('nav ul.navs li ul').animate({"opacity": "1"}, "slow");
						
					}, function() {
						$('nav ul.navs li ul').animate({"opacity": "0"}, "fast");
					});
				*/
	
				/** IMG´s HOVER**/
					jQuery('#servHome img, #boxZone img, #footLinks li a, #netsLinks li a img, #footLinks p a, .s3min1SlImage a img, .s3min2SlImage a img, #lang a img, a.emailBt, .lerfBtArea a, #intRImgFeat, newsResume ul li a, #leftColumn	#pdfBox img, #loadImage, #galleBox img').hover(function() {	
								jQuery(this).animate({"opacity": ".5"}, "slow");	
							}, function() {
								jQuery(this).animate({"opacity": "1"}, "slow");			
					});
		
		
					//$('#rowInt').showdelay();
					
					jQuery('.videoPreview img').hover(function() {	
								jQuery(this).animate({"opacity": ".5"}, "slow");
								$('.videoPreview').addClass('videoHovIc');	
							}, function() {
								jQuery(this).animate({"opacity": "1"}, "fast", function(){
										if ($('.videoHovIc').length){
											//*** ALREADY LIST **//
										}else{
											$('.videoPreview').removeClass('videoHovIc');
										}
									});	
									
					});
		
		/*
												//** HOVER ALLS BUTTONS*///												
						   																						
														$('ul.tabsRoutes li, .tabsCountries li, .tabsCitiesCol li, .tabsCitiesVen li, .tabsCitiesEcu li').hover(function() {	
																	if( $(this).hasClass('actRoute') || $(this).hasClass('actTab') ){
																			$(this).find('a').css('color', '#FFF');
																		}
																	else{	
																			$(this).find('a').css('color', '#FFF');
																		}		
																	}, function() {
																			if( $(this).hasClass('actRoute') || $(this).hasClass('actTab') ){
																					//$(this).css('color', '#333333');
																			}
																			else{
																				$(this).find('a').css('color', '#333333');
																			}	
															});
					
		//***LIGHTBOX
						/** DEFAULT CONFIG */
							/*$("a#gallery").fancybox({
									'autoScale'			: true,
									'transitionIn'		: 'none',
									'transitionOut'		: 'none',
									'overlayColor'		: '#FFF',
									'overlayOpacity'	: 0.5, 
									'padding'			: 0,
									'autoScale'			: true,
									'overlayShow'		: false 
							});	*/

							/**** LIGHTBOX CONFIG VIDEO ***/		
										$("a#videoUrl").click(function() {
												$.fancybox({
												  'padding'			: 0,
												  'autoScale'		: false,
												  'transitionIn'	: 'none',
												  'transitionOut'	: 'none',
												  'title'			: this.title,
												  'width'			: 640,
												  'height'			: 385,
												  'overlayColor'	: '#FFF',
												  'overlayOpacity'	: 0.5, 
												  'href'			: this.href.replace(new RegExp("watch\\?v=", "i"), 'v/'),
												  'type'			: 'swf',
												  'swf'				: {
												  'wmode'			: 'transparent',
												  'allowfullscreen'	: 'true'
												  }
											  });
											  return false;
										 });
		
		/////////////**************THE DOT STUDIO LOGO*******************------------
					jQuery('.theDot').hover(function() {	
								
								jQuery('.theDotDesign').animate({"left": "-43px"}, "fast");	
								jQuery('.theDotByThe').animate({"left": "25px","opacity":"1"}, "fast");	
								jQuery('.theDot').animate({"opacity": "1"}, "fast");
									
							}, function() {
								
								jQuery('.theDotDesign').animate({"left": "20px"}, "slow");
								jQuery('.theDotByThe').animate({"left": "0px","opacity":"0"}, "slow");
								jQuery('.theDot').animate({"opacity": "1"}, "slow");
									
					});
					
					
		
});


/* optional triggers

$(window).load(function() {
	
});

$(window).resize(function() {
	
});

*/

