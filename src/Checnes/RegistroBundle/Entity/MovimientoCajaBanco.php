<?php

namespace Checnes\RegistroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MovimientoCajaBanco
 *
 * @ORM\Table(name="movimiento_caja_banco")
 * @ORM\Entity(repositoryClass="Checnes\RegistroBundle\Repository\MovimientoCajaBancoRepository")
 */
class MovimientoCajaBanco
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
     * @var integer
     *
     * @ORM\Column(name="tipo", type="integer", nullable=false, options={"comment":"0=Saldo Inicial; 1=Ingreso; 2=Egreso"})
     */
    private $tipo;

    /**
     * @ORM\ManyToOne(targetEntity="CajaBanco", inversedBy="movimiento_caja_banco")
     * @ORM\JoinColumn(name="caja_banco_id", referencedColumnName="id", nullable=false)
     */
    private $caja_banco;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="movimiento_caja_banco")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id", nullable=false)
     */
    private $usuario;

    /**
     * @ORM\ManyToOne(targetEntity="Evento", inversedBy="movimiento_caja_banco")
     * @ORM\JoinColumn(name="evento_id", referencedColumnName="id", nullable=true)
     */
    private $evento;

    /**
     * @ORM\ManyToOne(targetEntity="Estado", inversedBy="movimiento_caja_banco")
     * @ORM\JoinColumn(name="estado_id", referencedColumnName="id", nullable=false)
     */
    private $estado;

    /**
     * @ORM\ManyToOne(targetEntity="CuentasPorCobrarDetalle", inversedBy="movimiento_caja_banco")
     * @ORM\JoinColumn(name="cuentas_por_cobrar_detalle_id", referencedColumnName="id", nullable=true)
     */
    private $cuentas_por_cobrar_detalle;

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
     * Set tipo
     *
     * @param integer $tipo
     *
     * @return MovimientoCajaBanco
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return integer
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set fechaCrea
     *
     * @param \DateTime $fechaCrea
     *
     * @return MovimientoCajaBanco
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
     * @return MovimientoCajaBanco
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
     * @return MovimientoCajaBanco
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
     * @return MovimientoCajaBanco
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
     * @return MovimientoCajaBanco
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
     * @return MovimientoCajaBanco
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
     * Set cajaBanco
     *
     * @param \Checnes\RegistroBundle\Entity\CajaBanco $cajaBanco
     *
     * @return MovimientoCajaBanco
     */
    public function setCajaBanco(\Checnes\RegistroBundle\Entity\CajaBanco $cajaBanco)
    {
        $this->caja_banco = $cajaBanco;

        return $this;
    }

    /**
     * Get cajaBanco
     *
     * @return \Checnes\RegistroBundle\Entity\CajaBanco
     */
    public function getCajaBanco()
    {
        return $this->caja_banco;
    }

    /**
     * Set usuario
     *
     * @param \Checnes\RegistroBundle\Entity\Usuario $usuario
     *
     * @return MovimientoCajaBanco
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
     * Set evento
     *
     * @param \Checnes\RegistroBundle\Entity\Evento $evento
     *
     * @return MovimientoCajaBanco
     */
    public function setEvento(\Checnes\RegistroBundle\Entity\Evento $evento)
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
     * Set estado
     *
     * @param \Checnes\RegistroBundle\Entity\Estado $estado
     *
     * @return MovimientoCajaBanco
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

    /**
     * Set cuentasPorCobrarDetalle
     *
     * @param \Checnes\RegistroBundle\Entity\CuentasPorCobrarDetalle $cuentasPorCobrarDetalle
     *
     * @return MovimientoCajaBanco
     */
    public function setCuentasPorCobrarDetalle(\Checnes\RegistroBundle\Entity\CuentasPorCobrarDetalle $cuentasPorCobrarDetalle = null)
    {
        $this->cuentas_por_cobrar_detalle = $cuentasPorCobrarDetalle;

        return $this;
    }

    /**
     * Get cuentasPorCobrarDetalle
     *
     * @return \Checnes\RegistroBundle\Entity\CuentasPorCobrarDetalle
     */
    public function getCuentasPorCobrarDetalle()
    {
        return $this->cuentas_por_cobrar_detalle;
    }
}
