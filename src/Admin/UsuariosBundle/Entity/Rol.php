<?php

namespace Admin\UsuariosBundle\Entity;
Use Symfony\Component\Security\Core\Role\RoleInterface;
use Doctrine\ORM\Mapping as ORM;

class Rol implements RoleInterface
{

    protected $rol_codigo;
    protected $rol_nombre;
 	protected $rol_fechacreacion;
	
	protected $rolUsuarios;
	
	public function __construct()
    {
        $this->rolUsuarios = new \Doctrine\Common\Collections\ArrayCollection();
		$this->rol_fechacreacion = new \DateTime();
    }
	
    public function __toString()
    {
        return $this->getRolNombre();
    }

    public function getRolCodigo()
    {
        return $this->rol_codigo;
    }

    public function setRolNombre($rol_nombre)
    {
        $this->rol_nombre = $rol_nombre;
    }

    public function getRolNombre()
    {
        return $this->rol_nombre;
    }
	
    public function getRolFechacreacion()
    {
        return $this->rol_fechacreacion;
    }

	/**
     * Implementation of getRole for the RoleInterface.
     * 
     * @return string The role.
     */
    public function getRole()
    {
        return $this->getRolNombre();
    }
	
}