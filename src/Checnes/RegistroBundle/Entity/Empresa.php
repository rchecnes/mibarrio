<?php

namespace Checnes\RegistroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Empresa
 *
 * @ORM\Table(name="empresa")
 * @ORM\Entity(repositoryClass="Checnes\RegistroBundle\Repository\EmpresaRepository")
 */
class Empresa
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
     * @ORM\Column(name="ruc", type="string", length=20)
     */
    private $ruc;

    /**
     * @var bool
     *
     * @ORM\Column(name="condicion", type="boolean")
     */
    private $condicion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_registro", type="datetimetz")
     */
    private $fecha_registro;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_inicio", type="datetimetz")
     */
    private $fecha_inicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_fin", type="datetimetz")
     */
    private $fecha_fin;

    /**
     * Get id
     *
     * @return int
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
     * @return Empresa
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
     * Set ruc
     *
     * @param string $ruc
     *
     * @return Empresa
     */
    public function setRuc($ruc)
    {
        $this->ruc = $ruc;

        return $this;
    }

    /**
     * Get ruc
     *
     * @return string
     */
    public function getRuc()
    {
        return $this->ruc;
    }

    /**
     * Set condicion
     *
     * @param boolean $condicion
     *
     * @return Empresa
     */
    public function setCondicion($condicion)
    {
        $this->condicion = $condicion;

        return $this;
    }

    /**
     * Get condicion
     *
     * @return bool
     */
    public function getCondicion()
    {
        return $this->condicion;
    }

    /**
     * Set fechaRegistro
     *
     * @param \DateTime $fechaRegistro
     *
     * @return Empresa
     */
    public function setFechaRegistro($fechaRegistro)
    {
        $this->fecha_registro = $fechaRegistro;

        return $this;
    }

    /**
     * Get fechaRegistro
     *
     * @return \DateTime
     */
    public function getFechaRegistro()
    {
        return $this->fecha_registro;
    }

    /**
     * Set fechaInicio
     *
     * @param \DateTime $fechaInicio
     *
     * @return Empresa
     */
    public function setFechaInicio($fechaInicio)
    {
        $this->fecha_inicio = $fechaInicio;

        return $this;
    }

    /**
     * Get fechaInicio
     *
     * @return \DateTime
     */
    public function getFechaInicio()
    {
        return $this->fecha_inicio;
    }

    /**
     * Set fechaFin
     *
     * @param \DateTime $fechaFin
     *
     * @return Empresa
     */
    public function setFechaFin($fechaFin)
    {
        $this->fecha_fin = $fechaFin;

        return $this;
    }

    /**
     * Get fechaFin
     *
     * @return \DateTime
     */
    public function getFechaFin()
    {
        return $this->fecha_fin;
    }
}
