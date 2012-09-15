<?php

namespace Admin\SeguridadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Admin\SeguridadBundle\Form\LoginFormType;

class SeguridadController extends Controller
{
    
    public function indexAction() 
    { 
        return $this->render('AdminSeguridadBundle:Seguridad:index.html.twig');
    }

    public function loginAction() 
    { 
        if ($this->get('request')->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $this->get('request')->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $this->get('request')->getSession()->get(SecurityContext::AUTHENTICATION_ERROR);
        }
		
		$form = $this->createForm(new LoginFormType(array('last_username' => $this->get('request')->getSession()->get(SecurityContext::LAST_USERNAME))));
		return $this->render('PortalPaginawebBundle:Admin:login.html.twig', array(
            'form' => $form->createView(),
            'error'         => $error,
        ));
    }
	
	public function denegadoAction()
    {
        return $this->render('AdminUsuariosBundle:Usuario:denegado.html.twig');
    }
}


