<?php

namespace Checnes\RegistroBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * TarjetaControl controller.
 *
 * @Route("/tarjetacontrol")
 */
class TarjetaControlController extends Controller
{
    /**
     * @Route("/", name="tarjetacontrol_index")
     */
    public function indexAction(Request $request)
    {   
        $em   = $this->getDoctrine()->getManager();

        $session    = $request->getSession();
        $usuario_id = $session->get("usuario_id");

        $obj_use  = $em->getRepository('ChecnesRegistroBundle:Usuario')->find($usuario_id);

        
        $dql  = "SELECT e FROM ChecnesRegistroBundle:Evento e WHERE e.estado IN(1,2)";
        $resp = $em->createQuery($dql)->getResult();

        $tarjetacontrol = array();
        foreach ($resp as $key => $f) {

            $asistio     = 0;
            $descasistio = '';
            $sumaaporte  = 0;
            //$montomulta  = 0;
            if ($f->getTipoActividad()->getTipoTipoActividad()->getNombreSistema() == 'asistencia') {

                $obj_asist   = $em->getRepository('ChecnesRegistroBundle:AsistenciaEvento')->findOneBy(array('evento'=>$f->getId(),'persona'=>$obj_use->getPersona()->getId()));
                //$montomulta  = $f->getMontoMulta();
                $asistio     = $obj_asist->getAsistio();
                $descasistio = $obj_asist->getDescripcion();
            }elseif($f->getTipoActividad()->getTipoTipoActividad()->getNombreSistema() == 'tesoreria'){
                
                $obj_ctac   = $em->getRepository('ChecnesRegistroBundle:CuentasPorCobrar')->findOneBy(array('evento'=>$f->getId(),'persona'=>$obj_use->getPersona()->getId()));

                $asistio     = $obj_asist->getAsistio();
                $descasistio = $obj_asist->getDescripcion();
                $sumaaporte  = $this->getSumaCuemtaCobrar($obj_ctac->getId());
            }
            

            $tarjetacontrol[] = array('fechainicio'=>$f->getFechaInicio(),
                                        'asunto'=>$f->getAsunto(),
                                        'tipoactividad'=>$f->getTipoActividad()->getNombre(),
                                        'multa'=>$f->getMulta(),
                                        'montomulta'=>$f->getMontoMulta(),
                                        'nombresistema'=>$f->getTipoActividad()->getTipoTipoActividad()->getNombreSistema(),
                                        'asistio'=>$asistio,
                                        'descasistio'=>$descasistio,
                                        'sumaaporte'=>$sumaaporte
                                    );
            
        }
         
        return $this->render('ChecnesRegistroBundle:TarjetaControl:index.html.twig', array(
            'titulo'=>'Tarjeta De Control',
            'tarjetacontrol' => $tarjetacontrol
        ));
    }

    private function getSumaCuemtaCobrar($ctacob_id){

        $conn = $this->get('database_connection');

        $sql = "SELECT SUM(impo_sol)AS suma_cobro FROM cuentas_por_cobrar_detalle WHERE cuentas_por_cobrar_id='$ctacob_id'";

        $resp = $conn->executeQuery($sql)->fetchAll();

        $suma_cobro = 0;

        foreach ($resp as $key => $v) {
            $suma_cobro = (double)$v['suma_cobro'];
        }
        
        return $suma_cobro;

    }


    /**
     * @Route("/show", name="tarjetacontrol_show")
     */
    public function showAction()
    {
        return $this->render('ChecnesRegistroBundle:TarjetaControl:show.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/detalle", name="tarjetacontrol_detalle")
     */
    public function detalleAction()
    {
        return $this->render('ChecnesRegistroBundle:TarjetaControl:detalle.html.twig', array(
            // ...
        ));
    }

}
