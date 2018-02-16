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
     * @ORM\ManyToOne(targetEntity="Evento", inversedBy="cuentas_por_cobrar")
     * @ORM\JoinColumn(name="evento_id", referencedColumnName="id")
     */
    private $evento;

    /**
     * @ORM\ManyToOne(targetEntity="Persona", inversedBy="cuentas_por_cobrar")
     * @ORM\JoinColumn(name="persona_id", referencedColumnName="id")
     */
    private $persona;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="cuentas_por_cobrar")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     */
    private $usuario_crea;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_crea", type="datetimetz", nullable=false)
     */
    private $fecha_crea;

    /**
     * @var string
     *
     * @ORM\Column(name="periodo", type="string", length=2, nullable=false)
     */
    private $periodo;

    /**
     * @var string
     *
     * @ORM\Column(name="anio", type="string", length=4, nullable=false)
     */
    private $anio;

    /**
     * @var decimal
     *
     * @ORM\Column(name="impo_base", type="decimal", nullable=false)
     */
    private $impo_base;

    /**
     * @ORM\ManyToOne(targetEntity="Estado", inversedBy="cuentas_por_cobrar")
     * @ORM\JoinColumn(name="estado_id", referencedColumnName="id")
     */
    private $estado;

    /**
     * @ORM\ManyToOne(targetEntity="Moneda", inversedBy="cuentas_por_cobrar")
     * @ORM\JoinColumn(name="moneda_id", referencedColumnName="id")
     */
    private $moneda;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;


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
     * Set fechaCrea
     *
     * @param \DateTime $fechaCrea
     *
     * @return CuentasPorCobrar
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
     * Set periodo
     *
     * @param string $periodo
     *
     * @return CuentasPorCobrar
     */
    public function setPeriodo($periodo)
    {
        $this->periodo = $periodo;

        return $this;
    }

    /**
     * Get periodo
     *
     * @return string
     */
    public function getPeriodo()
    {
        return $this->periodo;
    }

    /**
     * Set anio
     *
     * @param string $anio
     *
     * @return CuentasPorCobrar
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
     * Set impoBase
     *
     * @param string $impoBase
     *
     * @return CuentasPorCobrar
     */
    public function setImpoBase($impoBase)
    {
        $this->impo_base = $impoBase;

        return $this;
    }

    /**
     * Get impoBase
     *
     * @return string
     */
    public function getImpoBase()
    {
        return $this->impo_base;
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
     * @return boolean
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set evento
     *
     * @param \Checnes\RegistroBundle\Entity\Evento $evento
     *
     * @return CuentasPorCobrar
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
     * @return CuentasPorCobrar
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
     * @return CuentasPorCobrar
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
     * Set estado
     *
     * @param \Checnes\RegistroBundle\Entity\Estado $estado
     *
     * @return CuentasPorCobrar
     */
    public function setEstado(\Checnes\RegistroBundle\Entity\Estado $estado = null)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return \Checnes\RegistroBundle\Entity\Estado
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set moneda
     *
     * @param \Checnes\RegistroBundle\Entity\Moneda $moneda
     *
     * @return CuentasPorCobrar
     */
    public function setMoneda(\Checnes\RegistroBundle\Entity\Moneda $moneda = null)
    {
        $this->moneda = $moneda;

        return $this;
    }

    /**
     * Get moneda
     *
     * @return \Checnes\RegistroBundle\Entity\Moneda
     */
    public function getMoneda()
    {
        return $this->moneda;
    }
}
