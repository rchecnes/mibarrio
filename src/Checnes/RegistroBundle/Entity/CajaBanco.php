<?php

namespace Checnes\RegistroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CajaBanco
 *
 * @ORM\Table(name="caja_banco")
 * @ORM\Entity(repositoryClass="Checnes\RegistroBundle\Repository\CajaBancoRepository")
 */
class CajaBanco
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
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="nro_cuenta", type="string", length=100)
     */
    private $nro_cuenta;

    /**
     * @var boolean
     *
     * @ORM\Column(name="caja_banco", type="boolean")
     */
    private $caja_banco;

    /**
     * @ORM\ManyToOne(targetEntity="Moneda", inversedBy="caja_banco")
     * @ORM\JoinColumn(name="moneda_id", referencedColumnName="id")
     */
    private $moneda;

    /**
     * @var string
     *
     * @ORM\Column(name="observacion", type="text")
     */
    private $observacion;

    /**
     * @var boolean
     *
     * @ORM\Column(name="activo", type="boolean", length=255, options={"default":"1"})
     */
    private $activo;



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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CajaBanco
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set nroCuenta
     *
     * @param string $nroCuenta
     *
     * @return CajaBanco
     */
    public function setNroCuenta($nroCuenta)
    {
        $this->nro_cuenta = $nroCuenta;

        return $this;
    }

    /**
     * Get nroCuenta
     *
     * @return string
     */
    public function getNroCuenta()
    {
        return $this->nro_cuenta;
    }

    /**
     * Set cajaBanco
     *
     * @param boolean $cajaBanco
     *
     * @return CajaBanco
     */
    public function setCajaBanco($cajaBanco)
    {
        $this->caja_banco = $cajaBanco;

        return $this;
    }

    /**
     * Get cajaBanco
     *
     * @return boolean
     */
    public function getCajaBanco()
    {
        return $this->caja_banco;
    }

    /**
     * Set observacion
     *
     * @param string $observacion
     *
     * @return CajaBanco
     */
    public function setObservacion($observacion)
    {
        $this->observacion = $observacion;

        return $this;
    }

    /**
     * Get observacion
     *
     * @return string
     */
    public function getObservacion()
    {
        return $this->observacion;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return CajaBanco
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set moneda
     *
     * @param \Checnes\RegistroBundle\Entity\Moneda $moneda
     *
     * @return CajaBanco
     */
    public function setMoneda(\Checnes\RegistroBundle\Entity\Moneda $moneda = null)
    {
        $this->moneda = $moneda;

        return $this;
    }

    /**
     * Get moneda
     *
     * @return \Checnes\RegistroBundle\Entity\Moneda
     */
    public function getMoneda()
    {
        return $this->moneda;
    }
}
