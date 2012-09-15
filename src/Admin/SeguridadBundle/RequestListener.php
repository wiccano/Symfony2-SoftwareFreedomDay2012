<?php

// src/Acme/DemoBundle/RequestListener.php
namespace Admin\SeguridadBundle;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;

class RequestListener
{
	private $router;

	public function __construct(\Symfony\Component\Routing\Router $router) {
    	$this->router = $router;
    }
	
    public function onKernelRequest(GetResponseEvent $event) 
    {
		$request = $event->getRequest();
        $session = $request->getSession();
		echo "<br/> ".$path = $request->getPathInfo();
		echo "<br/> ".$path = $request->getUriForPath($path);	
	    if ('/' === $path[0]) {
            $path = $request->getUriForPath($path);
        } elseif (0 !== strpos($path, 'http')) {
            $this->resetLocale($request);
            $path = $this->generateUrl($path, true);
        }
        return new RedirectResponse($path);
		
		/*$locale ="en";	
					
		$session->setLocale($locale);
	
	    //$event->setResponse(new RedirectResponse($this->router->generate('login_check')));
	    //return ($this->redirect($this->generateUrl($last_route['name'], $last_route['params'])));/*/
	}
}

	