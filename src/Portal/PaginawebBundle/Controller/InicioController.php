<?php

namespace Portal\PaginawebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Admin\UsuariosBundle\Form\CambiarContrasenaFormType;

use Portal\PaginawebBundle\Entity\Contacto;
use Portal\PaginawebBundle\Form\ContactoFormType;
use Portal\PaginawebBundle\Entity\Categoria;
use Portal\PaginawebBundle\Entity\CategoriaRepository;
use Portal\PaginawebBundle\Form\CategoriaFormType;
use Portal\PaginawebBundle\Entity\Producto;
use Portal\PaginawebBundle\Form\ProductoFormType;
use Portal\PaginawebBundle\Entity\Imagen;
use Portal\PaginawebBundle\Entity\Introimagen;
use Portal\PaginawebBundle\Form\ImagenFormType;



use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class InicioController extends Controller
{    
	
	/*
	* Usado para atender la entrada al sistema y redirigir al idioma por defecto
	*/
	public function raizAction()
	{
		return $this->redirect($this->generateUrl('PortalPaginawebBundle_inicio'), 301);
	}
	
	
	/*
	* Función usada como el Inicio de la página Web
	*/
	public function inicioAction()
	{
		try
		{
			$em = $this->getDoctrine()->getEntityManager();
			$Imagen = $em->find('Portal\PaginawebBundle\Entity\Introimagen', 1);
	    	
	    	return $this->render('PortalPaginawebBundle:Inicio:inicio.html.twig', array('Imagen' => $Imagen ));
	    
		} catch (\Exception $e) {
	    	return new Response($e->getMessage());
	    }    
	}
	
	
    /*
    * Usado para cargar la información de la sección contacto
    */
    public function cargandocontactoAction()
    {
    	try
    	{
	    	$em = $this->getDoctrine()->getEntityManager();
	    	$Contacto = $em->find('Portal\PaginawebBundle\Entity\Contacto', 1);
	    	 
	    	if (!$Contacto)
	    		throw $this->createNotFoundException('Error Inesperado... Consulte al Administrador del Sistema.');
	       	
	    	return $this->render('PortalPaginawebBundle:Inicio:cargandocontacto.html.twig', array('Contacto' => $Contacto));
	    	
	    } catch (\Exception $e) {
	    	return new Response($e->getMessage());
	    }
    }
    
    
    /*
    * Usado para cargar el menú lateral
    */
    public function cargandomenuAction($Tipomenu)
    {   
    	try
    	{ 	 
    		$em = $this->getDoctrine()->getEntityManager();
    		$productos = $em->getRepository('\Portal\PaginawebBundle\Entity\Producto')->findMenu($Tipomenu);
    
    		return $this->render('PortalPaginawebBundle:Inicio:cargandomenu.html.twig', array('productos' => $productos ));
    		
    	} catch (\Exception $e) {
    		return new Response($e->getMessage());
    	}
    }
    
    
    /*
    * Usado para cargar el contenido de Hoja de vida
    */
    public function downloadhojavidaAction()
    {	
    	try
    	{
    		$em = $this->getDoctrine()->getEntityManager();
    		$hojavida = $em->find('Portal\PaginawebBundle\Entity\Hojavida', 1);
    	
    		return $this->render('PortalPaginawebBundle:Inicio:cargandohojavida.html.twig', array(
    			'hojavida' => $hojavida
    		));
    		
    	} catch (\Exception $e) {
    		return new Response($e->getMessage());
    	}   		
    }
    
    /*
    * Usado para responder al click sobre los productos que aparecen en el menú lateral
    */
	public function cargandocontenidoprincipalAction($producto_codigo)
	{	
		try
		{
			if(!$producto_codigo)
				throw $this->createNotFoundException('Ha ocurrido un error inesperado. Recargue la página e intente de nuevo o consulte a los desarrolladores del sistema');
			
			$em = $this->getDoctrine()->getEntityManager();
			$Producto = $em->find('Portal\PaginawebBundle\Entity\Producto', $producto_codigo);
			$Imagenes = $em->getRepository('\Portal\PaginawebBundle\Entity\Imagen')->findByAlt($producto_codigo);
			
			return $this->render('PortalPaginawebBundle:Inicio:cargandocontenidoprincipal.html.twig', array(
					'producto' => $Producto,
					'imagenes' => $Imagenes
			));
			
		} catch (\Exception $e) {
			return new Response($e->getMessage());
		}
	}
	
	public function cargandointroimagenAction($Tipomenu)
	{
		try
		{
			$em = $this->getDoctrine()->getEntityManager();
			$Imagen = $em->find('Portal\PaginawebBundle\Entity\Introimagen', $Tipomenu);
		 
			return $this->render('PortalPaginawebBundle:Inicio:cargandointroimagen.html.twig', array('Imagen' => $Imagen ));
			
		} catch (\Exception $e) {
			return new Response($e->getMessage());
		}
	}

}
