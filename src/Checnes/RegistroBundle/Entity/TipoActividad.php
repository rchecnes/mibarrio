<?php

namespace Checnes\RegistroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TipoActividad
 *
 * @ORM\Table(name="tipo_actividad")
 * @ORM\Entity(repositoryClass="Checnes\RegistroBundle\Repository\TipoActividadRepository")
 */
class TipoActividad
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
     * @ORM\Column(name="nombre", type="string", length=255, unique=true)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255, nullable=true)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_sistema", type="string", length=60, nullable=true)
     */
    private $nombre_sistema;

    /**
     * @var bool
     *
     * @ORM\Column(name="estado", type="boolean", options={"default":"1"}, nullable=true)
     */
    private $estado;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean", options={"default":"1"}, nullable=true)
     */
    private $activo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_creacion", type="datetime", nullable=true)
     */
    private $fecha_creacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_modificacion", type="datetime", nullable=true)
     */
    private $fecha_modificacion;

    /**
     * @ORM\ManyToOne(targetEntity="TipoTipoActividad", inversedBy="tipo_actividad")
     * @ORM\JoinColumn(name="tipo_tipo_actividad_id", referencedColumnName="id")
     */
    private $tipo_tipo_actividad;


    public function __toString()
    {
    
        return $this->getNombre();
    }

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
     * @return TipoActividad
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
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return TipoActividad
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set estado
     *
     * @param boolean $estado
     *
     * @return TipoActividad
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return bool
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set nombreSistema
     *
     * @param string $nombreSistema
     *
     * @return TipoActividad
     */
    public function setNombreSistema($nombreSistema)
    {
        $this->nombre_sistema = $nombreSistema;

        return $this;
    }

    /**
     * Get nombreSistema
     *
     * @return string
     */
    public function getNombreSistema()
    {
        return $this->nombre_sistema;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return TipoActividad
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
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return TipoActividad
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fecha_creacion = $fechaCreacion;

        return $this;
    }

    /**
     * Get fechaCreacion
     *
     * @return \DateTime
     */
    public function getFechaCreacion()
    {
        return $this->fecha_creacion;
    }

    /**
     * Set fechaModificacion
     *
     * @param \DateTime $fechaModificacion
     *
     * @return TipoActividad
     */
    public function setFechaModificacion($fechaModificacion)
    {
        $this->fecha_modificacion = $fechaModificacion;

        return $this;
    }

    /**
     * Get fechaModificacion
     *
     * @return \DateTime
     */
    public function getFechaModificacion()
    {
        return $this->fecha_modificacion;
    }

    /**
     * Set tipoTipoActividad
     *
     * @param \Checnes\RegistroBundle\Entity\TipoTipoActividad $tipoTipoActividad
     *
     * @return TipoActividad
     */
    public function setTipoTipoActividad(\Checnes\RegistroBundle\Entity\TipoTipoActividad $tipoTipoActividad = null)
    {
        $this->tipo_tipo_actividad = $tipoTipoActividad;

        return $this;
    }

    /**
     * Get tipoTipoActividad
     *
     * @return \Checnes\RegistroBundle\Entity\TipoTipoActividad
     */
    public function getTipoTipoActividad()
    {
        return $this->tipo_tipo_actividad;
    }
}
