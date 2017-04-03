<?php
namespace Checnes\RegistroBundle\Twig;

class TwigExtension extends \Twig_Extension
{
	private $conn;
    private $em;
    private $url_base;

    public function __construct()
    {
        $this->conn = $GLOBALS['kernel']->getContainer()->get('database_connection');
        $this->em   = $GLOBALS['kernel']->getContainer()->get('doctrine')->getManager();
        $this->url_base = $GLOBALS['kernel']->getContainer()->getParameter('base_url');
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('price', array($this, 'priceFilter'))
            //'getMenu' => new \Twig_Filter_Method($this, 'getMenu'),
            //'formatNum'         => new \Twig_Filter_Method($this, 'formatNum')
  
        );
    }

   public function getFunctions()
    {
        return array(
            'getMenu'  => new \Twig_Function_Method($this, 'getMenu'),
            'getMenuXRol'  => new \Twig_Function_Method($this, 'getMenuXRol'),
            'existeRegistroAsistencia'  => new \Twig_Function_Method($this, 'existeRegistroAsistencia'),
            'getNombrePadre'  => new \Twig_Function_Method($this, 'getNombrePadre'),
            'getCantidadHijo'  => new \Twig_Function_Method($this, 'getCantidadHijo')
            
            
            );
     }

    public function existeRegistroAsistencia($evento_id){

        $sql = "SELECT COUNT(*)AS cant FROM asistencia_evento WHERE evento_id='$evento_id' LIMIT 1";
        $resp = $this->conn->executeQuery($sql)->fetchAll();

        $cantasist = 0;

        foreach ($resp as $key => $v) {
            $cantasist = $v['cant'];
        }
        
        return $cantasist;
    }

    public function getNombrePadre($id){

        $sql = "SELECT nombre FROM menu WHERE id='$id' LIMIT 1";
        $resp = $this->conn->executeQuery($sql)->fetchAll();

        $nombre = 0;

        foreach ($resp as $key => $v) {
            $nombre = $v['nombre'];
        }
        
        return ($nombre !='')?$nombre:'Ninguno';
    }

    public function getCantidadHijo($id){

        $sql = "SELECT COUNT(id)cant FROM menu WHERE padre='$id'";
        $resp = $this->conn->executeQuery($sql)->fetchAll();

        $cantidad = 0;

        foreach ($resp as $key => $v) {
            $cantidad = $v['cant'];
        }
        
        return $cantidad;
    }

    


    /*public function getMenu($rol_id){

    	//$em = $this->getDoctrine()->getManager();

    	$entity = $this->em->getRepository('ChecnesRegistroBundle:MenuXRol')->findBy(array('rol'=>$rol_id),array());

    	//print($entity->getNombre());
    	//ld($entity);

    	return $entity;
    }*/
    public function getMenuXRol($padre=0)
    {
        $sql = "SELECT * FROM menu WHERE padre=$padre ORDER BY orden DESC";
        $resp = $this->conn->executeQuery($sql)->fetchAll();

        if(empty($resp)){return "";}
        $menu = "";
        $c = 1;
        foreach ($resp as $key => $row) {
            $active = "";
            /*if ($c==1) {
                $active = "active";
            }*/

            if ($row['tiene_hijo'] == 0) {
                $enlace = ($row['enlace'] !='')?$row['enlace']:'#';
                $menu .= "<li class='".$active."'>";
                $menu .= "<a href='".$this->url_base."/".$enlace."'>";
                $menu .= "<i class='menu-icon fa ".$row['css_icono']."'></i><span class='menu-text'>&nbsp;&nbsp;".$row['nombre']."</span>";
                $menu .= "</a>";
                $menu .= "</li>";

            }else{
                $menu .= "<li>";
                $menu .= "<a href='#' class='dropdown-toggle'>";
                $menu .= "<i class='menu-icon fa ".$row['css_icono']."'></i><span class='menu-text'>&nbsp;&nbsp;".$row['nombre']."</span>";
                $menu .= "<b class='arrow fa fa-angle-down'></b>";
                $menu .= "</a>";
                $menu .= $this->getMenuXRol($row['id']);
                $menu .= "</li>";
            }
            $c++;
        }

        if ($padre ==0) {
            $menu="<ul class='nav nav-list'>$menu</ul>";
        }else{
            $menu="<ul class='submenu nav-show'>$menu</ul>";
        }
        

        //if($padre==0){$menu="<div id='menu_cab'>$menu</div>";}
        if($padre==0){$menu=$menu;}
        
        return $menu;
    }

    /*public function getMenu($padre=0)
    {
        $sql = "SELECT * FROM menu WHERE padre=$padre AND estado=1";
        $resp = $this->conn->executeQuery($sql)->fetchAll();

        if(empty($resp)){return "";}
        $menu = "";
        foreach ($resp as $key => $row) {

            if ($row['tiene_hijo'] == 0) {
                $menu .= "<li>";
                $menu .= "<a href='#' id='".$row['id']."' name='".$row['id']."'>";
                $menu .= "<i class='fa  fa-file-code-o fa-4x'></i><span class='menu-text'>".$row['nombre']."</span>";
                $menu .= "</a>";
                $menu .= "</li>";

            }else{
                $menu .= "<li>";
                $menu .= "<a href='#' id='".$row['id']."' name='".$row['id']."' class='dropdown-toggle'>";
                $menu .= "<i class='fa  fa-folder-open-o fa-4x'></i><span class='menu-text'>".$row['nombre']."</span>";
                $menu .= "<b class='arrow fa fa-plus'></b>";
                $menu .= "</a>";
                $menu .= $this->getMenu($row['id']);
                $menu .= "</li>";
            }
        }

        if ($padre ==0) {
            $menu="<ul class=''>$menu</ul>";
        }else{
            $menu="<ul class=''>$menu</ul>";
        }
        

        //if($padre==0){$menu="<div id='menu_cab'>$menu</div>";}
        if($padre==0){$menu=$menu;}
        
        return $menu;
    }*/



    public function getName()
    {
        return 'Twig extension';
    }
}