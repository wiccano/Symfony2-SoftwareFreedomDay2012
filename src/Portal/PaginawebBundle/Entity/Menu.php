<?php

namespace Portal\PaginawebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

class Menu
{

    protected $menu_codigo;
	protected $menu_nombre;

    public function __construct()
    {
	
	}
    
    public function __toString()
    {
        return $this->menu_nombre;
    }

    public function getMenuCodigo()
    {
        return $this->menu_codigo;
    }

    public function setMenuCodigo($menu_codigo)
    {
        $this->menu_codigo = $menu_codigo;
    }
   
    public function getMenuNombre()
    {
    	return $this->menu_nombre;
    }
    
    public function setMenuNombre($menu_nombre)
    {
    	$this->menu_nombre = $menu_nombre;
    }
    
}