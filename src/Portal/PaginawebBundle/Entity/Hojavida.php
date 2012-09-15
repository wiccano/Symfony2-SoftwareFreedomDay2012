<?php

namespace Portal\PaginawebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

class Hojavida
{

    protected $hojavida_codigo;
	protected $hojavida_nombre;

    public function __construct()
    {
	
	}
    
    public function __toString()
    {
        return $this->hojavida_nombre;
    }

    public function getHojavidaCodigo()
    {
        return $this->hojavida_codigo;
    }

    public function setHojavidaCodigo($hojavida_codigo)
    {
        $this->hojavida_codigo = $hojavida_codigo;
    }
   
	public function getHojavidaNombre()
    {
        return $this->hojavida_nombre;
    }

    public function setHojavidaNombre($hojavida_nombre)
    {
        $this->hojavida_nombre = $hojavida_nombre;
    }
    
}