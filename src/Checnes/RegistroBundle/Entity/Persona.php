<?php

namespace Checnes\RegistroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Persona
 *
 * @ORM\Table(name="persona")
 * @ORM\Entity(repositoryClass="Checnes\RegistroBundle\Repository\PersonaRepository")
 */
class Persona
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
     * @ORM\Column(name="dni", type="string", length=255, unique=true)
     */
    private $dni;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido_paterno", type="string", length=255)
     */
    private $apellido_paterno;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido_materno", type="string", length=255)
     */
    private $apellido_materno;

    /**
     * @var string
     *
     * @ORM\Column(name="estado_civil", type="string", length=20, nullable=true)
     */
    private $estado_civil;

    /**
     * @var bool
     *
     * @ORM\Column(name="es_dirigente", type="boolean")
     */
    private $es_dirigente;

    /**
     * @var integer
     *
     * @ORM\Column(name="numero", type="integer")
     */
    private $numero;

    /**
     * @ORM\ManyToOne(targetEntity="Lote", inversedBy="persona")
     * @ORM\JoinColumn(name="lote_id", referencedColumnName="id")
     */
    private $lote;

    /**
     * @ORM\ManyToOne(targetEntity="Cargo", inversedBy="persona")
     * @ORM\JoinColumn(name="cargo_id", referencedColumnName="id")
     */
    private $cargo;

    /**
     * @ORM\ManyToOne(targetEntity="Ano", inversedBy="persona")
     * @ORM\JoinColumn(name="ano_id", referencedColumnName="id")
     */
    private $ano;
    
    /**
     * @ORM\OneToMany(targetEntity="AsistenciaEvento", mappedBy="persona")
     */
    private $asistencia_evento;

    /**
     * @ORM\OneToMany(targetEntity="Usuario", mappedBy="persona")
     */
    private $usuario;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->asistencia_evento = new \Doctrine\Common\Collections\ArrayCollection();
        $this->usuario = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set dni
     *
     * @param string $dni
     *
     * @return Persona
     */
    public function setDni($dni)
    {
        $this->dni = $dni;

        return $this;
    }

    /**
     * Get dni
     *
     * @return string
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Persona
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
     * Set apellidoPaterno
     *
     * @param string $apellidoPaterno
     *
     * @return Persona
     */
    public function setApellidoPaterno($apellidoPaterno)
    {
        $this->apellido_paterno = $apellidoPaterno;

        return $this;
    }

    /**
     * Get apellidoPaterno
     *
     * @return string
     */
    public function getApellidoPaterno()
    {
        return $this->apellido_paterno;
    }

    /**
     * Set apellidoMaterno
     *
     * @param string $apellidoMaterno
     *
     * @return Persona
     */
    public function setApellidoMaterno($apellidoMaterno)
    {
        $this->apellido_materno = $apellidoMaterno;

        return $this;
    }

    /**
     * Get apellidoMaterno
     *
     * @return string
     */
    public function getApellidoMaterno()
    {
        return $this->apellido_materno;
    }

    /**
     * Set estadoCivil
     *
     * @param string $estadoCivil
     *
     * @return Persona
     */
    public function setEstadoCivil($estadoCivil)
    {
        $this->estado_civil = $estadoCivil;

        return $this;
    }

    /**
     * Get estadoCivil
     *
     * @return string
     */
    public function getEstadoCivil()
    {
        return $this->estado_civil;
    }

    /**
     * Set esDirigente
     *
     * @param boolean $esDirigente
     *
     * @return Persona
     */
    public function setEsDirigente($esDirigente)
    {
        $this->es_dirigente = $esDirigente;

        return $this;
    }

    /**
     * Get esDirigente
     *
     * @return boolean
     */
    public function getEsDirigente()
    {
        return $this->es_dirigente;
    }

    /**
     * Set lote
     *
     * @param \Checnes\RegistroBundle\Entity\Lote $lote
     *
     * @return Persona
     */
    public function setLote(\Checnes\RegistroBundle\Entity\Lote $lote = null)
    {
        $this->lote = $lote;

        return $this;
    }

    /**
     * Get lote
     *
     * @return \Checnes\RegistroBundle\Entity\Lote
     */
    public function getLote()
    {
        return $this->lote;
    }

    /**
     * Set cargo
     *
     * @param \Checnes\RegistroBundle\Entity\Cargo $cargo
     *
     * @return Persona
     */
    public function setCargo(\Checnes\RegistroBundle\Entity\Cargo $cargo = null)
    {
        $this->cargo = $cargo;

        return $this;
    }

    /**
     * Get cargo
     *
     * @return \Checnes\RegistroBundle\Entity\Cargo
     */
    public function getCargo()
    {
        return $this->cargo;
    }

    /**
     * Set ano
     *
     * @param \Checnes\RegistroBundle\Entity\Ano $ano
     *
     * @return Persona
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
     * Add asistenciaEvento
     *
     * @param \Checnes\RegistroBundle\Entity\AsistenciaEvento $asistenciaEvento
     *
     * @return Persona
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
     * Add usuario
     *
     * @param \Checnes\RegistroBundle\Entity\Usuario $usuario
     *
     * @return Persona
     */
    public function addUsuario(\Checnes\RegistroBundle\Entity\Usuario $usuario)
    {
        $this->usuario[] = $usuario;

        return $this;
    }

    /**
     * Remove usuario
     *
     * @param \Checnes\RegistroBundle\Entity\Usuario $usuario
     */
    public function removeUsuario(\Checnes\RegistroBundle\Entity\Usuario $usuario)
    {
        $this->usuario->removeElement($usuario);
    }

    /**
     * Get usuario
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set numero
     *
     * @param integer $numero
     *
     * @return Persona
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return integer
     */
    public function getNumero()
    {
        return $this->numero;
    }
}
