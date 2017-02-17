<?php
namespace Checnes\RegistroBundle\Twig;

class TwigExtension extends \Twig_Extension
{
	private $conn;
    private $em;

    public function __construct()
    {
        $this->conn = $GLOBALS['kernel']->getContainer()->get('database_connection');
        $this->em   = $GLOBALS['kernel']->getContainer()->get('doctrine')->getManager();
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('price', array($this, 'priceFilter'))
            //'getMenu' => new \Twig_Filter_Method($this, 'getMenu'),
            //'formatNum'         => new \Twig_Filter_Method($this, 'formatNum')
  
        );
    }

    /*public function priceFilter($number, $decimals = 0, $decPoint = '.', $thousandsSep = ',')
    {
        $price = number_format($number, $decimals, $decPoint, $thousandsSep);
        $price = '$'.$price;

        return $price;
    }*/


    public function getFunctions()
    {
        return array(
            'getMenu'  => new \Twig_Function_Method($this, 'getMenu')
            );
     }


    public function getMenu($rol_id){

    	//$em = $this->getDoctrine()->getManager();

    	$entity = $this->em->getRepository('ChecnesRegistroBundle:MenuXRol')->findBy(array('rol'=>$rol_id),array());

    	//print($entity->getNombre());
    	//ld($entity);

    	return $entity;
    }

    public function getName()
    {
        return 'Twig extension';
    }
}