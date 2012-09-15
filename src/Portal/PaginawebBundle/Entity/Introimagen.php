<?php

namespace Portal\PaginawebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

class Introimagen
{

    protected $imagen_codigo;
    protected $imagen1_nombre;
    protected $imagen1_titulo;
    protected $imagen2_nombre;
    protected $imagen2_titulo;
    protected $imagen3_nombre;
    protected $imagen3_titulo;
    protected $menu_codigo;
   

    public function __construct()
    {
	
	}
    
    public function __toString()
    {
        return $this->imagen1_nombre;
    }

    public function getImagenCodigo()
    {
        return $this->imagen_codigo;
    }

    public function setImagenCodigo($imagen_codigo)
    {
        $this->imagen_codigo = $imagen_codigo;
    }
    
    
   
    
    
    public function getImagen1Nombre()
    {
    	return $this->imagen1_nombre;
    }
    
    public function setImagen1Nombre($imagen1_nombre)
    {
    	$this->imagen1_nombre = $imagen1_nombre;
    }
    
    public function getImagen1Titulo()
    {
    	return $this->imagen1_titulo;
    }
    
    public function setImagen1Titulo($imagen1_titulo)
    {
    	$this->imagen1_titulo = $imagen1_titulo;
    }    
    
    
    
    
    
    public function getImagen2Nombre()
    {
    	return $this->imagen2_nombre;
    }
    
    public function setImagen2Nombre($imagen2_nombre)
    {
    	$this->imagen2_nombre = $imagen2_nombre;
    }
    
    public function getImagen2Titulo()
    {
    	return $this->imagen2_titulo;
    }
    
    public function setImagen2Titulo($imagen2_titulo)
    {
    	$this->imagen2_titulo = $imagen2_titulo;
    }
    
    
    
    
    public function getImagen3Nombre()
    {
    	return $this->imagen3_nombre;
    }
    
    public function setImagen3Nombre($imagen3_nombre)
    {
    	$this->imagen3_nombre = $imagen3_nombre;
    }
    
    public function getImagen3Titulo()
    {
    	return $this->imagen3_titulo;
    }
    
    public function setImagen3Titulo($imagen3_titulo)
    {
    	$this->imagen3_titulo = $imagen3_titulo;
    }
    
    
    
    
    public function getMenuCodigo()
    {
    	return $this->menu_codigo;
    }
    
    public function setMenuCodigo($menu_codigo)
    {
    	$this->menu_codigo = $menu_codigo;
    }

}