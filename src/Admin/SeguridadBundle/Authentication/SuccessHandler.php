<?php

namespace Admin\SeguridadBundle\Authentication;

use Symfony\Component\Routing\RouterInterface,
	Symfony\Component\HttpFoundation\RedirectResponse,
    Symfony\Component\HttpFoundation\Request,
    Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface,
    Symfony\Component\Security\Core\Authentication\Token\TokenInterface,
    Symfony\Component\DependencyInjection\ContainerInterface,
   	Symfony\Component\HttpFoundation\Session,
    Doctrine\ORM\EntityManager;

class SuccessHandler implements AuthenticationSuccessHandlerInterface
{
   protected $router;
   protected $container;
   protected $session;
   
   public function __construct(ContainerInterface $container, RouterInterface $router, Session $session)
   {
       $this->container = $container;	
       $this->router = $router;   
	   $this->session = $session;
   }
  
   public function onAuthenticationSuccess(Request $request, TokenInterface $token)
   {
		// Insert here you code	
		return new RedirectResponse($this->router->generate('login_check'));
   } 
}