<?php

namespace Checnes\RegistroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ControlAcceso
 *
 * @ORM\Table(name="control_acceso")
 * @ORM\Entity(repositoryClass="Checnes\RegistroBundle\Repository\ControlAccesoRepository")
 */
class ControlAcceso
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_acceso", type="datetime")
     */
    private $fechaAcceso;

    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=30)
     */
    private $ip;

    /**
     * @var string
     *
     * @ORM\Column(name="anio", type="string", length=4)
     */
    private $anio;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="control_acceso")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     */
    private $usuario;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fechaAcceso
     *
     * @param \DateTime $fechaAcceso
     *
     * @return ControlAcceso
     */
    public function setFechaAcceso($fechaAcceso)
    {
        $this->fechaAcceso = $fechaAcceso;

        return $this;
    }

    /**
     * Get fechaAcceso
     *
     * @return \DateTime
     */
    public function getFechaAcceso()
    {
        return $this->fechaAcceso;
    }

    /**
     * Set ip
     *
     * @param string $ip
     *
     * @return ControlAcceso
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set anio
     *
     * @param string $anio
     *
     * @return ControlAcceso
     */
    public function setAnio($anio)
    {
        $this->anio = $anio;

        return $this;
    }

    /**
     * Get anio
     *
     * @return string
     */
    public function getAnio()
    {
        return $this->anio;
    }

    /**
     * Set usuario
     *
     * @param \Checnes\RegistroBundle\Entity\Usuario $usuario
     *
     * @return ControlAcceso
     */
    public function setUsuario(\Checnes\RegistroBundle\Entity\Usuario $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \Checnes\RegistroBundle\Entity\Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
}
