<?php

namespace Checnes\RegistroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Menu
 *
 * @ORM\Table(name="menu")
 * @ORM\Entity(repositoryClass="Checnes\RegistroBundle\Repository\MenuRepository")
 */
class Menu
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
     * @ORM\Column(name="nombre", type="string", length=255, nullable=false)
     */
    private $nombre;

    /**
     * @var int
     *
     * @ORM\Column(name="padre", type="integer", nullable=false)
     */
    private $padre;

    /**
     * @var int
     *
     * @ORM\Column(name="nivel", type="integer", nullable=true, options={"default":0})
     */
    private $nivel;

    /**
     * @var string
     *
     * @ORM\Column(name="enlace", type="string", length=255, nullable=true, options={"default":"#"})
     */
    private $enlace;

    /**
     * @var string
     *
     * @ORM\Column(name="css_icono", type="string", length=255, nullable=true, options={"default":"fa-pencil-square-o"})
     */
    private $css_icono;

    /**
     * @var boolean
     *
     * @ORM\Column(name="estado", type="boolean", nullable=true, options={"default":0})
     */
    private $estado;

     /**
     * @var boolean
     *
     * @ORM\Column(name="tiene_hijo", type="boolean", nullable=true, options={"default":0})
     */
    private $tiene_hijo;

    /**
     * @var int
     *
     * @ORM\Column(name="orden", type="integer", nullable=true, options={"default":1})
     */
    private $orden;

    /**
     * @ORM\OneToMany(targetEntity="MenuXRol", mappedBy="menu")
     */
    private $menu_x_rol;

      

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->menu_x_rol = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
    
        return $this->getNombre();
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
     * @return Menu
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
     * Set padre
     *
     * @param integer $padre
     *
     * @return Menu
     */
    public function setPadre($padre)
    {
        $this->padre = $padre;

        return $this;
    }

    /**
     * Get padre
     *
     * @return integer
     */
    public function getPadre()
    {
        return $this->padre;
    }

    /**
     * Set nivel
     *
     * @param integer $nivel
     *
     * @return Menu
     */
    public function setNivel($nivel)
    {
        $this->nivel = $nivel;

        return $this;
    }

    /**
     * Get nivel
     *
     * @return integer
     */
    public function getNivel()
    {
        return $this->nivel;
    }

    /**
     * Set enlace
     *
     * @param string $enlace
     *
     * @return Menu
     */
    public function setEnlace($enlace)
    {
        $this->enlace = $enlace;

        return $this;
    }

    /**
     * Get enlace
     *
     * @return string
     */
    public function getEnlace()
    {
        return $this->enlace;
    }

    /**
     * Set cssIcono
     *
     * @param string $cssIcono
     *
     * @return Menu
     */
    public function setCssIcono($cssIcono)
    {
        $this->css_icono = $cssIcono;

        return $this;
    }

    /**
     * Get cssIcono
     *
     * @return string
     */
    public function getCssIcono()
    {
        return $this->css_icono;
    }

    /**
     * Set estado
     *
     * @param boolean $estado
     *
     * @return Menu
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
     * Set tieneHijo
     *
     * @param boolean $tieneHijo
     *
     * @return Menu
     */
    public function setTieneHijo($tieneHijo)
    {
        $this->tiene_hijo = $tieneHijo;

        return $this;
    }

    /**
     * Get tieneHijo
     *
     * @return boolean
     */
    public function getTieneHijo()
    {
        return $this->tiene_hijo;
    }

    /**
     * Add menuXRol
     *
     * @param \Checnes\RegistroBundle\Entity\MenuXRol $menuXRol
     *
     * @return Menu
     */
    public function addMenuXRol(\Checnes\RegistroBundle\Entity\MenuXRol $menuXRol)
    {
        $this->menu_x_rol[] = $menuXRol;

        return $this;
    }

    /**
     * Remove menuXRol
     *
     * @param \Checnes\RegistroBundle\Entity\MenuXRol $menuXRol
     */
    public function removeMenuXRol(\Checnes\RegistroBundle\Entity\MenuXRol $menuXRol)
    {
        $this->menu_x_rol->removeElement($menuXRol);
    }

    /**
     * Get menuXRol
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMenuXRol()
    {
        return $this->menu_x_rol;
    }

    /**
     * Set orden
     *
     * @param integer $orden
     *
     * @return Menu
     */
    public function setOrden($orden)
    {
        $this->orden = $orden;

        return $this;
    }

    /**
     * Get orden
     *
     * @return integer
     */
    public function getOrden()
    {
        return $this->orden;
    }
}
