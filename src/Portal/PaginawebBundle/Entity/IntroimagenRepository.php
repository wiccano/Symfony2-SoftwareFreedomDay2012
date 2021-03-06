<?php

namespace Portal\PaginawebBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * UsuarioRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class IntroimagenRepository extends EntityRepository
{
	public function findXNombre($seccion, $nombre) {
		$em = $this->getEntityManager();
		$qb = $em->createQueryBuilder();
		$qb ->select('i');
		$qb ->from('PortalPaginawebBundle:Introimagen','i');
		
		if($seccion > 0)
			$qb->where('i.imagen_codigo = '.$seccion);
		else
			$qb->where('i.imagen_codigo = NULL ');
		
		$qb->where("i.imagen1_nombre = '".$nombre."' OR i.imagen2_nombre = '".$nombre."' OR i.imagen3_nombre = '".$nombre."'");
		
		$query = $qb->getQuery();
		$imagen = $query->getResult();
		
		return $imagen;
	}
}
