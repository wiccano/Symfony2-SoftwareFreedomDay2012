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

class PaginawebController extends Controller
{    
    
	public function raizAction()
	{
		//$response = new Response();
		//$response->setStatusCode(400);
		//$response->headers->set('Content-Type', 'text/html');
		//return $response;
		return $this->redirect($this->generateUrl('PortalPaginawebBundle_inicio'), 301);
	}
    
    public function inicioAction()
    {        
    	$em = $this->getDoctrine()->getEntityManager();
    	$Imagen = $em->find('Portal\PaginawebBundle\Entity\Introimagen', 1);
    	
    	return $this->render('PortalPaginawebBundle:Inicio:inicio.html.twig', array('Imagen' => $Imagen ));
    }

    public function cargandomenuAction($Tipomenu) {
    	
    	$em = $this->getDoctrine()->getEntityManager();
    	$productos = $em->getRepository('\Portal\PaginawebBundle\Entity\Producto')->findMenu($Tipomenu);
    	 
    	return $this->render('PortalPaginawebBundle:Inicio:cargandomenu.html.twig', array('productos' => $productos ));
    }
    
    public function cargandointroimagenAction($Tipomenu) {
    	 
    	$em = $this->getDoctrine()->getEntityManager();
    	$Imagen = $em->find('Portal\PaginawebBundle\Entity\Introimagen', $Tipomenu);
    	
    	return $this->render('PortalPaginawebBundle:Inicio:cargandointroimagen.html.twig', array('Imagen' => $Imagen ));
    }
    
    public function productoAction()
    {
    	 
    	return $this->render('PortalPaginawebBundle:Inicio:espacio.html.twig');
    }
    
    public function espacioAction()
    {
    	
        return $this->render('PortalPaginawebBundle:Inicio:espacio.html.twig');
    }
    
    public function mobiliarioAction()
    {
    	
    	return $this->render('PortalPaginawebBundle:Inicio:mobiliario.html.twig');
    }
    
    public function prensaAction()
    {
    	
    	return $this->render('PortalPaginawebBundle:Inicio:prensa.html.twig');
    }
    
	public function admininicioAction()
    {
    	$Contacto = $this->getContacto(1);
    	$Categoria = new Categoria;
    	$Producto = new Producto;
    	$Producto->setProductoFechacreacion(new \DateTime("now") );
    	$Producto->setProductoFechamodificacion(new \DateTime("now"));
    	
    	$formContacto = $this->createForm(new ContactoFormType(), $Contacto );
    	$formCategoria = $this->createForm(new CategoriaFormType(), $Categoria );
    	$formProducto = $this->createForm(new ProductoFormType(), $Producto);
    
    	
    	return $this->render('PortalPaginawebBundle:Admin:inicio.html.twig', array(
    			'formContacto' => $formContacto->createView(),
    			'formCategoria' => $formCategoria->createView(),
    			'formProducto' => $formProducto->createView(),
    	));
    }
    
    protected function getContacto($id)
    {
    	$em = $this->getDoctrine()->getEntityManager();
    	$contacto = $em->find('Portal\PaginawebBundle\Entity\Contacto', $id);
    	 
    
    	if (!$contacto) {
    		throw $this->createNotFoundException('Error Inesperado... Consulte al Administrador del Sistema.');
    	}
    
    	return $contacto;
    }
    
    
    
    
    
    protected function setContacto($id)
    {
    	$em = $this->getDoctrine()->getEntityManager();
    	$contacto = $em->find('Portal\PaginawebBundle\Entity\Contacto', $id);
    	$em->update($id);
    
    	if (!$contacto) {
    		throw $this->createNotFoundException('Error Inesperado... Consulte al Administrador del Sistema.');
    	}
    
    	return $contacto;
    	
    	
    }
    
    
    
    
    
    
    /*
     * Función usada para mostrar el contenido del Servicio de Transporte
    */
    public function cargandocontactoAction()
    {
    	$Contacto = $this->getContacto(1);
    	
    	$em = $this->getDoctrine()->getEntityManager();
    	$hojavida = $em->find('Portal\PaginawebBundle\Entity\Hojavida', 1);
    	
    	return $this->render('PortalPaginawebBundle:Inicio:cargandocontacto.html.twig', array('Contacto' => $Contacto));
    }
   
    public function downloadhojavidaAction(){
    	
    	$em = $this->getDoctrine()->getEntityManager();
    	$hojavida = $em->find('Portal\PaginawebBundle\Entity\Hojavida', 1);
    	
    	return $this->render('PortalPaginawebBundle:Inicio:cargandohojavida.html.twig', array('hojavida' => $hojavida));
    	
    }
    
    public function formCategoriaAction($categoria_codigo)
    {
    	if ($categoria_codigo > 0) {
    		$em = $this->getDoctrine()->getEntityManager();
    		$Categoria = $em->find('Portal\PaginawebBundle\Entity\Categoria', $categoria_codigo);
    		$actualizar ='<p>Categoría actualizada con éxito!<p>';
    	} else 	{
    		$Categoria = new Categoria;
    		$actualizar ='<p>Categoría creada con éxito!<p>';
    	}
    	    	
    	$formCategoria = $this->createForm(new CategoriaFormType(), $Categoria ); 
    	
    	$request = $this->get('request'); 
    	if ($request->getMethod() == 'POST' && $request->isXmlHttpRequest())
    	{
    		$formCategoria->bindRequest($request);
    	
    		if ($formCategoria->isValid()) 
    		{
    			$em = $this->getDoctrine()->getEntityManager();
    			$em->persist($Categoria);
	    		$em->flush();
    			
	    		$options = array(
    		    	"categoria_nombre" => $Categoria->getCategoriaNombre(),
    		    	"categoria_codigo" => $Categoria->getCategoriaCodigo(),
    		    	"categoria_descripcion" => $Categoria->getCategoriaDescripcion(),
    		    	"categoria_peso" => $Categoria->getCategoriaPeso(),
    		    	"menu_codigo" => $Categoria->getMenuCodigo(),
	    		);
	    		
	    		$formCategoria = $this->createForm(new CategoriaFormType(), $Categoria, $options);
	    			
  				return $this->render('PortalPaginawebBundle:Admin:cargandonuevacategoria.html.twig', array(
  				    'formCategoria' => $formCategoria->createView(),
  				    'MsgOk' => $actualizar
  				));

    		} else {
    			return new Response('Los datos no son validos!');
    		}
    		
    	} else {
    		return new Response('Ha ocurrido un error inesperado. Recargue la página e intente de nuevo o consulte a los desarrolladores del sistema');
    	}
    }
    
      
    public function cargandocategoriasAction($menu_codigo)
    {
    	$request = $this->get('request');
    	$em = $this->get('doctrine.orm.entity_manager');
    	$menus = $em->getRepository('\Portal\PaginawebBundle\Entity\Menu')->findAll();
    	 
    	if($menu_codigo > 0){
    		$categorias = $em->getRepository('\Portal\PaginawebBundle\Entity\Categoria')->findBy(array('menu_codigo' => $menu_codigo));
    	} else {
    		$categorias = $em->getRepository('\Portal\PaginawebBundle\Entity\Categoria')->findAll();
    	}
    	 
    	if ($request->isXmlHttpRequest())
    	{
    		if ($menus)
    		{
    			$categoriasHtml = $this->render('PortalPaginawebBundle:Admin:cargandocategorias.html.twig', array('menus' => $menus, 'categorias' => $categorias, 'menu_codigo' => $menu_codigo));
    			return $categoriasHtml;
    		} else {
    			return new Response('<h1>Debe crear al menos un Tipo de Menú antes de usar el módulo de categorias.</h1>');
    		}
    	
    	}
    
    }
    
    
    
    
    
    public function FormContactoAction(){
    	
    	$Contacto = $this->getContacto(1);
    	$formContacto = $this->createForm(new ContactoFormType(), $Contacto );
    	
    	$request = $this->get('request');
    	if ($request->getMethod() == 'POST' && $request->isXmlHttpRequest())
    	{
    		$formContacto->bindRequest($request);
    		 
    		if ($formContacto->isValid())
    		{
    			$em = $this->getDoctrine()->getEntityManager();
    			$em->persist($Contacto);
    			$em->flush();
    			
    			$arr = array('Msg' => '<p>Información Actualizada!<p>');
    			$response = new Response(json_encode($arr));
    			$response->headers->set('Content-Type','aplicattions/json');
    			
    			return $response;
    		}
    		
    		$arr = array('Msg' => '<p style="color:red;">Ha ocurrido un error inesperado!. Consulte al Administrador<p>');
    		$response = new Response(json_encode($arr));
    		$response->headers->set('Content-Type','aplicattions/json');
    		 
    		return $response;
    	}
    	
    }
    
    
    public function eliminandocategoriaAction($categoria_codigo){
    	$em = $this->getDoctrine()->getEntityManager();
    	$Categoria = $em->find('Portal\PaginawebBundle\Entity\Categoria', $categoria_codigo);
    	$request = $this->get('request');  // trae la solicitus
    	if ($request->getMethod() == 'GET' && $request->isXmlHttpRequest())
    	{	
    		
    		if ($categoria_codigo)
    		{
    			$em = $this->getDoctrine()->getEntityManager(); 
    			$em->remove($Categoria);
    			$em->flush();
    			 
    			$arr = array('Msg' => '<p>Informacion Eliminada!<p>');
    			$response = new Response(json_encode($arr));
    			$response->headers->set('Content-Type','aplicattions/json');
    	
    	
    			return $response;
    				
    		} 

    	}
    	  	 
    }
    
    
    public function eliminaImagenProductoAction($imagen_codigo){
    	$em = $this->getDoctrine()->getEntityManager();
    	$Imagen = $em->find('Portal\PaginawebBundle\Entity\Imagen', $imagen_codigo);
    	$request = $this->get('request');
    	
    	if ($request->getMethod() == 'GET' && $request->isXmlHttpRequest()){
    		if ($imagen_codigo){
    			$em = $this->getDoctrine()->getEntityManager();
    			$em->remove($Imagen);
    			$em->flush();
    
    			return new Response('Imagen Eliminada con Éxito');
    
    		} else {
    			return new Response('Ha ocurrido un error inesperado. Recargue la página e intente de nuevo o consulte a los desarrolladores del sistema');
    		}
    
    	}
    	
    	return new Response($request->getMethod());
    		
    }
    
    
    public function cargandoproductosAction($categoria_codigo = 0){
 
    	$request = $this->get('request'); 	
    	$em = $this->get('doctrine.orm.entity_manager');
    	$categorias = $em->getRepository('\Portal\PaginawebBundle\Entity\Categoria')->findAll();
    	
    	if($categoria_codigo){
    		$productos = $em->getRepository('\Portal\PaginawebBundle\Entity\Producto')->findBy(array('categoria_codigo' => $categoria_codigo));
    	} else {
	    	$productos = $em->getRepository('\Portal\PaginawebBundle\Entity\Producto')->findAll();
    	}
    	
    	if ($request->isXmlHttpRequest())
    	{
    
    		if ($categorias)
    		{
    			$productosHtml = $this->render('PortalPaginawebBundle:Admin:cargandoproductos.html.twig', array('categorias' => $categorias, 'productos' => $productos, 'categoria_codigo' => $categoria_codigo)); 
				return $productosHtml;
    		} else {
    			return new Response('<h1>Debe crear al menos una categoria antes de usar el módulo de productos.</h1>');
    		}
    
    	}
    		
    }
    
    public function cargandonuevacategoriaAction($categoria_codigo){

    	$em = $this->get('doctrine.orm.entity_manager');
    	
    	$Categoria = $em->find('\Portal\PaginawebBundle\Entity\Categoria', $categoria_codigo);
    	
    	if(!$Categoria)
    		$Categoria = new Categoria();
		
    	$options = array(
    		"categoria_nombre" => $Categoria->getCategoriaNombre(),
    		"categoria_codigo" => $Categoria->getCategoriaCodigo(),
    		"categoria_descripcion" => $Categoria->getCategoriaDescripcion(),
    		"categoria_peso" => $Categoria->getCategoriaPeso(),
    		"menu_codigo" => $Categoria->getMenuCodigo(),
    	);
		
    	
    	$formCategoria = $this->createForm(new CategoriaFormType(), $Categoria, $options);
    	
    	return $this->render('PortalPaginawebBundle:Admin:cargandonuevacategoria.html.twig', array(
    		'formCategoria' => $formCategoria->createView(),
    		'categoria' => $Categoria
    	));
    
    }
    
    
    public function cargandonuevoproductoAction($producto_codigo){

    	$em = $this->get('doctrine.orm.entity_manager');
    	 
    	$Producto = $em->find('\Portal\PaginawebBundle\Entity\Producto', $producto_codigo);    	 
    	$Imagenes = $em->getRepository('Portal\PaginawebBundle\Entity\Imagen')->findBy(array('producto_codigo' => $producto_codigo));
    	 
    	 
    	if(!$Producto) {
    		$Producto = new Producto();
    		$imagenes = NULL;
    	} else {
    		$imagenes = $Producto->getImagenes();
    	}
    	 
    	$Imagen = new Imagen();
    	$formImagen = $this->createForm(new ImagenFormType(), $Imagen);
    
    	$formProducto = $this->createForm(new ProductoFormType());
    	$formProducto->setData($Producto);
    	 
    	$request = $this->getRequest();
    
    	return $this->render('PortalPaginawebBundle:Admin:cargandonuevoproducto.html.twig', array(
        		'formProducto' => $formProducto->createView(),
        		'formImagen' => $formImagen->createView(),
        		'producto_codigo' => $producto_codigo,
        		'imagenes' => $Imagenes
    	));
    
    }
    
    
    
    public function formProductoAction($producto_codigo)
    {
    	$em = $this->getDoctrine()->getEntityManager();
    	if ($producto_codigo > 0) { //
    		$Producto = $em->find('Portal\PaginawebBundle\Entity\Producto', $producto_codigo);
    		$actualizar ='<p>Producto actualizado con éxito!<p>';
    		$Imagenes = $em->getRepository('Portal\PaginawebBundle\Entity\Imagen')->findBy(array('producto_codigo' => $producto_codigo));
    	
    	} else 	{
    		$Producto = new Producto;
    		$Producto->setProductoFechacreacion(new \DateTime("now") );
    		$Producto->setProductoFechamodificacion(new \DateTime("now"));
    		$actualizar ='<p>Producto creado con éxito!<p>';
    		$Imagenes = $em->getRepository('Portal\PaginawebBundle\Entity\Imagen')->findBy(array('producto_codigo' => 0));
    	}
    	 
    	$formProducto = $this->createForm(new ProductoFormType());
    	$formProducto->setData($Producto);
    	
    	
    	
    	 
    	$request = $this->get('request');
    	if ($request->getMethod() == 'POST' && $request->isXmlHttpRequest())
    	{
    		$formProducto->bindRequest($request);
    		
    		$Imagen = new Imagen();
    		$formImagen = $this->createForm(new ImagenFormType(), $Imagen);
    		
    		if($producto_codigo == 0){
    			$ProductoNombre = $em->getRepository('Portal\PaginawebBundle\Entity\Producto')->findBy(array('producto_nombre' => $Producto->getProductoNombre()));
    			if($ProductoNombre){
    				return $this->render('PortalPaginawebBundle:Admin:cargandonuevoproducto.html.twig', array(
    						'formProducto' => $formProducto->createView(),
    						'formImagen' => $formImagen->createView(),
    						'MsgError' => 'El nombre de este producto ya existe en la base de datos.',
    						'producto_codigo' => $producto_codigo,
    						'imagenes' => $Imagenes
    				));
    			}
    		}
    	
    	 	if(NULL === $formProducto->getData()->getCategoriaCodigo()){
    	 		return $this->render('PortalPaginawebBundle:Admin:cargandonuevoproducto.html.twig', array(
    	 				'formProducto' => $formProducto->createView(),
    	 				'formImagen' => $formImagen->createView(),
    	 				'MsgError' => 'Seleccione una Categoría',
    	 				'producto_codigo' => $producto_codigo,
    	 				'imagenes' => $Imagenes
    	 		));
    	 	}
    		
    		if ($formProducto->isValid())
    		{

	    		$em = $this->getDoctrine()->getEntityManager();
	    		$em->persist($Producto);
	    		$em->flush();
	    		
	    		$Imagen = new Imagen();
	    		$formImagen = $this->createForm(new ImagenFormType(), $Imagen);
	    		 
	    		return $this->render('PortalPaginawebBundle:Admin:cargandonuevoproducto.html.twig', array(
	    			'formProducto' => $formProducto->createView(),
	    			'formImagen' => $formImagen->createView(),
	    			'MsgOk' => $actualizar,
	    			'producto_codigo' => $Producto->getProductoCodigo(),
	    			'imagenes' => $Imagenes
	    		));
	    			
	    	} else {
	    		$errors = $this->get('validator')->validate( $Producto );
	    		$Producto = new Producto;    	
		    	$formProducto = $this->createForm(new ProductoFormType(), $Producto);
		    	
		    	$Imagen = new Imagen();
		    	$formImagen = $this->createForm(new ImagenFormType(), $Imagen);
		    	 
		    	return $this->render('PortalPaginawebBundle:Admin:cargandonuevoproducto.html.twig', array(
		    		'formProducto' => $formProducto->createView(),
		    		'formImagen' => $formImagen->createView(),
		    		'errors' => $errors,
		    		'imagenes' => $Imagenes
		    	));
	    	}
	    
	    } else {
	   		return new Response('Ha ocurrido un error inesperado. Recargue la página e intente de nuevo o consulte a los desarrolladores del sistema');
	    }
    }
   
    public function addImagenAction()
    {
    	$destinoImagen = $this->getUploadRootDir();
    	if(isset($_FILES['image'])){
    	
    		$nombre = $_FILES['image']['name'];
    		$temp   = $_FILES['image']['tmp_name'];
    		
    		$em = $this->getDoctrine()->getEntityManager();
    		$ImagenNombre = $em->getRepository('\Portal\PaginawebBundle\Entity\Imagen')->findBy(array('imagen_nombre' => $nombre));
    			
    		if($ImagenNombre){
    			$Msg = '<br><p>Ya existe una imagen con este mismo nombre. Modifique el nombre e intente de nuevo<p>';
    		
    			return new Response($Msg);
    		}
    	
    		if(!move_uploaded_file($temp, $destinoImagen.$nombre))
    		{
    			$Msg = '<br><p>Ha ocurrido un error al tratar de cargar la Imagen. Recarque la página e intente de nuevo. Sino consulte a los desarrolladores del sistema<p>';
    			
    			return new Response($Msg);
    				
    		} else {
    			$Msg = '<br><p>Imagen lista asociar al producto.<p>';
    			return new Response($Msg);
    		}
    	}
	}
	
	public function formImagenAction(){
		$em = $this->getDoctrine()->getEntityManager();
		
		$Imagen = new Imagen;
		$formImagen = $this->createForm(new ImagenFormType());
		$formImagen->setData($Imagen);
		$request = $this->get('request');

		if ($request->getMethod() == 'POST' && $request->isXmlHttpRequest())
		{
			$formImagen->bindRequest($request);
			
			$ImagenNombre = $em->getRepository('\Portal\PaginawebBundle\Entity\Imagen')->findBy(array('imagen_nombre' => $formImagen->getData()->getImagenNombre()));
			
			if($ImagenNombre){
				$Msg = 'Ya existe una imagen con este mismo nombre. Modifique el nombre e intente de nuevo';
				
				return new Response($Msg);
			}
		
		
			if ($formImagen->isValid())
			{
				
				$Producto = $em->find('\Portal\PaginawebBundle\Entity\Producto', $formImagen->getData()->getProductoCodigo());
				
				$em = $this->getDoctrine()->getEntityManager();
				$Imagen->setProductoCodigo($Producto);
				$em->persist($Imagen);
				$em->flush();
				 
				$Imagen = new Imagen();
				$formImagen = $this->createForm(new ImagenFormType(), $Imagen);
		
				$Msg = 'Imagen cargada con éxito para este producto';

    			return new Response($Msg);
		
			} else {
				$errors = $this->get('validator')->validate( $Imagen );
				
				$rhtml = $this->render('PortalPaginawebBundle:Admin:errorsproducto.html.twig', array('errors' => $errors));

				$response = $rhtml;
				
				return $response;
			}
			 
		} else {
			return new Response('Ha ocurrido un error inesperado. Recargue la página e intente de nuevo o consulte a los desarrolladores del sistema');
		}
		
		
	}
	
	public function cargandocontenidoprincipalAction($producto_codigo)
	{	
		if(!$producto_codigo){
			return new Response('Ha ocurrido un error inesperado. Recargue la página e intente de nuevo o consulte a los desarrolladores del sistema');
		}
		$em = $this->getDoctrine()->getEntityManager();
		$Producto = $em->find('Portal\PaginawebBundle\Entity\Producto', $producto_codigo);
		$Imagenes = $em->getRepository('\Portal\PaginawebBundle\Entity\Imagen')->findBy(array('producto_codigo' => $producto_codigo));
		
		return $this->render('PortalPaginawebBundle:Inicio:cargandocontenidoprincipal.html.twig', array(
				'producto' => $Producto,
				'imagenes' => $Imagenes
		));
		
	}
	
	public function cargandointroAction($menu_codigo){
		
		$em = $this->getDoctrine()->getEntityManager();

		$intro = $em->find('Portal\PaginawebBundle\Entity\Introimagen', 1);
		
		if (!$intro) {
			throw $this->createNotFoundException('Error Inesperado... Consulte al Administrador del Sistema.');
		}
		
		$menus = $em->getRepository('\Portal\PaginawebBundle\Entity\Menu')->findAll();
		
		if($menu_codigo == 0){
			$introimagen = $em->find('Portal\PaginawebBundle\Entity\Introimagen', 1);
		} else if($menu_codigo == 1){
			$introimagen = $em->find('Portal\PaginawebBundle\Entity\Introimagen', 2);
		} else if($menu_codigo == 2){
			$introimagen = $em->find('Portal\PaginawebBundle\Entity\Introimagen', 3);
		} else if($menu_codigo == 3){
			$introimagen = $em->find('Portal\PaginawebBundle\Entity\Introimagen', 4);
		} else if($menu_codigo == 4){
			$introimagen = $em->find('Portal\PaginawebBundle\Entity\Introimagen', 5);
		}
		
		
		$request = $this->get('request');
		if ($request->isXmlHttpRequest())
		{
			return $this->render('PortalPaginawebBundle:Admin:cargandointro.html.twig', array(
						'menus' => $menus,
						'menu_codigo' => $menu_codigo,
                        'introimagen' => $introimagen
			));
			 
		} else {
			return new Response('Ha ocurrido un error inesperado. Recargue la página e intente de nuevo o consulte a los desarrolladores del sistema');
		}
		
	}
	
	protected function getUploadRootDir()
	{
		return __DIR__.'/../../../../web/'.$this->getUploadDir();
	}
	
	protected function getUploadDir()
	{
		return 'uploads/documents/';
	}
	
	protected function getUploadIntroRootDir()
	{
		return __DIR__.'/../../../../web/'.$this->getUploadIntroDir();
	}
	
	protected function getUploadIntroDir()
	{
		return 'uploads/intro/';
	}
	
	protected function getUploadDocRootDir()
	{
		return __DIR__.'/../../../../web/'.$this->getUploadDocDir();
	}
	
	protected function getUploadDocDir()
	{
		return 'uploads/docs/';
	}
	
	function addIntroimagenAction($seccion, $tipo, $nombrecampo){
		
		$destinoImagen = $this->getUploadintroRootDir();
		if(isset($_FILES[$nombrecampo])){
			
			$nombre = $_FILES[$nombrecampo]['name'];
			$temp   = $_FILES[$nombrecampo]['tmp_name'];
			
			$em = $this->getDoctrine()->getEntityManager();

			$titulo = $_REQUEST['titulo'];

			if($seccion == 0){
				$Imagen = $em->find('Portal\PaginawebBundle\Entity\Introimagen', 1);
			} else if($seccion == 1){
				$Imagen = $em->find('Portal\PaginawebBundle\Entity\Introimagen', 2);
			} else if($seccion == 2){
				$Imagen = $em->find('Portal\PaginawebBundle\Entity\Introimagen', 3);
			} else if($seccion == 3){
				$Imagen = $em->find('Portal\PaginawebBundle\Entity\Introimagen', 4);
			} else if($seccion == 4){
				$Imagen = $em->find('Portal\PaginawebBundle\Entity\Introimagen', 5);
			}
			
			if($tipo == 'left'){
				$Imagen->setImagen1Nombre($nombre);
				$Imagen->setImagen1Titulo($titulo);
			} else if($tipo == 'up'){
				$Imagen->setImagen2Nombre($nombre);
				$Imagen->setImagen2Titulo($titulo);
			} else if($tipo == 'down'){
				$Imagen->setImagen3Nombre($nombre);
				$Imagen->setImagen3Titulo($titulo);
			}
			
			$em->persist($Imagen);
			$em->flush();
			
			if(!move_uploaded_file($temp, $destinoImagen.$nombre)){
				return new Response('Ocurrio un error. Recargue la página e intente de nuevo');
			}
			
			return new Response('true');
		}
		
	}
	
	public function cargandohojavidaAction(){
		return $this->render('PortalPaginawebBundle:Admin:cargandohojavida.html.twig');
	}
	
	public function addHojavidaAction(){
		
		$destinoDoc = $this->getUploadDocRootDir();		
		if(isset($_FILES['addHojavida'])){
		
			$nombre = $_FILES['addHojavida']['name'];
			$temp   = $_FILES['addHojavida']['tmp_name'];
			
			$nombre = str_replace(" ","_",$nombre);
			
			$em = $this->getDoctrine()->getEntityManager();
			$hojavida = $em->find('Portal\PaginawebBundle\Entity\Hojavida', 1);
			
			$hojavida->setHojavidaNombre($nombre);
			$em->persist($hojavida);
			$em->flush();
			
			if(!move_uploaded_file($temp, $destinoDoc.$nombre)){
				return new Response('Ocurrio un error. Recargue la página e intente de nuevo');
			}
			
			return new Response('true');
		} else {
			return new Response('Ocurrio un error inesperado. Recargue la página e intente de nuevo');
		}
	}
	
	public function cambiarContrasenaAction(){
		
		$formContrasena = $this->createForm(new CambiarContrasenaFormType());
		
		return $this->render('PortalPaginawebBundle:Admin:cambiarContrasena.html.twig', array(
					'formContrasena' => $formContrasena->createView()
		));
		
	}
	
}
