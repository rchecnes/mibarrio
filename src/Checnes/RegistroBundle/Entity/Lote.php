<?php

namespace Checnes\RegistroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lote
 *
 * @ORM\Table(name="lote")
 * @ORM\Entity(repositoryClass="Checnes\RegistroBundle\Repository\LoteRepository")
 */
class Lote
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
     * @ORM\Column(name="descripcion", type="text", nullable=true)
     */
    private $descripcion;

    /**
     * @var boolean
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado;

    /**
     * @ORM\OneToMany(targetEntity="Persona", mappedBy="cargo")
     */
    private $persona;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->persona = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Lote
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
     * @return Lote
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
     * @return Lote
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
     * Add persona
     *
     * @param \Checnes\RegistroBundle\Entity\Persona $persona
     *
     * @return Lote
     */
    public function addPersona(\Checnes\RegistroBundle\Entity\Persona $persona)
    {
        $this->persona[] = $persona;

        return $this;
    }

    /**
     * Remove persona
     *
     * @param \Checnes\RegistroBundle\Entity\Persona $persona
     */
    public function removePersona(\Checnes\RegistroBundle\Entity\Persona $persona)
    {
        $this->persona->removeElement($persona);
    }

    /**
     * Get persona
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPersona()
    {
        return $this->persona;
    }
}
