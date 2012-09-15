<?php

namespace Portal\PaginawebBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * CategoriaRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategoriaRepository extends EntityRepository
{
	public function findAllPaginated($page, $tamano, $paginable, $orderby, $orderdirection)
    {
    	
    }
    
    public function findAll()
    {
    	$em = $this->getEntityManager();
    	$qb = $em->createQueryBuilder();
    	$qb ->select('c');
    	$qb ->from('PortalPaginawebBundle:Categoria','c');
    	$qb ->leftJoin('c.menu_codigo', 'm');
    	$qb ->orderBy('m.menu_codigo, c.categoria_peso, c.categoria_nombre');
    	$query = $qb->getQuery();
    	
    	return $query->getResult();
    }
}