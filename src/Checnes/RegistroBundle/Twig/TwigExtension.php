<?php
namespace Checnes\RegistroBundle\Twig;


class TwigExtension extends \Twig_Extension
{
	private $conn;
    private $em;
    private $url_base;
    private $generator;

    public function __construct()
    {
        $this->conn     = $GLOBALS['kernel']->getContainer()->get('database_connection');
        $this->em       = $GLOBALS['kernel']->getContainer()->get('doctrine')->getManager();
        $this->url_base = $GLOBALS['kernel']->getContainer()->get('router')->getContext()->getBaseUrl();
       
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
            'getMenu'                   => new \Twig_Function_Method($this, 'getMenu'),
            'getMenuXRol'               => new \Twig_Function_Method($this, 'getMenuXRol'),
            'existeRegistroAsistencia'  => new \Twig_Function_Method($this, 'existeRegistroAsistencia'),
            'getNombrePadre'            => new \Twig_Function_Method($this, 'getNombrePadre'),
            'getCantidadHijo'           => new \Twig_Function_Method($this, 'getCantidadHijo'),
            'getNotificacionEvento'     => new \Twig_Function_Method($this, 'getNotificacionEvento')
            
            
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

    public function getMenuXRol($padre=0, $rol_id)
    {
        $sql = "SELECT * FROM menu_x_rol mxr
        INNER JOIN menu m ON(mxr.menu_id=m.id)
        WHERE m.padre=$padre AND mxr.rol_id=$rol_id ORDER BY m.orden DESC";
        $resp = $this->conn->executeQuery($sql)->fetchAll();

        if(empty($resp)){return "";}
        $menu = "";
        $c = 1;
        foreach ($resp as $key => $row) {
            $active = "";
          
            if ($row['tiene_hijo'] == 0) {

                $route = "";

                $active = ($row['defecto'] == 1)?"active":"";
                $enlace = ($row['enlace'] !='')?$row['enlace']:'#';
                $menu .= "<li class='".$active."'>";
                $menu .= "<a href='".$this->url_base."/".$enlace."' class='".$active."'>";
                $menu .= "<i class='menu-icon fa ".$row['css_icono']."'></i><span class='menu-text'>&nbsp;&nbsp;".$row['nombre']."</span>";
                $menu .= "</a>";
                $menu .= "</li>";

            }else{
                $menu .= "<li>";
                $menu .= "<a href='#' class='dropdown-toggle'>";
                $menu .= "<i class='menu-icon fa ".$row['css_icono']."'></i><span class='menu-text'>&nbsp;&nbsp;".$row['nombre']."</span>";
                $menu .= "<b class='arrow fa fa-angle-down'></b>";
                $menu .= "</a>";
                $menu .= $this->getMenuXRol($row['id'], $rol_id);
                $menu .= "</li>";
            }
            $c++;
        }

        if ($padre ==0) {
            $menu="<ul class='nav nav-list'>$menu</ul>";
        }else{
            $menu="<ul class='submenu nav-show'>$menu</ul>";
        }
        
        if($padre==0){$menu=$menu;}
        
        return $menu;
    }

    public function getNotificacionEvento(){
        
        $fecha_actual = date('Y-m-d');

        $sqlev = "  SELECT
                    e.*,
                    te.nombre AS nomb_tipoevento
                    FROM evento e
                    INNER JOIN tipo_actividad te ON(e.tipo_actividad_id=te.id)
                    WHERE e.condicion IN('confirmado','realizandose')
                    /*AND DATE_FORMAT(e.fecha_fin,'%Y-%m-%d')>='$fecha_actual'*/";
        //echo $sqlev;
        $resp = $this->conn->executeQuery($sqlev)->fetchAll();

        $cant_event = 0;

        $eventos    = array();
        $evento_det = array();

        foreach ($resp as $key => $ev) {
            
            $cant_event +=1;

            $evento_det[] = $ev;
        }

        $eventos['cantidad'] = $cant_event;
        $eventos['detalle']  = $evento_det;

        return $eventos;
    }

   
    public function getName()
    {
        return 'Twig extension';
    }
}