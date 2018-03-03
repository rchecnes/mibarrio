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
     * @ORM\Column(name="menu_dev_escritorio", type="text")
     */
    private $menu_dev_escritorio;

    /**
     * @var text
     *
     * @ORM\Column(name="menu_dev_movil", type="text")
     */
    private $menu_dev_movil;

    /**
     * @var text
     *
     * @ORM\Column(name="menu_prod_escritorio", type="text")
     */
    private $menu_prod_escritorio;

    /**
     * @var text
     *
     * @ORM\Column(name="menu_prod_movil", type="text")
     */
    private $menu_prod_movil;

    


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
     * Set menuDevEscritorio
     *
     * @param string $menuDevEscritorio
     *
     * @return CacheMenu
     */
    public function setMenuDevEscritorio($menuDevEscritorio)
    {
        $this->menu_dev_escritorio = $menuDevEscritorio;

        return $this;
    }

    /**
     * Get menuDevEscritorio
     *
     * @return string
     */
    public function getMenuDevEscritorio()
    {
        return $this->menu_dev_escritorio;
    }

    /**
     * Set menuDevMovil
     *
     * @param string $menuDevMovil
     *
     * @return CacheMenu
     */
    public function setMenuDevMovil($menuDevMovil)
    {
        $this->menu_dev_movil = $menuDevMovil;

        return $this;
    }

    /**
     * Get menuDevMovil
     *
     * @return string
     */
    public function getMenuDevMovil()
    {
        return $this->menu_dev_movil;
    }

    /**
     * Set menuProdEscritorio
     *
     * @param string $menuProdEscritorio
     *
     * @return CacheMenu
     */
    public function setMenuProdEscritorio($menuProdEscritorio)
    {
        $this->menu_prod_escritorio = $menuProdEscritorio;

        return $this;
    }

    /**
     * Get menuProdEscritorio
     *
     * @return string
     */
    public function getMenuProdEscritorio()
    {
        return $this->menu_prod_escritorio;
    }

    /**
     * Set menuProdMovil
     *
     * @param string $menuProdMovil
     *
     * @return CacheMenu
     */
    public function setMenuProdMovil($menuProdMovil)
    {
        $this->menu_prod_movil = $menuProdMovil;

        return $this;
    }

    /**
     * Get menuProdMovil
     *
     * @return string
     */
    public function getMenuProdMovil()
    {
        return $this->menu_prod_movil;
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
