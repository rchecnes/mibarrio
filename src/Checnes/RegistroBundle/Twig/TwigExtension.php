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
            new \Twig_SimpleFilter('price', array($this, 'priceFilter')),
            new \Twig_SimpleFilter('mayuscula', array($this, 'mayuscula')),
            new \Twig_SimpleFilter('str_pad', array($this, 'str_pad')),
            new \Twig_SimpleFilter('ucwords', array($this, 'ucwords')),
            new \Twig_SimpleFilter('ampm', array($this, 'ampm')),
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
            'getNotificacionEvento'     => new \Twig_Function_Method($this, 'getNotificacionEvento'),
            'getPasarLista'       => new \Twig_Function_Method($this, 'getPasarLista'),
            'getDispositivo'            => new \Twig_Function_Method($this, 'getDispositivo')
            
            
            );
     }

    public function ampm($time){
        return strtoupper(date("g:i a",strtotime($time)));
    }

    public function ucwords($texto){
        return ucwords($texto);
    }

    public function mayuscula($texto){
        return strtoupper($texto);
    }

    public function str_pad($texto,$nums){
        return str_pad($texto, $nums, 0, STR_PAD_LEFT);
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

    public function getMenuXRol($padre=0, $rol_id){
        $sql = "SELECT * FROM menu_x_rol mxr
        INNER JOIN menu m ON(mxr.menu_id=m.id)
        WHERE m.padre=$padre AND mxr.rol_id=$rol_id ORDER BY m.orden DESC";
        $resp = $this->conn->executeQuery($sql)->fetchAll();

        $dispositivo = $this->getDispositivo();

        if(empty($resp)){return "";}
        $menu = "";
        $c = 1;
        foreach ($resp as $key => $row) {
            $active = "";
          
            if ($row['tiene_hijo'] == 0) {

                $route = "";

                $active = ($row['defecto'] == 1)?"active":"";
                $enlace = ($row['enlace'] !='')?$row['enlace']:'#';
                
                /*if ($dispositivo == 'mobil') {
                    if ($enlace !='evento') {
                        $menu .= "<li class='".$active."'>";
                        $menu .= "<a href='".$this->url_base."/".$enlace."' class='".$active."'>";
                        $menu .= "<i class='menu-icon fa ".$row['css_icono']."'></i><span class='menu-text'>&nbsp;&nbsp;".$row['nombre']."</span>";
                        $menu .= "</a>";
                        $menu .= "</li>";
                    }
                }else{*/
                    //if ($enlace !='evento/lista') {
                        $menu .= "<li class='".$active."'>";
                        $menu .= "<a href='".$this->url_base."/".$enlace."' class='".$active."'>";
                        $menu .= "<i class='menu-icon fa ".$row['css_icono']."'></i><span class='menu-text'>&nbsp;&nbsp;".$row['nombre']."</span>";
                        $menu .= "</a>";
                        $menu .= "</li>";
                    //}
                //}
                

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
                    WHERE e.estado_id IN(1)
                    AND DATE_ADD(fecha_fin, INTERVAL 1 DAY) >= DATE_FORMAT(NOW(), '%Y-%m-%d')
                    ORDER BY DATE_FORMAT(e.fecha_inicio,'%Y-%m-%d') DESC";
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

    public function getPasarLista($fecha_ini, $hora_ini){

        $fech_ini = "";
        if (is_object($fecha_ini)) {
            
            $fech_ini = $fecha_ini->format('Y-m-d');

        }else{
            $fech_ini = $fecha_ini;
        }

        if (is_object($hora_ini)) {
            
            $fech_ini .= " ".$hora_ini->format('H:i:s');

        }else{
            $fech_ini .= " ".$hora_ini;
        }

        $fecha_actual = date('Y-m-d H:i:s');

        if (strtotime($fecha_actual) < strtotime($fech_ini)) {
            
            return 'block';
        }
    }

    public function getDispositivo(){
        
        $tablet_browser = 0;
        $mobile_browser = 0;
        $body_class     = 'desktop';
         
        if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
            $tablet_browser++;
            $body_class = "tablet";
        }
         
        if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
            $mobile_browser++;
            $body_class = "mobile";
        }
         
        if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
            $mobile_browser++;
            $body_class = "mobile";
        }
         
        $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
        $mobile_agents = array(
            'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
            'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
            'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
            'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
            'newt','noki','palm','pana','pant','phil','play','port','prox',
            'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
            'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
            'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
            'wapr','webc','winw','winw','xda ','xda-');
         
        if (in_array($mobile_ua,$mobile_agents)) {
            $mobile_browser++;
        }
         
        if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'opera mini') > 0) {
            $mobile_browser++;
            //Check for tablets on opera mini alternative headers
            $stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])?$_SERVER['HTTP_X_OPERAMINI_PHONE_UA']:(isset($_SERVER['HTTP_DEVICE_STOCK_UA'])?$_SERVER['HTTP_DEVICE_STOCK_UA']:''));
            if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
              $tablet_browser++;
            }
        }

        $dispositivo = 'desktop';

        if ($tablet_browser > 0) {
            // Si es tablet has lo que necesites
           //print 'es tablet';
           $dispositivo = 'tablet';
        }
        else if ($mobile_browser > 0) {
            // Si es dispositivo mobil has lo que necesites
           //print 'es un mobil';
           $dispositivo = 'mobil';
        }
        else {
            // Si es ordenador de escritorio has lo que necesites
           //print 'es un ordenador de escritorio';
           $dispositivo = 'desktop';
        }

        return $dispositivo;  
    }

    public function getName()
    {
        return 'Twig extension';
    }
}