<?php

namespace Checnes\RegistroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MenuXRol
 *
 * @ORM\Table(name="menu_x_rol")
 * @ORM\Entity(repositoryClass="Checnes\RegistroBundle\Repository\MenuXRolRepository")
 */
class MenuXRol
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
     * @ORM\Column(name="condicion", type="boolean")
     */
    private $condicion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_creacion", type="datetimetz")
     */
    private $fecha_creacion;


    /**
     * @ORM\ManyToOne(targetEntity="Rol", inversedBy="menu_x_rol")
     * @ORM\JoinColumn(name="rol_id", referencedColumnName="id")
     */
    private $rol;

    /**
     * @ORM\ManyToOne(targetEntity="Menu", inversedBy="menu_x_rol")
     * @ORM\JoinColumn(name="menu_id", referencedColumnName="id")
     */
    private $menu;

    

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
     * Set condicion
     *
     * @param boolean $condicion
     *
     * @return MenuXRol
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
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return MenuXRol
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
     * Set rol
     *
     * @param \Checnes\RegistroBundle\Entity\Rol $rol
     *
     * @return MenuXRol
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
     * Set menu
     *
     * @param \Checnes\RegistroBundle\Entity\Menu $menu
     *
     * @return MenuXRol
     */
    public function setMenu(\Checnes\RegistroBundle\Entity\Menu $menu = null)
    {
        $this->menu = $menu;

        return $this;
    }

    /**
     * Get menu
     *
     * @return \Checnes\RegistroBundle\Entity\Menu
     */
    public function getMenu()
    {
        return $this->menu;
    }
}
