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
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text", nullable=true)
     */
    private $descripcion;

    /**
     * @var boolean
     *
     * @ORM\Column(name="multa", type="boolean", nullable=true, options={"default":"0"})
     */
    private $multa;

    /**
     * @var float
     *
     * @ORM\Column(name="monto_multa", type="float", nullable=true, options={"default":"0"})
     */
    private $monto_multa;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado;

    /**
     * @ORM\OneToMany(targetEntity="AsistenciaEvento", mappedBy="evento")
     */
    private $asistencia_evento;

    /**
     * @var string
     *
     * @ORM\Column(name="asunto", type="string", nullable=false, length=255)
     */
    private $asunto;

    /**
     * @var string
     *
     * @ORM\Column(name="anio", type="string", length=4)
     */
    private $anio;


    /**
     * @ORM\ManyToOne(targetEntity="TipoActividad", inversedBy="evento")
     * @ORM\JoinColumn(name="tipo_actividad_id", referencedColumnName="id")
     */
    private $tipo_actividad;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_crea", type="datetimetz", nullable=true)
     */
    private $fecha_crea;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_mod", type="datetimetz", nullable=true)
     */
    private $fecha_mod;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_elim", type="datetimetz", nullable=true)
     */
    private $fecha_elim;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="evento")
     * @ORM\JoinColumn(name="usuario_crea_id", referencedColumnName="id", nullable=true)
     */
    private $usuario_crea;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="evento")
     * @ORM\JoinColumn(name="usuario_mod_id", referencedColumnName="id", nullable=true)
     */
    private $usuario_mod;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="evento")
     * @ORM\JoinColumn(name="usuario_elim_id", referencedColumnName="id", nullable=true)
     */
    private $usuario_elim;

    /**
     * @ORM\OneToMany(targetEntity="EventoParticipante", mappedBy="evento")
     */
    private $evento_participante;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->asistencia_evento = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
    
        return ucwords($this->getTipoActividad()->getNombre()).': '.ucwords($this->getTipoPersona()).'; F: '.$this->getFechaInicio()->format('d/m/Y').' - '.$this->getFechaFin()->format('d/m/Y').'; H: '.$this->getHoraInicio().' - '.$this->getHoraFinal();
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
     * Set anio
     *
     * @param string $anio
     *
     * @return Evento
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
     * Set tipoActividad
     *
     * @param \Checnes\RegistroBundle\Entity\TipoActividad $tipoActividad
     *
     * @return Evento
     */
    public function setTipoActividad(\Checnes\RegistroBundle\Entity\TipoActividad $tipoActividad = null)
    {
        $this->tipo_actividad = $tipoActividad;

        return $this;
    }

    /**
     * Get tipoActividad
     *
     * @return \Checnes\RegistroBundle\Entity\TipoActividad
     */
    public function getTipoActividad()
    {
        return $this->tipo_actividad;
    }

    /**
     * Add eventoParticipante
     *
     * @param \Checnes\RegistroBundle\Entity\EventoParticipante $eventoParticipante
     *
     * @return Evento
     */
    public function addEventoParticipante(\Checnes\RegistroBundle\Entity\EventoParticipante $eventoParticipante)
    {
        $this->evento_participante[] = $eventoParticipante;

        return $this;
    }

    /**
     * Remove eventoParticipante
     *
     * @param \Checnes\RegistroBundle\Entity\EventoParticipante $eventoParticipante
     */
    public function removeEventoParticipante(\Checnes\RegistroBundle\Entity\EventoParticipante $eventoParticipante)
    {
        $this->evento_participante->removeElement($eventoParticipante);
    }

    /**
     * Get eventoParticipante
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEventoParticipante()
    {
        return $this->evento_participante;
    }

    /**
     * Set fechaCrea
     *
     * @param \DateTime $fechaCrea
     *
     * @return Evento
     */
    public function setFechaCrea($fechaCrea)
    {
        $this->fecha_crea = $fechaCrea;

        return $this;
    }

    /**
     * Get fechaCrea
     *
     * @return \DateTime
     */
    public function getFechaCrea()
    {
        return $this->fecha_crea;
    }

    /**
     * Set fechaMod
     *
     * @param \DateTime $fechaMod
     *
     * @return Evento
     */
    public function setFechaMod($fechaMod)
    {
        $this->fecha_mod = $fechaMod;

        return $this;
    }

    /**
     * Get fechaMod
     *
     * @return \DateTime
     */
    public function getFechaMod()
    {
        return $this->fecha_mod;
    }

    /**
     * Set usuarioCrea
     *
     * @param \Checnes\RegistroBundle\Entity\Usuario $usuarioCrea
     *
     * @return Evento
     */
    public function setUsuarioCrea(\Checnes\RegistroBundle\Entity\Usuario $usuarioCrea = null)
    {
        $this->usuario_crea = $usuarioCrea;

        return $this;
    }

    /**
     * Get usuarioCrea
     *
     * @return \Checnes\RegistroBundle\Entity\Usuario
     */
    public function getUsuarioCrea()
    {
        return $this->usuario_crea;
    }

    /**
     * Set usuarioMod
     *
     * @param \Checnes\RegistroBundle\Entity\Usuario $usuarioMod
     *
     * @return Evento
     */
    public function setUsuarioMod(\Checnes\RegistroBundle\Entity\Usuario $usuarioMod = null)
    {
        $this->usuario_mod = $usuarioMod;

        return $this;
    }

    /**
     * Get usuarioMod
     *
     * @return \Checnes\RegistroBundle\Entity\Usuario
     */
    public function getUsuarioMod()
    {
        return $this->usuario_mod;
    }

    /**
     * Set fechaElim
     *
     * @param \DateTime $fechaElim
     *
     * @return Evento
     */
    public function setFechaElim($fechaElim)
    {
        $this->fecha_elim = $fechaElim;

        return $this;
    }

    /**
     * Get fechaElim
     *
     * @return \DateTime
     */
    public function getFechaElim()
    {
        return $this->fecha_elim;
    }

    /**
     * Set usuarioElim
     *
     * @param \Checnes\RegistroBundle\Entity\Usuario $usuarioElim
     *
     * @return Evento
     */
    public function setUsuarioElim(\Checnes\RegistroBundle\Entity\Usuario $usuarioElim = null)
    {
        $this->usuario_elim = $usuarioElim;

        return $this;
    }

    /**
     * Get usuarioElim
     *
     * @return \Checnes\RegistroBundle\Entity\Usuario
     */
    public function getUsuarioElim()
    {
        return $this->usuario_elim;
    }

    /**
     * Set multa
     *
     * @param boolean $multa
     *
     * @return Evento
     */
    public function setMulta($multa)
    {
        $this->multa = $multa;

        return $this;
    }

    /**
     * Get multa
     *
     * @return boolean
     */
    public function getMulta()
    {
        return $this->multa;
    }

    /**
     * Set montoMulta
     *
     * @param float $montoMulta
     *
     * @return Evento
     */
    public function setMontoMulta($montoMulta)
    {
        $this->monto_multa = $montoMulta;

        return $this;
    }

    /**
     * Get montoMulta
     *
     * @return float
     */
    public function getMontoMulta()
    {
        return $this->monto_multa;
    }
}
