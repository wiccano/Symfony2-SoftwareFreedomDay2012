<?php

namespace Admin\UsuariosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Admin\UsuariosBundle\Entity\UsuarioCliente
 */
class UsuarioCliente
{
    /**
     * @var bigint $cliente_codigo
     */
    private $cliente_codigo;

    /**
     * @var Admin\UsuariosBundle\Entity\Usuario
     */
    private $usuario_codigo;


    /**
     * Set cliente_codigo
     *
     * @param bigint $clienteCodigo
     */
    public function setClienteCodigo($clienteCodigo)
    {
        $this->cliente_codigo = $clienteCodigo;
    }

    /**
     * Get cliente_codigo
     *
     * @return bigint 
     */
    public function getClienteCodigo()
    {
        return $this->cliente_codigo;
    }

    /**
     * Set usuario_codigo
     *
     * @param Admin\UsuariosBundle\Entity\Usuario $usuarioCodigo
     */
    public function setUsuarioCodigo(\Admin\UsuariosBundle\Entity\Usuario $usuarioCodigo)
    {
        $this->usuario_codigo = $usuarioCodigo;
    }

    /**
     * Get usuario_codigo
     *
     * @return Admin\UsuariosBundle\Entity\Usuario 
     */
    public function getUsuarioCodigo()
    {
        return $this->usuario_codigo;
    }
}