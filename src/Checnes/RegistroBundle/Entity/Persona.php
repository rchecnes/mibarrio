<?php

namespace Checnes\RegistroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Persona
 *
 * @ORM\Table(name="persona")
 * @ORM\Entity(repositoryClass="Checnes\RegistroBundle\Repository\PersonaRepository")
 */
class Persona
{
    //CONSULTA DE DNI: http://dataservice.insite.pe/documentacion
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
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 8,
     *      max = 8,
     *      minMessage = "DNI debe se de 8 dígitos",
     *      maxMessage = "DNI debe se de 8 dígitos"
     * )
     * @ORM\Column(name="dni", type="string", length=255, unique=true)
     */
    private $dni;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="apellido_paterno", type="string", length=255)
     */
    private $apellido_paterno;

    /**
     * @var string
     * @Assert\NotBlank()
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
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="Lote", inversedBy="persona")
     * @ORM\JoinColumn(name="lote_id", referencedColumnName="id")
     */
    private $lote;

    /**
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="Cargo", inversedBy="persona")
     * @ORM\JoinColumn(name="cargo_id", referencedColumnName="id")
     */
    private $cargo;

    /**
     * @var string
     *
     * @ORM\Column(name="anio", type="string", length=4)
     */
    private $anio;

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
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean",nullable=true, options={"default":"1"})
     */
    private $activo;

    /**
     * @var bool
     *
     * @ORM\Column(name="estado", type="boolean",nullable=true, options={"default":"1"})
     */
    private $estado;

    

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

    /**
     * Set anio
     *
     * @param string $anio
     *
     * @return Persona
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
     * Set fechaCrea
     *
     * @param \DateTime $fechaCrea
     *
     * @return Persona
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
     * @return Persona
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
     * Set fechaElim
     *
     * @param \DateTime $fechaElim
     *
     * @return Persona
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
     * Set estado
     *
     * @param boolean $estado
     *
     * @return Persona
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
     * Set activo
     *
     * @param boolean $activo
     *
     * @return Persona
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
}
