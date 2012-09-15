<?php

namespace Portal\PaginawebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

class Contacto
{

    protected $contacto_codigo;
	protected $contacto_email;
    protected $contacto_info;

    public function __construct()
    {
	
	}
    
    public function __toString()
    {
        return $this->getContactoCodigo();
    }

    public function getContactoCodigo()
    {
        return $this->contacto_codigo;
    }

    public function setContactoCodigo($contacto_codigo)
    {
        $this->contacto_codigo = $contacto_codigo;
    }

    
    public function getContactoEmail()
    {
    	return $this->contacto_email;
    }
    
    public function setContactoEmail($contacto_email)
    {
    	$this->contacto_email = $contacto_email;
    }
    
    public function getContactoInfo()
    {
    	return $this->contacto_info;
    }
    
    public function setContactoInfo($contacto_info)
    {
    	$this->contacto_info = $contacto_info;
    }
    
}