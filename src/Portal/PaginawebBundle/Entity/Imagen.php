<?php

namespace Portal\PaginawebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

class Imagen
{

    protected $imagen_codigo;
	protected $producto_codigo;
    protected $imagen_texto;
    protected $imagen_nombre;
    protected $imagen_titulo;
   
    
    protected $file;

    public function __construct()
    {
	
	}
    
    public function __toString()
    {
        return $this->imagen_nombre;
    }

    public function getImagenCodigo()
    {
        return $this->imagen_codigo;
    }

    public function setImagenCodigo($imagen_codigo)
    {
        $this->imagen_codigo = $imagen_codigo;
    }
   
    public function getImagenNombre()
    {
    	return $this->imagen_nombre;
    }
    
    public function setImagenNombre($imagen_nombre)
    {
    	$this->imagen_nombre = $imagen_nombre;
    }
    
    public function getProductoCodigo()
    {
    	return $this->producto_codigo;
    }
    
    public function setProductoCodigo($producto_codigo)
    {
    	$this->producto_codigo = $producto_codigo;
    }
    
 	public function getImagenTexto()
    {
    	return $this->imagen_texto;
    }
    
    public function setImagenTexto($imagen_texto)
    {
    	$this->imagen_texto = $imagen_texto;
    }
    
    public function getImagenTitulo()
    {
    	return $this->imagen_titulo;
    }
    
    public function setImagenTitulo($imagen_titulo)
    {
    	$this->imagen_titulo = $imagen_titulo;
    }
    
    
    public function getFile()
    {
    	return $this->file;
    }
    
    public function setFile($file)
    {
    	$this->file = $file;
    }
    
}


