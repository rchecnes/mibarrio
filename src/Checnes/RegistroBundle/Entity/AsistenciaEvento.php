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
     * @var bool
     *
     * @ORM\Column(name="asistio", type="boolean")
     */
    private $asistio;

    /**
     * @var bool
     *
     * @ORM\Column(name="tardanza", type="boolean")
     */
    private $tardanza;

    /**
     * @var bool
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado;

    /**
     * @var bool
     *
     * @ORM\Column(name="cerrado", type="boolean", nullable=true, options={"default":"0"})
     */
    private $cerrado;

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
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="asistencia_evento")
     * @ORM\JoinColumn(name="usuario_crea_id", referencedColumnName="id", nullable=true)
     */
    private $usuario_crea;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="asistencia_evento")
     * @ORM\JoinColumn(name="usuario_mod_id", referencedColumnName="id", nullable=true)
     */
    private $usuario_mod;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="asistencia_evento")
     * @ORM\JoinColumn(name="usuario_jusasis_id", referencedColumnName="id", nullable=true)
     */
    private $usuario_jusasis;

    /**
     * @var integer
     *
     * @ORM\Column(name="pago_multa", type="integer", nullable=true, options={"comment":"0=Ninguno; 1=Pago Multa", "default":"0"})
     */
    private $pago_multa;

    

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
     * Set tardanza
     *
     * @param boolean $tardanza
     *
     * @return AsistenciaEvento
     */
    public function setTardanza($tardanza)
    {
        $this->tardanza = $tardanza;

        return $this;
    }

    /**
     * Get tardanza
     *
     * @return boolean
     */
    public function getTardanza()
    {
        return $this->tardanza;
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
     * Set cerrado
     *
     * @param boolean $cerrado
     *
     * @return AsistenciaEvento
     */
    public function setCerrado($cerrado)
    {
        $this->cerrado = $cerrado;

        return $this;
    }

    /**
     * Get cerrado
     *
     * @return boolean
     */
    public function getCerrado()
    {
        return $this->cerrado;
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
     * Set fechaCrea
     *
     * @param \DateTime $fechaCrea
     *
     * @return AsistenciaEvento
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
     * @return AsistenciaEvento
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
     * Set pagoMulta
     *
     * @param integer $pagoMulta
     *
     * @return AsistenciaEvento
     */
    public function setPagoMulta($pagoMulta)
    {
        $this->pago_multa = $pagoMulta;

        return $this;
    }

    /**
     * Get pagoMulta
     *
     * @return integer
     */
    public function getPagoMulta()
    {
        return $this->pago_multa;
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
     * Set usuarioCrea
     *
     * @param \Checnes\RegistroBundle\Entity\Usuario $usuarioCrea
     *
     * @return AsistenciaEvento
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
     * @return AsistenciaEvento
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
     * Set usuarioJusasis
     *
     * @param \Checnes\RegistroBundle\Entity\Usuario $usuarioJusasis
     *
     * @return AsistenciaEvento
     */
    public function setUsuarioJusasis(\Checnes\RegistroBundle\Entity\Usuario $usuarioJusasis = null)
    {
        $this->usuario_jusasis = $usuarioJusasis;

        return $this;
    }

    /**
     * Get usuarioJusasis
     *
     * @return \Checnes\RegistroBundle\Entity\Usuario
     */
    public function getUsuarioJusasis()
    {
        return $this->usuario_jusasis;
    }
}
