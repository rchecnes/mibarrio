<?php

namespace Checnes\RegistroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Usuario
 *
 * @ORM\Table(name="usuario")
 * @ORM\Entity(repositoryClass="Checnes\RegistroBundle\Repository\UsuarioRepository")
 */
class Usuario
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
     * @ORM\Column(name="usuario", type="string", length=255, unique=true)
     */
    private $usuario;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255)
     */
    private $salt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_creacion", type="datetimetz")
     */
    private $fecha_creacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ultimo_acceso", type="datetimetz", nullable=true)
     */
    private $ultimo_acceso;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean", nullable=true, options={"default":"1"})
     */
    private $activo;

    /**
     * @var bool
     *
     * @ORM\Column(name="estado", type="boolean", nullable=true, options={"default":"1"})
     */
    private $estado;

    /**
     * @var string
     *
     * @ORM\Column(name="anio", type="string", length=4)
     */
    private $anio;

    /**
     * @ORM\ManyToOne(targetEntity="Rol", inversedBy="usuario")
     * @ORM\JoinColumn(name="rol_id", referencedColumnName="id")
     */
    private $rol;

    /**
     * @ORM\ManyToOne(targetEntity="Persona", inversedBy="usuario")
     * @ORM\JoinColumn(name="persona_id", referencedColumnName="id", unique=true)
     */
    private $persona;


    

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
     * Set usuario
     *
     * @param string $usuario
     *
     * @return Usuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return string
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Usuario
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set salt
     *
     * @param string $salt
     *
     * @return Usuario
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return Usuario
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
     * Set ultimoAcceso
     *
     * @param \DateTime $ultimoAcceso
     *
     * @return Usuario
     */
    public function setUltimoAcceso($ultimoAcceso)
    {
        $this->ultimo_acceso = $ultimoAcceso;

        return $this;
    }

    /**
     * Get ultimoAcceso
     *
     * @return \DateTime
     */
    public function getUltimoAcceso()
    {
        return $this->ultimo_acceso;
    }


    /**
     * Set anio
     *
     * @param string $anio
     *
     * @return Usuario
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
     * Set rol
     *
     * @param \Checnes\RegistroBundle\Entity\Rol $rol
     *
     * @return Usuario
     */
    public function setRol(\Checnes\RegistroBundle\Entity\Rol $rol = null)
    {
        $this->rol = $rol;

        return $this;
    }

    /**
     * Get rol
     *
     * @return \Checnes\RegistroBundle\Entity\Rol
     */
    public function getRol()
    {
        return $this->rol;
    }

    /**
     * Set persona
     *
     * @param \Checnes\RegistroBundle\Entity\Persona $persona
     *
     * @return Usuario
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
     * Set activo
     *
     * @param boolean $activo
     *
     * @return Usuario
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
     * Set estado
     *
     * @param boolean $estado
     *
     * @return Usuario
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
}
