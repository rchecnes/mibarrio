<?php

namespace Checnes\RegistroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AsistenciaEvento
 *
 * @ORM\Table(name="asistencia_evento")
 * @ORM\Entity(repositoryClass="Checnes\RegistroBundle\Repository\AsistenciaEventoRepository")
 */
class AsistenciaEvento
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
     * @ORM\Column(name="fecha_creacion", type="datetimetz")
     */
    private $fecha_creacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_modificacion", type="datetimetz")
     */
    private $fecha_modificacion;

    /**
     * @var bool
     *
     * @ORM\Column(name="asistio", type="boolean")
     */
    private $asistio;

    /**
     * @var bool
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado;

    /**
     * @ORM\ManyToOne(targetEntity="Evento", inversedBy="asistencia_evento")
     * @ORM\JoinColumn(name="evento_id", referencedColumnName="id")
     */
    private $evento;

    /**
     * @ORM\ManyToOne(targetEntity="Persona", inversedBy="asistencia_evento")
     * @ORM\JoinColumn(name="persona_id", referencedColumnName="id")
     */
    private $persona;

    
    /**
     * @var string
     *
     * @ORM\Column(name="anio", type="string", length=4)
     */
    private $anio;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="asistencia_evento")
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
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return AsistenciaEvento
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
     * @return AsistenciaEvento
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
     * Set asistio
     *
     * @param boolean $asistio
     *
     * @return AsistenciaEvento
     */
    public function setAsistio($asistio)
    {
        $this->asistio = $asistio;

        return $this;
    }

    /**
     * Get asistio
     *
     * @return boolean
     */
    public function getAsistio()
    {
        return $this->asistio;
    }

    /**
     * Set estado
     *
     * @param boolean $estado
     *
     * @return AsistenciaEvento
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
     * Set anio
     *
     * @param string $anio
     *
     * @return AsistenciaEvento
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
     * Set evento
     *
     * @param \Checnes\RegistroBundle\Entity\Evento $evento
     *
     * @return AsistenciaEvento
     */
    public function setEvento(\Checnes\RegistroBundle\Entity\Evento $evento = null)
    {
        $this->evento = $evento;

        return $this;
    }

    /**
     * Get evento
     *
     * @return \Checnes\RegistroBundle\Entity\Evento
     */
    public function getEvento()
    {
        return $this->evento;
    }

    /**
     * Set persona
     *
     * @param \Checnes\RegistroBundle\Entity\Persona $persona
     *
     * @return AsistenciaEvento
     */
    public function setPersona(\Checnes\RegistroBundle\Entity\Persona $persona = null)
    {
        $this->persona = $persona;

        return $this;
    }

    /**
     * Get persona
     *
     * @return \Checnes\RegistroBundle\Entity\Persona
     */
    public function getPersona()
    {
        return $this->persona;
    }

    /**
     * Set usuario
     *
     * @param \Checnes\RegistroBundle\Entity\Usuario $usuario
     *
     * @return AsistenciaEvento
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
