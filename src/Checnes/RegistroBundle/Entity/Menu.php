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
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var int
     *
     * @ORM\Column(name="padre", type="integer")
     */
    private $padre;

    /**
     * @var string
     *
     * @ORM\Column(name="enlace", type="string", length=255)
     */
    private $enlace;

    /**
     * @var string
     *
     * @ORM\Column(name="icono", type="string", length=255)
     */
    private $icono;

    /**
     * @var boolean
     *
     * @ORM\Column(name="condicion", type="boolean")
     */
    private $condicion;

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
     * Set icono
     *
     * @param string $icono
     *
     * @return Menu
     */
    public function setIcono($icono)
    {
        $this->icono = $icono;

        return $this;
    }

    /**
     * Get icono
     *
     * @return string
     */
    public function getIcono()
    {
        return $this->icono;
    }

    /**
     * Set condicion
     *
     * @param boolean $condicion
     *
     * @return Menu
     */
    public function setCondicion($condicion)
    {
        $this->condicion = $condicion;

        return $this;
    }

    /**
     * Get condicion
     *
     * @return boolean
     */
    public function getCondicion()
    {
        return $this->condicion;
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
}
