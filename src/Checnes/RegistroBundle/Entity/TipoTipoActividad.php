<?php

namespace Checnes\RegistroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TipoTipoActividad
 *
 * @ORM\Table(name="tipo_tipo_actividad")
 * @ORM\Entity(repositoryClass="Checnes\RegistroBundle\Repository\TipoTipoActividadRepository")
 */
class TipoTipoActividad
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
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean", options={"default":"1"})
     */
    private $activo;

    /**
     * @var bool
     *
     * @ORM\Column(name="estado", type="boolean", options={"default":"1"})
     */
    private $estado;

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
     * @ORM\OneToMany(targetEntity="TipoActividad", mappedBy="tipo_tipo_actividad")
     */
    private $tipo_actividad;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tipo_actividad = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
    
        return $this->getNombre();
    }

    

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
     * @return TipoTipoActividad
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
     * @return TipoTipoActividad
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
     * Set activo
     *
     * @param boolean $activo
     *
     * @return TipoTipoActividad
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
     * Set estado
     *
     * @param boolean $estado
     *
     * @return TipoTipoActividad
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return boolean
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return TipoTipoActividad
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
     * @return TipoTipoActividad
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
     * Add tipoActividad
     *
     * @param \Checnes\RegistroBundle\Entity\TipoActividad $tipoActividad
     *
     * @return TipoTipoActividad
     */
    public function addTipoActividad(\Checnes\RegistroBundle\Entity\TipoActividad $tipoActividad)
    {
        $this->tipo_actividad[] = $tipoActividad;

        return $this;
    }

    /**
     * Remove tipoActividad
     *
     * @param \Checnes\RegistroBundle\Entity\TipoActividad $tipoActividad
     */
    public function removeTipoActividad(\Checnes\RegistroBundle\Entity\TipoActividad $tipoActividad)
    {
        $this->tipo_actividad->removeElement($tipoActividad);
    }

    /**
     * Get tipoActividad
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTipoActividad()
    {
        return $this->tipo_actividad;
    }
}
