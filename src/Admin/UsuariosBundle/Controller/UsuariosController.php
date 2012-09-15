<?php

namespace Admin\UsuariosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Symfony\Component\HttpFoundation\RedirectResponse; 
use Symfony\Component\Form\Form; 

use Admin\UsuariosBundle\Entity\Usuario,
	Admin\UsuariosBundle\Form\UsuarioFormType,
	Admin\UsuariosBundle\Entity\UsuarioRepository;

use Admin\DashboardBundle\Components\Toxty_Datagrid;

class UsuariosController extends Controller
{
    
    public function indexAction()
    {	
        return $this->render('AdminUsuariosBundle:Usuarios:index.html.twig', array('name' => 'OK'));
    }
	
    public function ejecutarCambioContrasenaAction()
    {
    	$request = $this->getRequest();
    	if ($request->isXmlHttpRequest() && 'POST' === $request->getMethod())
    	{
    		$form = $request->request->get('formCambiarContrasena');
    			
    		if(!trim($form['contrasena_actual'])){
    			return new Response("Debe digitar su actual contraseña");
    		}
    			
    		if(!trim($form['contrasena_nueva'])){
    			return new Response("Debe digitar una nueva contraseña");
    		}
    
    		if(trim($form['contrasena_nueva']) != trim($form['contrasena_repeated'])){
    			return new Response("La contraseña y su confirmacion no son iguales");
    		}
    			
    		$usuario = $this->container->get('security.context')->getToken()->getUser();
    		$passwd_anterior = $usuario->getPassword();
    			
    		$encoder = new MessageDigestPasswordEncoder('sha512', true, 10);
    		$passwd_actual = $encoder->encodePassword(trim($form['contrasena_actual']), $usuario->getSalt());
    			
    		if(trim($passwd_anterior) != trim($passwd_actual)){
    			return new Response("No coincide la contraseña actual");
    		}
    			
    		// Actualizo password usuario
    		$passwd_nuevo = $encoder->encodePassword($form['contrasena_nueva'], $usuario->getSalt());
    		$usuario->setPassword($passwd_nuevo);
    		$em = $this->getDoctrine()->getEntityManager();
    		$em->persist($usuario);
    		$em->flush();
    		return new Response("OK");
    	}
    	return new Response($this->get('translator')->trans('Ocurrio un error. Por favor comuniquese con los administradores del sistema'));
    }
    
    
    
    
	public function registroAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
			
        $form = new UsuarioFormType();
    	$form ->setTranslator($this->get('translator')); 
		$form = $this->createForm($form); 

		//$TDatagrid = $this->getGrid();
		return $this->render('AdminUsuariosBundle:Usuarios:registro.html.twig', array(
			'form' => $form->createView(),
			//'datagrid' => $TDatagrid  
		));
        
    }
	
	public function pageGridUsuarioAction()
	{
		$request = $this->getRequest();
		if ($request->isXmlHttpRequest() && 'POST' === $request->getMethod()) 
		{	
			$options = $request->request->get('Form_datagrid_usuarios');
			$TDatagrid = $this->get('admin_usuarios.usuarios')->getGridUsuarios($options);	
			return new Response($TDatagrid->show());
		}
		return new Response($this->get('translator')->trans('Ocurrio un error. Por favor comuniquese con los administradores del sistema'));	
	}
	
	public function deleteGridUsuarioAction()
	{
		$request = $this->getRequest();
        $em = $this->getDoctrine()->getEntityManager();
		
		//verificar usuario
		$usuario = $em->getRepository('AdminUsuariosBundle:Usuario')->findOneBy(array('usuario_codigo'=>$_POST['deletekey_gridUsuarios']));
		if(!is_object($usuario)){			
			return new Response($this->get('translator')->trans('Ocurrio un error al recuperar usuario. Comuniquese con el los administradores del sistema.'));
		}
		
		try
		{
			$em->remove($usuario);
			$em->flush();
			return new Response('OK');
		}catch(\PDOException $e){
				return new Response($e->getMessage());	
		}					
	}
	
	private function getErrorMessages(Form $form)
	{
	    $errors = '';	
	    foreach ($form->getErrors() as $key => $error) 
	    {
	        $errors .= strtr($this->get('translator')->trans($error->getMessageTemplate()), $error->getMessageParameters()).' <br/>';
	    }
	    if ($form->hasChildren()) {
	        foreach ($form->getChildren() as $child) {
	            if (!$child->isValid()) {
	        		$errors .= $this->get('translator')->trans($this->getErrorMessages($child)).' <br/>';     	
				}
	        }
	    }
	    return $errors;
	}

	public function addUsuarioAction()
	{
		$request = $this->getRequest();
        $em = $this->getDoctrine()->getEntityManager();
		
		if ('POST' === $request->getMethod()) 
		{		
			try
			{
				//verificar que esta cuenta no este creada
				$usuario = $em->getRepository('AdminUsuariosBundle:Usuario')->findOneBy(array('usuario_login'=>$_POST['formAddUsuario']['usuario_login']));
				if(is_object($usuario)){			
					return new Response($this->get('translator')->trans('Ya existe usuario con esta cuenta'));
				}
				

				$usuario = new Usuario();	
				$usuario->setUsuarioFechamodificacion(new \DateTime('now'));
				$encoder = new MessageDigestPasswordEncoder('sha512', true, 10);
				//se define un password automático
				$exp_reg="[^A-Z0-9]";
				$pass = substr(preg_replace($exp_reg, "", md5(rand())) . 
		       		preg_replace($exp_reg, "", md5(rand())) . 
		       		preg_replace($exp_reg, "", md5(rand())),        	
					0, 7
				);
				$password = $encoder->encodePassword($pass, $usuario->getSalt());
				$usuario->setPassword($password);
	
		        $form = new UsuarioFormType();
		    	$form ->setTranslator($this->get('translator')); 
				$form = $this->createForm($form); 
		        $form->setData($usuario);
				
				$form->bindRequest($request);
				
				if ($form->isValid()) 
				{
					$em->persist($usuario);	
					$em->flush();
					return new Response('OK');
				}else{
					return new Response($this->getErrorMessages($form));
				}
			}catch(\PDOException $e){
				return new Response($e->getMessage());	
			}
		}	
		return new Response($this->get('translator')->trans('Ocurrio un error. Por favor comuniquese con los administradores del sistema'));	
	}
}
