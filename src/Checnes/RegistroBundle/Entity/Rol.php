<?php

namespace Checnes\RegistroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * rol
 *
 * @ORM\Table(name="rol")
 * @ORM\Entity(repositoryClass="Checnes\RegistroBundle\Repository\rolRepository")
 */
class Rol
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
     * @var bool
     *
     * @ORM\Column(name="condicion", type="boolean")
     */
    private $condicion;

    /**
     * @ORM\OneToMany(targetEntity="Usuario", mappedBy="rol")
     */
    private $usuario;


    /**
     * @ORM\OneToMany(targetEntity="MenuXRol", mappedBy="rol")
     */
    private $menu_x_rol;
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->usuario = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Rol
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
     * Set condicion
     *
     * @param boolean $condicion
     *
     * @return Rol
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
     * Add usuario
     *
     * @param \Checnes\RegistroBundle\Entity\Usuario $usuario
     *
     * @return Rol
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
     * Add menuXRol
     *
     * @param \Checnes\RegistroBundle\Entity\MenuXRol $menuXRol
     *
     * @return Rol
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
