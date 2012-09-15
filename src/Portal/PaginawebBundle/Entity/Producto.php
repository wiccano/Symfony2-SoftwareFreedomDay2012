<?php

namespace Portal\PaginawebBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;

class Producto
{

    private $producto_codigo;
    private $producto_nombre;
    private $producto_descripcion;
    private $producto_peso;
    private $producto_fechacreacion;
    private $producto_fechamodificacion;
    
    
    private $imagenes;
    private $categoria_codigo;

    public function __construct()
    {
    	$this->imagenes = new ArrayCollection();
	}    
    
    public function __toString()
    {
        return $this->getProductoCodigo();
    }
    
    public function getProductoCodigo()
    {
        return $this->producto_codigo;
    }

    public function setProductoCodigo($producto_codigo)
    {
        $this->producto_codigo = $producto_codigo;
    }

    public function getCategoriaCodigo()
    {
    	return $this->categoria_codigo;
    }
    
    public function setCategoriaCodigo($categoria_codigo)
    {
    	$this->categoria_codigo = $categoria_codigo;
    }
      
    public function getProductoNombre()
    {
    	return $this->producto_nombre;
    }
    
    public function setProductoNombre($producto_nombre)
    {
    	$this->producto_nombre = $producto_nombre;
    }
    
    public function getProductoDescripcion()
    {
    	return $this->producto_descripcion;
    }
    
    public function setProductoDescripcion($producto_descripcion)
    {
    	$this->producto_descripcion = $producto_descripcion;
    }
    
    public function getProductoPeso()
    {
    	return $this->producto_peso;
    }
    
    public function setProductoPeso($producto_peso)
    {
    	$this->producto_peso = $producto_peso;
    }
        
    public function getProductoFechacreacion()
    {
    	return $this->producto_fechacreacion;
    }
    
    public function setProductoFechacreacion($producto_fechacreacion)
    {
    	$this->producto_fechacreacion = $producto_fechacreacion;
    }
    
    public function getProductoFechamodificacion()
    {
    	return $this->producto_fechamodificacion;
    }
    
    public function setProductoFechamodificacion($producto_fechamodificacion)
    {
    	$this->producto_fechamodificacion = $producto_fechamodificacion;
    }
    
    public function getImagenes(){
    	return $this->imagenes;
    }
    
}