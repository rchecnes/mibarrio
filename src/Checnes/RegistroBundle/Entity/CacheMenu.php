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
     * @var string
     *
     * @ORM\Column(name="menu", type="text")
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
     * Set menu
     *
     * @param string $menu
     *
     * @return CacheMenu
     */
    public function setMenu($menu)
    {
        $this->menu = $menu;

        return $this;
    }

    /**
     * Get menu
     *
     * @return string
     */
    public function getMenu()
    {
        return $this->menu;
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
