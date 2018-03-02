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

        $tarjeta_control  = array();
        $control_faena    = array();
        $control_asamblea = array();
        $control_aportacion = array();
        $control_reunion = array();
        foreach ($resp as $key => $f) {

            if (($f->getTipoActividad()->getTipoTipoActividad()->getNombreSistema()== 'asistencia' && $f->getEstado()->getId()==2) || ($f->getTipoActividad()->getTipoTipoActividad()->getNombreSistema()== 'tesoreria')) {
                
                $asistio     = 0;
                $descasistio = "";
                $sumaaporte  = 0;
                //$montomulta  = 0;
                if ($f->getTipoActividad()->getTipoTipoActividad()->getNombreSistema() == 'asistencia') {

                    $obj_asist   = $em->getRepository('ChecnesRegistroBundle:AsistenciaEvento')->findOneBy(array('evento'=>$f->getId(),'persona'=>$obj_use->getPersona()->getId()));
                    //$montomulta  = $f->getMontoMulta();
                    if (is_object($obj_asist)) {
                        $asistio     = $obj_asist->getAsistio();
                        $descasistio = ($obj_asist->getPagoMulta()==1)?"Pago Multa":"";
                    }
                    
                }elseif($f->getTipoActividad()->getTipoTipoActividad()->getNombreSistema() == 'tesoreria'){
                    
                    $obj_ctac   = $em->getRepository('ChecnesRegistroBundle:CuentasPorCobrar')->findOneBy(array('evento'=>$f->getId(),'persona'=>$obj_use->getPersona()->getId()));

                    if (is_object($obj_ctac)) {
                        $sumaaporte  = $this->getSumaCuemtaCobrar($obj_ctac->getId());
                    }
                }
                
                if ($f->getTipoActividad()->getNombreSistema() == 'faena') {

                    $control_faena[] = array('fechainicio'=>$f->getFechaInicio(),
                                            'evento_id'=>$f->getId(),
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

                if ($f->getTipoActividad()->getNombreSistema() == 'asamblea') {

                    $control_asamblea[] = array('fechainicio'=>$f->getFechaInicio(),
                                            'evento_id'=>$f->getId(),
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
                if ($f->getTipoActividad()->getNombreSistema() == 'aportacion') {

                    $control_asamblea[] = array('fechainicio'=>$f->getFechaInicio(),
                                            'evento_id'=>$f->getId(),
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

                if ($f->getTipoActividad()->getNombreSistema() == 'reunion') {

                    $control_reunion[] = array('fechainicio'=>$f->getFechaInicio(),
                                            'evento_id'=>$f->getId(),
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

                $tarjeta_control[] = array('fechainicio'=>$f->getFechaInicio(),
                                            'evento_id'=>$f->getId(),
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
        }
         
        return $this->render('ChecnesRegistroBundle:TarjetaControl:index.html.twig', array(
            'titulo'=>'Tarjeta De Control - '.$obj_use->getPersona()->getNombre()." ".$obj_use->getPersona()->getApellidoPaterno()." ".$obj_use->getPersona()->getApellidoMaterno(),
            'tarjeta_control'  => $tarjeta_control,
            'control_faena'    => $control_faena,
            'control_asamblea' => $control_asamblea,
            'control_aportacion' => $control_aportacion,
            'control_reunion' => $control_reunion
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
