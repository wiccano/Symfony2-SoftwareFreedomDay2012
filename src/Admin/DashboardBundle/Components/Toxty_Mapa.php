<?php

namespace Admin\DashboardBundle\Components;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Admin\DashboardBundle\Form\Components\MapaFormType;
class Toxty_Mapa
{
	protected $container;
		
	private $id;
	private $width;
	private $measurement;
	private $height;
	private $zoom;
	private $contentheader;
	private $data;
	private $reloaded;
	private $paused;
	private $seconds;
	private $type;
	private $urlId;
	private $showreloadedbutton;
	private $showcombopoints;
	private $showcrumbs;
	private $headerinpopup;	
	private $parameters;
	
	public function __construct(ContainerInterface $container, $id)
    {
    	$this->container = $container;	
    	$this->id = $id;
		$this->width = '100';
		$this->measurement = '%';
		$this->height = '500';
		$this->showreloadedbutton = 1;
		$this->reloaded = 1;
		$this->seconds = 30; // 60
		$this->paused = 0;		
		$this->type = 'R'; //R:Ruta P:Puntos
		$this->showcombopoints = 1;
		$this->showcrumbs = 0;
		$this->headerinpopup = 1;
		$this->parameters = array();
	}

	/* showCombopoints */
	public function getShowcombopoints()
	{
        return $this->showcombopoints;
    }

	public function setShowcombopoints($bool)
	{
        $this->showcombopoints = $bool;
    }
	
	/* showCrumbs */
	public function getHeaderinpopup()
	{
        return $this->headerinpopup;
    }

	public function setHeaderinpopup($bool)
	{
        $this->headerinpopup = $bool;
    }
	
	/* showCrumbs */
	public function getShowcrumbs()
	{
        return $this->showcrumbs;
    }

	public function setShowcrumbs($bool)
	{
        $this->showcrumbs = $bool;
    }
	
	/* Parameters */
	public function getParameters()
	{       	
        return $this->parameters;
    }

	public function setParameters($parameters)
	{
        $serialize = serialize($parameters);
	    $this->parameters = urlencode($serialize);
    }
        
	/* Paused */
	public function getPaused()
	{
        return $this->paused;
    }

	public function setPaused($paused)
	{
        $this->paused = $paused;
    }
    
	/* Type */
	public function getType()
	{
        return $this->type;
    }

	public function setType($type)
	{
        $this->type = $type;
    }
	
	/* Url */
	public function getUrlId()
	{
        return $this->urlId;
    }

	public function setUrlId($urlId)
	{
        $this->urlId = $urlId;
    }
	
	/* Seconds */
	public function getSeconds()
	{
        return $this->seconds;
    }

	public function setSeconds($bool)
	{
        $this->seconds = $bool;
    }
    
	public function getMiliSeconds()
	{
        return $this->seconds*1000;
    }
    
	/* ShowReloadedButton */
	public function getShowReloadedButton()
	{
        return $this->showreloadedbutton;
    }

	public function setShowReloadedButton($bool)
	{
        $this->showreloadedbutton = $bool;
    }
	
	/* Reloaded */
	public function getReloaded()
	{
        return $this->reloaded;
    }

	public function setReloaded($bool)
	{
        $this->reloaded = $bool;
    }
		
	/* id */
	public function getId()
	{
        return $this->id;
    }

	/* Width */
	public function setWidth($width)
	{
        $this->width = $width;
    }
	
	public function getWidth()
	{
        return $this->width;
    }
	
	/* Measurement */
	public function setMeasurement($measurement)
	{
        $this->measurement = $measurement;
    }
	
	public function getMeasurement()
	{
        return $this->measurement;
    }
	
	/* Height */
	public function setHeight($height)
	{
        $this->height = $height;
    }
	
	public function getHeight()
	{
        return $this->height;
    }
		
	/* Header */
	public function setContentHeader($header)
	{
        $this->contentheader = $header;
    }
	
	public function getContentHeader()
	{
        return $this->contentheader;
    }
	
	/* Data */
	public function setData(array $data)
    {
        $this->data = $data;
    }
	
	public function getData()
    {
        return $this->data;
    }
		
	public function show()
    {
    	$engine = $this->container->get('templating');
		$options = array("type" => $this->getType(), 
						"reloaded" => $this->getReloaded(), 
						"pause" => $this->getPaused(), 
						"showcrumbs" => $this->getShowcrumbs(),
						"parameters" => $this->getParameters()
						);       
		$mapForm = $this->container->get('form.factory')->create(new MapaFormType(), $options); 						
		$content = $engine->render('AdminDashboardBundle:Components:mapa.html.twig', array(
			'mapa' => $this,
			'form' => $mapForm->createView(),
		));
		return $content;
	}	  
} 