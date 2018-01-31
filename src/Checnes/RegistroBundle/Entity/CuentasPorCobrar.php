<?php

namespace Checnes\RegistroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CuentasPorCobrar
 *
 * @ORM\Table(name="cuentas_por_cobrar")
 * @ORM\Entity(repositoryClass="Checnes\RegistroBundle\Repository\CuentasPorCobrarRepository")
 */
class CuentasPorCobrar
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
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @var string
     *
     * @ORM\Column(name="evento", type="string", length=255)
     */
    private $evento;

    /**
     * @var string
     *
     * @ORM\Column(name="persona", type="string", length=255)
     */
    private $persona;

    /**
     * @var string
     *
     * @ORM\Column(name="fecha_creacion", type="string", length=255)
     */
    private $fecha_creacion;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=255)
     */
    private $estado;


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
     * Set activo
     *
     * @param boolean $activo
     *
     * @return CuentasPorCobrar
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return bool
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set evento
     *
     * @param string $evento
     *
     * @return CuentasPorCobrar
     */
    public function setEvento($evento)
    {
        $this->evento = $evento;

        return $this;
    }

    /**
     * Get evento
     *
     * @return string
     */
    public function getEvento()
    {
        return $this->evento;
    }

    /**
     * Set persona
     *
     * @param string $persona
     *
     * @return CuentasPorCobrar
     */
    public function setPersona($persona)
    {
        $this->persona = $persona;

        return $this;
    }

    /**
     * Get persona
     *
     * @return string
     */
    public function getPersona()
    {
        return $this->persona;
    }

    /**
     * Set fechaCreacion
     *
     * @param string $fechaCreacion
     *
     * @return CuentasPorCobrar
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }

    /**
     * Get fechaCreacion
     *
     * @return string
     */
    public function getFechaCreacion()
    {
        return $this->fechaCreacion;
    }

    /**
     * Set estado
     *
     * @param string $estado
     *
     * @return CuentasPorCobrar
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }
}
