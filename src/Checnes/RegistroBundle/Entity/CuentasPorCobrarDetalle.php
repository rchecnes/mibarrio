<?php

namespace Checnes\RegistroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CuentasPorCobrarDetalle
 *
 * @ORM\Table(name="cuentas_por_cobrar_detalle")
 * @ORM\Entity(repositoryClass="Checnes\RegistroBundle\Repository\CuentasPorCobrarDetalleRepository")
 */
class CuentasPorCobrarDetalle
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
     * @ORM\ManyToOne(targetEntity="CuentasPorCobrar", inversedBy="cuentas_por_cobrar_detalle")
     * @ORM\JoinColumn(name="cuentas_por_cobrar_id", referencedColumnName="id", nullable=false)
     */
    private $cuentas_por_cobrar;

    /**
     * @ORM\ManyToOne(targetEntity="Moneda", inversedBy="cuentas_por_cobrar_detalle")
     * @ORM\JoinColumn(name="moneda_id", referencedColumnName="id", nullable=false)
     */
    private $moneda;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="cuentas_por_cobrar_detalle")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id", nullable=false)
     */
    private $usuario;

    /**
     * @ORM\ManyToOne(targetEntity="Estado", inversedBy="cuentas_por_cobrar_detalle")
     * @ORM\JoinColumn(name="estado_id", referencedColumnName="id", nullable=false)
     */
    private $estado;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_cobro", type="datetimetz", nullable=false)
     */
    private $fecha_cobro;

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
     * @ORM\Column(name="impo_base", type="decimal", precision=19, scale=4, nullable=false)
     */
    private $impo_base;

    /**
     * @var decimal
     *
     * @ORM\Column(name="impo_sol", type="decimal", precision=19, scale=4, nullable=false)
     */
    private $impo_sol;

    /**
     * @var decimal
     *
     * @ORM\Column(name="impo_dol", type="decimal", precision=19, scale=4, nullable=false)
     */
    private $impo_dol;
    



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
     * Set fechaCobro
     *
     * @param \DateTime $fechaCobro
     *
     * @return CuentasPorCobrarDetalle
     */
    public function setFechaCobro($fechaCobro)
    {
        $this->fecha_cobro = $fechaCobro;

        return $this;
    }

    /**
     * Get fechaCobro
     *
     * @return \DateTime
     */
    public function getFechaCobro()
    {
        return $this->fecha_cobro;
    }

    /**
     * Set periodo
     *
     * @param string $periodo
     *
     * @return CuentasPorCobrarDetalle
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
     * @return CuentasPorCobrarDetalle
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
     * @return CuentasPorCobrarDetalle
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
     * Set impoSol
     *
     * @param string $impoSol
     *
     * @return CuentasPorCobrarDetalle
     */
    public function setImpoSol($impoSol)
    {
        $this->impo_sol = $impoSol;

        return $this;
    }

    /**
     * Get impoSol
     *
     * @return string
     */
    public function getImpoSol()
    {
        return $this->impo_sol;
    }

    /**
     * Set impoDol
     *
     * @param string $impoDol
     *
     * @return CuentasPorCobrarDetalle
     */
    public function setImpoDol($impoDol)
    {
        $this->impo_dol = $impoDol;

        return $this;
    }

    /**
     * Get impoDol
     *
     * @return string
     */
    public function getImpoDol()
    {
        return $this->impo_dol;
    }

    /**
     * Set cuentasPorCobrar
     *
     * @param \Checnes\RegistroBundle\Entity\CuentasPorCobrar $cuentasPorCobrar
     *
     * @return CuentasPorCobrarDetalle
     */
    public function setCuentasPorCobrar(\Checnes\RegistroBundle\Entity\CuentasPorCobrar $cuentasPorCobrar)
    {
        $this->cuentas_por_cobrar = $cuentasPorCobrar;

        return $this;
    }

    /**
     * Get cuentasPorCobrar
     *
     * @return \Checnes\RegistroBundle\Entity\CuentasPorCobrar
     */
    public function getCuentasPorCobrar()
    {
        return $this->cuentas_por_cobrar;
    }

    /**
     * Set moneda
     *
     * @param \Checnes\RegistroBundle\Entity\Moneda $moneda
     *
     * @return CuentasPorCobrarDetalle
     */
    public function setMoneda(\Checnes\RegistroBundle\Entity\Moneda $moneda)
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

    /**
     * Set usuario
     *
     * @param \Checnes\RegistroBundle\Entity\Usuario $usuario
     *
     * @return CuentasPorCobrarDetalle
     */
    public function setUsuario(\Checnes\RegistroBundle\Entity\Usuario $usuario)
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
     * Set estado
     *
     * @param \Checnes\RegistroBundle\Entity\Estado $estado
     *
     * @return CuentasPorCobrarDetalle
     */
    public function setEstado(\Checnes\RegistroBundle\Entity\Estado $estado)
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
}
