<?php

namespace Portal\PaginawebBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * UsuarioRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ImagenRepository extends EntityRepository
{
	public function findAllPaginated($page, $tamano, $paginable, $orderby, $orderdirection)
    {
    	$Iniregister=($page-1)*$tamano;
		if ($Iniregister<0)$Iniregister=0;
		
    	$em = $this->getEntityManager();
    	$qb = $em->createQueryBuilder();
		$qb ->select('u.usuario_codigo, u.usuario_nombre, u.usuario_login, u.usuario_email, u.usuario_fechacreacion');
		$qb ->from('AdminUsuariosBundle:Usuario','u');
		
		if($orderby && $orderdirection) 
			$qb ->orderBy("u.$orderby", $orderdirection);
		else 
			$qb ->orderBy('u.usuario_codigo');
		
		$query = $qb->getQuery();
		if($paginable){  
			$query ->setFirstResult($Iniregister);
			$query ->setMaxResults($tamano);
		}
		
		$usuarios = $query->getArrayResult();			
        return $usuarios;
    }
    
    public function findAll()
    {
    	$em = $this->getEntityManager();
    	$qb = $em->createQueryBuilder();
    	$qb ->select('c');
    	$qb ->from('PortalPaginawebBundle:Imagen','c');
    	$query = $qb->getQuery();
    	
    	return $query->getArrayResult();
    }
    
    public function findByAlt($producto_codigo)
    {
    	$em = $this->getEntityManager();
    	$qb = $em->createQueryBuilder();
    	$qb ->select('c');
    	$qb ->from('PortalPaginawebBundle:Imagen','c');
    	$qb->where('c.producto_codigo = '.$producto_codigo);
    	$qb ->orderBy('c.imagen_codigo');
    	$query = $qb->getQuery();
    	 
    	return $query->getResult();
    }
}