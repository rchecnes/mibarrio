<?php

namespace Checnes\RegistroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Checnes\RegistroBundle\Entity\CacheMenu;

/**
 * Cajabanco controller.
 *
 * @Route("cachemenu")
 */
class CacheMenuController extends Controller
{

	/**
     * Lists all cajaBanco entities.
     *
     * @Route("/{rol_id}/create", name="cachemenu_crear")
     * @Method({"GET", "POST"})
     */
    public function createAction(Request $request, $rol_id)
    {
        $session = $request->getSession();

        $em = $this->getDoctrine()->getManager();
		
		$resp = $em->createQuery("SELECT cm FROM ChecnesRegistroBundle:CacheMenu cm WHERE cm.rol=$rol_id")->getResult();
		
		$obj_rol  = $em->getRepository('ChecnesRegistroBundle:Rol')->find($rol_id);

		if ($resp) {
			
			foreach ($resp as $key => $cm) {
				
				$obj_cm  = $em->getRepository('ChecnesRegistroBundle:CacheMenu')->find($cm->getId());

				$obj_cm->setMenu($this->getMenuXRol(0, $rol_id));
				$em->persist($obj_cm);
				$em->flush();
			}

			$session->getFlashBag()->add("success",'Se actualizo correctamente el cache menú para el rol '.$obj_rol->getNombre());

		}else{

			$obj_rol  = $em->getRepository('ChecnesRegistroBundle:Rol')->find($rol_id);

			$cachemenu = new CacheMenu();
			$cachemenu->setRol($obj_rol);
			$cachemenu->setMenu($this->getMenuXRol(0, $rol_id));
			$em->persist($cachemenu);
			$em->flush();

			$session->getFlashBag()->add("success",'Se genero correctamente el cache menú para el rol '.$obj_rol->getNombre());
		}

		return $this->redirectToRoute("rol_index");
    }

    private function getMenuXRol($padre=0, $rol_id){

    	$conn = $this->get('database_connection');

    	$url_base = $GLOBALS['kernel']->getContainer()->get('router')->getContext()->getBaseUrl();

        $sql = "SELECT * FROM menu_x_rol mxr
        INNER JOIN menu m ON(mxr.menu_id=m.id)
        WHERE m.padre=$padre AND mxr.rol_id=$rol_id ORDER BY m.orden DESC";
        $resp = $conn->executeQuery($sql)->fetchAll();

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
                
                if ($dispositivo == 'mobil') {
                    if ($enlace !='evento') {
                        $menu .= "<li class='".$active."'>";
                        $menu .= "<a href='".$url_base."/".$enlace."' class='".$active."'>";
                        $menu .= "<i class='menu-icon fa ".$row['css_icono']."'></i><span class='menu-text'>&nbsp;&nbsp;".$row['nombre']."</span>";
                        $menu .= "</a>";
                        $menu .= "</li>";
                    }
                }else{
                    if ($enlace !='evento/lista') {
                        $menu .= "<li class='".$active."'>";
                        $menu .= "<a href='".$url_base."/".$enlace."' class='".$active."'>";
                        $menu .= "<i class='menu-icon fa ".$row['css_icono']."'></i><span class='menu-text'>&nbsp;&nbsp;".$row['nombre']."</span>";
                        $menu .= "</a>";
                        $menu .= "</li>";
                    }
                }
                

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

    private function getDispositivo(){
        
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
}
