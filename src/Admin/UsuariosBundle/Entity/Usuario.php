<?php

namespace Admin\UsuariosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

class Usuario implements AdvancedUserInterface, \Serializable
{

    protected $usuario_codigo;
	protected $usuario_login;
    protected $usuario_nombre;
    protected $usuario_clave;
    protected $usuario_email;
    protected $usuario_activo;
    protected $usuario_fechacreacion; 
    protected $usuario_fechamodificacion;
	
	
	private $usuarioRoles;

    public function __construct()
    {
		$this->usuario_activo = true;
		$this->usuario_fechacreacion = new \DateTime();
		$this->usuarioRoles = new \Doctrine\Common\Collections\ArrayCollection();	
	}
    
    public function __toString()
    {
        return $this->getUsuarioLogin();
    }

    public function getUsuarioCodigo()
    {
        return $this->usuario_codigo;
    }

    public function setUsuarioLogin($usuario_login)
    {
        $this->usuario_login = $usuario_login;
    }

    public function getUsuarioLogin()
    {
        return $this->usuario_login;
    }
	
    public function setUsuarioNombre($usuario_nombre)
    {
        $this->usuario_nombre = $usuario_nombre;
	}

    public function getUsuarioNombre()
    {
        return $this->usuario_nombre;
    }

    public function setEstadoCodigo($estado_codigo)
    {
        $this->estado_codigo = $estado_codigo;
	}

    public function getEstadoCodigo() 
    {
        return $this->estado_codigo;
    }

    public function setUsuarioEmail($usuario_email)
    {
        $this->usuario_email = $usuario_email;
    }

    public function getUsuarioEmail()
    {
        return $this->usuario_email;
    }

    public function setUsuarioActivo($usuario_activo)
    {
        $this->usuario_activo = $usuario_activo;
    }

    public function getUsuarioActivo()
    {
        return $this->usuario_activo;
    }
	 
    public function setUsuarioFechacreacion($usuario_fechacreacion)
    {
        $this->usuario_fechacreacion = $usuario_fechacreacion;
    }

    public function getUsuarioFechacreacion()
    {
        return $this->usuario_fechacreacion;
    }

    public function setUsuarioFechamodificacion($usuario_fechamodificacion)
    {
        $this->usuario_fechamodificacion = $usuario_fechamodificacion;
    }

    public function getUsuarioFechamodificacion()
    {
        return $this->usuario_fechamodificacion;
    }

    public function setPassword($usuario_clave)
    {
        $this->usuario_clave = $usuario_clave;
    }

    public function getPassword()
    {
        return $this->usuario_clave;
    }
	/**
     * Gets the user roles.
     *
     * @return ArrayCollection A Doctrine ArrayCollection
    */
    public function getUsuarioRoles()
    {
        return $this->usuarioRoles;
    }
		
	/*
	* Implementation of UserInterface
	*/

    public function getRoles()
    {
        return $this->getUsuarioRoles()->toArray();
    }

    public function getSalt()
    {
        return false;
    }

    public function getUsername()
    {
        return $this->usuario_login;
    }

    public function eraseCredentials()
    {

    }

    public function equals(UserInterface $user)
    {
        return $user->getUsername() == $this->getUsername();
    }
		
	public function serialize()
    {
    	return serialize( array( $this->getUsuarioCodigo(),$this->getUsuarioLogin() ));
    } 
	
	public function unserialize($serialized)
	{
		list($this->usuario_codigo, $this->usuario_login) = unserialize($serialized);
	
	} 
	
	/*
	* Implementation of AdvancedUserInterface
	*/
    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
    	return $this->usuario_activo;
	}
}