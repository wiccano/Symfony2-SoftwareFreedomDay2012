<?php

namespace Admin\UsuariosBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\Connection;

use Admin\DashboardBundle\Components\ToxtyDatagridComponents;
 
Class UsuariosService{  
    	
    private $container;	
	private $em;
		
    public function __construct(ContainerInterface $container, EntityManager $em)
    {
		$this->container = $container;
		$this->em =	$em;
	}
	
    public function getGridUsuarios(array $options = NULL) 
    {		
		$TDatagrid = new ToxtyDatagridComponents($this->container, $options);		
		$TDatagrid->setUrl("AdminUsuarios_pageGridUsuarios");
		
		$arUsuarios = $this->em->getRepository('AdminUsuariosBundle:Usuario')->findAllPaginated($TDatagrid->getParamsSql());
		$countUsuarios = $this->em->getRepository('AdminUsuariosBundle:Usuario')->findCountAll();
		$headers = array( 
			'usuario_codigo' => array('text' => 'Codigo', 'align' => 'center'),
	    	'usuario_nombre' => array('text' => 'Nombre'),
	    	'usuario_login' => array('text' => 'Cuenta de usuario'),
	    	'usuario_email' => array('text' => 'Correo electrónico')
		); 
		
		$TDatagrid->setData($arUsuarios);
		$TDatagrid->setHeaders($headers);
		$TDatagrid->setGridCount($countUsuarios);
		return $TDatagrid;
	}  
}