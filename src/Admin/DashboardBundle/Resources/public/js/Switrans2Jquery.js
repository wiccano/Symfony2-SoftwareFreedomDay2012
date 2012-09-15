var x;
x=$(document);
x.ready(inicializarEventos);

function inicializarEventos()
{
  //Mantenemos oculta la capa loading...
  ocultaLoading();
  //muestraLoading();
}

function muestraLoading(){
    jQuery('#loading').show();
    jQuery('#imgLoading').show();
}

function ocultaLoading(){
    jQuery('#loading').hide();
    jQuery('#imgLoading').hide();
}

var page, pics, tab, lang;
$(function () {

    page = {
	   path: function () {
            return $("<a />").attr("href", $.current_url || location.pathname)[0].pathname
        },	
	},
	
	pics = {
        $btn: function () {
            return $("#filters #btn_picsnav a")
        },
        $picsnav: function () {
            return $("#pictures_nav")
        },
        togglePicsNav: function () {
			if(pics.$picsnav().is(":visible")){
				//$('nav>#pictures_nav #fotosClientesCarouselContainer #fotosClientesCarousel').carousel('pause');
				pics.hidePicsNav();
			} else {
				if ($("#pictures_nav").html() == "") {
					var $contenidoAjax = pics.$picsnav().html('');
					$.ajax({
						url: Routing.generate('PortalClientesBundle_navFotografias'),
						success: function(data){
							// Aquí desaparece la imagen ya que estamos reemplazando todo el HTML del contenido de la div.
							$contenidoAjax.html(data);
							pics.showPicsNav();
						}
					});
				} else {
					pics.showPicsNav();
					//$('nav>#pictures_nav #fotosClientesCarouselContainer #fotosClientesCarousel').carousel('next');
				}
			}
        },
        hidePicsNav: function () {
            pics.$picsnav().slideUp(200)
        },
        showPicsNav: function () {
            pics.$picsnav().slideDown(200)
        },
		buildPicsNav: function () {
			url = Routing.generate('PortalClientesBundle_navFotografias');
            pics.$picsnav().load(url);
        },

    }, 
	pics.$btn().on("click", function () {
		pics.togglePicsNav();   
    })
	
	tab = {
		$list: function () {
            return $("body > nav .nav_tab")
        },
        clearActive: function () {
            tab.$list().removeClass("active")
        },
        setActive: function () {
            var a = page.path();
            tab.clearActive(),a == "/Switrans2/web/app_dev.php/es" || a == "/Switrans2/web/app_dev.php/en" ? ($('body > nav .nav_tab:contains("Inicio")').addClass("active")) :	a == "/Switrans2/web/app_dev.php/es/Portal/ClientesBundle/Informes" || a == "/Switrans2/web/app_dev.php/en/Portal/ClientesBundle/Informes" ? ($('body > nav .nav_tab:contains("Informes")').addClass("active")) : a == "/Switrans2/web/app_dev.php/es/Portal/ClientesBundle/Reclamos" || a == "/Switrans2/web/app_dev.php/en/Portal/ClientesBundle/Reclamos" ? ($('body > nav .nav_tab:contains("Reclamos")').addClass("active")) :	a == "/Switrans2/web/app_dev.php/es/Portal/ClientesBundle/Facturacion" || a == "/Switrans2/web/app_dev.php/en/Portal/ClientesBundle/Facturacion" ? ($('body > nav .nav_tab:contains("Facturación")').addClass("active")) : tab.clearActive()
        }
	}, tab.setActive(),
	
	lang = {
		$langopt: function () {
			return $("#langs #languages_nav #langselect a")
		},
		toggleLang: function () {
			if ($('#ingles_langselect').length) {
				var url = Routing.generate("PortalClientesBundle_homepage", { "_locale": "en"});
			} else {
				var url = Routing.generate("PortalClientesBundle_homepage", { "_locale": "es"});
			}
			$(location).attr('href',url);
		}
	},
	lang.$langopt().on("click", function () {	
        return lang.toggleLang();
   })
   
   // Initialize validator setDefaults
	$.validator.setDefaults({
		highlight: function(input) {
			$(input).addClass("ui-state-highlight");
		},
		unhighlight: function(input) {
			$(input).removeClass("ui-state-highlight");
		}
	});  	
});

	
