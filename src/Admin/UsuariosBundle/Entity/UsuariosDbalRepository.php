<?php

namespace Admin\UsuariosBundle\Entity;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\DBAL\Connection;

class UsuariosDbalRepository 
{
	private $db;
	private $container;	
	
	public function __construct(Connection $dbalConnection, ContainerInterface $container)
    {
    	$this->db =	$dbalConnection;
		$this->container = $container;
	}
	
	public function getIsAdministrador(array $options = NULL) 
    {
		$isAdministrador = false;	
		if(isset($options['usuarioCodigo']) && $options['usuarioCodigo'])
		{	 
			$sql = "SELECT area_codigo " . 
				" FROM tb_usuario " .
				" WHERE usuario_codigo = {$options['usuarioCodigo']} AND area_codigo != 6 AND estado_codigo IN (22)";
			$arUsuario = $this->db->fetchAssoc($sql);
			
			if( isset($arUsuario['area_codigo']) )
			{
				if( $arUsuario['area_codigo'] == 5)
				{
					$isAdministrador = true;	
				}	
			}
		}
		return $isAdministrador;	
	}	 
}