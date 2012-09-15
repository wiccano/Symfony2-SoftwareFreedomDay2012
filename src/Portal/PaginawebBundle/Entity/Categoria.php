<?php

namespace Portal\PaginawebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

class Categoria
{

    private $categoria_codigo;
	private $categoria_nombre;
    private $categoria_descripcion;
    private $categoria_peso;
    
    private $menu_codigo; 
    private $productos;

    public function __construct()
    {
	
	}
    
    public function __toString()
    {
        return $this->categoria_nombre;
    }

    public function getCategoriaCodigo()
    {
        return $this->categoria_codigo;
    }

    public function setCategoriaCodigo($categoria_codigo)
    {
        $this->categoria_codigo = $categoria_codigo;
    }
   
    public function getCategoriaNombre()
    {
    	return $this->categoria_nombre;
    }
    
    public function setCategoriaNombre($categoria_nombre)
    {
    	$this->categoria_nombre = $categoria_nombre;
    }
    
    public function getCategoriaDescripcion()
    {
    	return $this->categoria_descripcion;
    }
    
    public function setCategoriaDescripcion($categoria_descripcion)
    {
    	$this->categoria_descripcion = $categoria_descripcion;
    }
    
    public function getCategoriaPeso()
    {
    	return $this->categoria_peso;
    }
    
    public function setCategoriaPeso($categoria_peso)
    {
    	$this->categoria_peso = $categoria_peso;
    }
    
    public function getMenuCodigo()
    {
    	return $this->menu_codigo;
    }
    
    public function setMenuCodigo($menu_codigo)
    {
    	$this->menu_codigo = $menu_codigo;
    }
    
    public function getProductos()
    {
    	return $this->productos;
    }
    
}


