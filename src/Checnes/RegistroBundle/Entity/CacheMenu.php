<?php

namespace Checnes\RegistroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CacheMenu
 *
 * @ORM\Table(name="cache_menu")
 * @ORM\Entity(repositoryClass="Checnes\RegistroBundle\Repository\CacheMenuRepository")
 */
class CacheMenu
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
     * @ORM\ManyToOne(targetEntity="Rol", inversedBy="cache_menu")
     * @ORM\JoinColumn(name="rol_id", referencedColumnName="id")
     */
    private $rol;

    /**
     * @var text
     *
     * @ORM\Column(name="menu_escritorio", type="text")
     */
    private $menu_escritorio;

    /**
     * @var text
     *
     * @ORM\Column(name="movil_movil", type="text")
     */
    private $menu_movil;

    

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
     * Set menuEscritorio
     *
     * @param string $menuEscritorio
     *
     * @return CacheMenu
     */
    public function setMenuEscritorio($menuEscritorio)
    {
        $this->menu_escritorio = $menuEscritorio;

        return $this;
    }

    /**
     * Get menuEscritorio
     *
     * @return string
     */
    public function getMenuEscritorio()
    {
        return $this->menu_escritorio;
    }

    /**
     * Set menuMovil
     *
     * @param string $menuMovil
     *
     * @return CacheMenu
     */
    public function setMenuMovil($menuMovil)
    {
        $this->menu_movil = $menuMovil;

        return $this;
    }

    /**
     * Get menuMovil
     *
     * @return string
     */
    public function getMenuMovil()
    {
        return $this->menu_movil;
    }

    /**
     * Set rol
     *
     * @param \Checnes\RegistroBundle\Entity\Rol $rol
     *
     * @return CacheMenu
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
}
