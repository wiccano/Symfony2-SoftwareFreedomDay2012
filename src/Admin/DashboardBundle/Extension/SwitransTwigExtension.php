<?php

namespace Admin\DashboardBundle\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;

class SwitransTwigExtension extends \Twig_Extension
{
    private $container;
	
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;   
    }        

    public function getContainer()   
    {       
        return $this->container;   
    }         
	   
    public function getFunctions()
    {
        return array(
            'translate' => new \Twig_Function_Method($this, 'translate'),
            'utf8_encoding' => new \Twig_Function_Method($this, 'utf8_encoding'),
            'banderaespanollink' => new \Twig_Function_Method($this, 'banderaespanollink'),
            'banderaingleslink' => new \Twig_Function_Method($this, 'banderaingleslink'),
        	'textBook' => new \Twig_Function_Method($this, 'textBook'),
        );
    }

	/*
	 * Funciones Twig principales para Switrans2
	 */
	public function translate ($text, $options = array(), $domain = 'messages')
    {
        return $this->container->get('translator')->trans($text, $options, $domain);
    }
	
	public function utf8_encoding($text)
	{
		return utf8_encode($text);
	}
	
	public function getName()
    {       
        return 'switrans_extensions';
    }
	
    public function textBook($texto){
    	return nl2br($texto);
    }
    
	public function banderaespanollink()
    {    
		$request = $this->container->get('request');
		$locale = $request->get('_locale');
		
		$url_actual = $_SERVER["REQUEST_URI"];
		$href = NULL;
		if($locale == 'en'){
			$href = str_replace('/en', '/es', $url_actual);
		}
		return $href;
	}
    
    public function banderaingleslink()
    {    
		$request = $this->container->get('request');
		$locale = $request->get('_locale');
		
		$url_actual = $_SERVER["REQUEST_URI"];
		$href = NULL;
		if($locale == 'es'){
			$href = str_replace('/es', '/en', $url_actual);
		}
		return $href;
    }
    

}