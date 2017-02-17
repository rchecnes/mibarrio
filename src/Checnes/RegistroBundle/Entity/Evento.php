<?php

namespace Checnes\RegistroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Evento
 *
 * @ORM\Table(name="evento")
 * @ORM\Entity(repositoryClass="Checnes\RegistroBundle\Repository\EventoRepository")
 */
class Evento
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
     * @ORM\Column(name="tipo", type="string", length=255)
     */
    private $tipo;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_persona", type="string", length=255)
     */
    private $tipo_persona;

    /**
     * @var string
     *
     * @ORM\Column(name="condicion", type="string", length=50)
     */
    private $condicion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_inicio", type="datetimetz")
     */
    private $fecha_inicio;

    /**
     * @var string
     *
     * @ORM\Column(name="hora_inicio", type="string", nullable=true)
     */
    private $hora_inicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_fin", type="datetimetz")
     */
    private $fecha_fin;

    /**
     * @var string
     *
     * @ORM\Column(name="hora_final", type="string", nullable=true)
     */
    private $hora_final;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_creacion", type="datetimetz")
     */
    private $fecha_creacion;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text", nullable=true)
     */
    private $descripcion;
    
    /**
     * @var bool
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado;

    /**
     * @ORM\OneToMany(targetEntity="AsistenciaEvento", mappedBy="evento")
     */
    private $asistencia_evento;

    /**
     * @ORM\ManyToOne(targetEntity="Ano", inversedBy="evento")
     * @ORM\JoinColumn(name="ano_id", referencedColumnName="id")
     */
    private $ano;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="evento")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     */
    private $usuario;

    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->asistencia_evento = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Evento
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
     * Set tipo
     *
     * @param string $tipo
     *
     * @return Evento
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set condicion
     *
     * @param string $condicion
     *
     * @return Evento
     */
    public function setCondicion($condicion)
    {
        $this->condicion = $condicion;

        return $this;
    }

    /**
     * Get condicion
     *
     * @return string
     */
    public function getCondicion()
    {
        return $this->condicion;
    }

    /**
     * Set fechaInicio
     *
     * @param \DateTime $fechaInicio
     *
     * @return Evento
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
     * Set horaInicio
     *
     * @param string $horaInicio
     *
     * @return Evento
     */
    public function setHoraInicio($horaInicio)
    {
        $this->hora_inicio = $horaInicio;

        return $this;
    }

    /**
     * Get horaInicio
     *
     * @return string
     */
    public function getHoraInicio()
    {
        return $this->hora_inicio;
    }

    /**
     * Set fechaFin
     *
     * @param \DateTime $fechaFin
     *
     * @return Evento
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

    /**
     * Set horaFinal
     *
     * @param string $horaFinal
     *
     * @return Evento
     */
    public function setHoraFinal($horaFinal)
    {
        $this->hora_final = $horaFinal;

        return $this;
    }

    /**
     * Get horaFinal
     *
     * @return string
     */
    public function getHoraFinal()
    {
        return $this->hora_final;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return Evento
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
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Evento
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
     * @return Evento
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
     * Add asistenciaEvento
     *
     * @param \Checnes\RegistroBundle\Entity\AsistenciaEvento $asistenciaEvento
     *
     * @return Evento
     */
    public function addAsistenciaEvento(\Checnes\RegistroBundle\Entity\AsistenciaEvento $asistenciaEvento)
    {
        $this->asistencia_evento[] = $asistenciaEvento;

        return $this;
    }

    /**
     * Remove asistenciaEvento
     *
     * @param \Checnes\RegistroBundle\Entity\AsistenciaEvento $asistenciaEvento
     */
    public function removeAsistenciaEvento(\Checnes\RegistroBundle\Entity\AsistenciaEvento $asistenciaEvento)
    {
        $this->asistencia_evento->removeElement($asistenciaEvento);
    }

    /**
     * Get asistenciaEvento
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAsistenciaEvento()
    {
        return $this->asistencia_evento;
    }

    /**
     * Set ano
     *
     * @param \Checnes\RegistroBundle\Entity\Ano $ano
     *
     * @return Evento
     */
    public function setAno(\Checnes\RegistroBundle\Entity\Ano $ano = null)
    {
        $this->ano = $ano;

        return $this;
    }

    /**
     * Get ano
     *
     * @return \Checnes\RegistroBundle\Entity\Ano
     */
    public function getAno()
    {
        return $this->ano;
    }

    /**
     * Set usuario
     *
     * @param \Checnes\RegistroBundle\Entity\Usuario $usuario
     *
     * @return Evento
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

    /**
     * Set tipoPersona
     *
     * @param string $tipoPersona
     *
     * @return Evento
     */
    public function setTipoPersona($tipoPersona)
    {
        $this->tipo_persona = $tipoPersona;

        return $this;
    }

    /**
     * Get tipoPersona
     *
     * @return string
     */
    public function getTipoPersona()
    {
        return $this->tipo_persona;
    }
}
