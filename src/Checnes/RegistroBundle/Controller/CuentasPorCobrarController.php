<?php

namespace Checnes\RegistroBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Checnes\RegistroBundle\Entity\CuentasPorCobrar;
use Checnes\RegistroBundle\Entity\CuentasPorCobrarDetalle;
use Checnes\RegistroBundle\Entity\MovimientoCajaBanco;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Cuentasporcobrar controller.
 *
 * @Route("cuentasporcobrar")
 */
class CuentasPorCobrarController extends Controller
{
    /**
     * Lists all cuentasPorCobrar entities.
     *
     * @Route("/", name="cuentasporcobrar_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $request = $this->getRequest();
        $session = $request->getSession();

        $usuario_id = $session->get("usuario_id");
        $anio       = $session->get("anio");

        $dql  = "SELECT c FROM ChecnesRegistroBundle:CuentasPorCobrar c
                GROUP BY c.evento
                ORDER BY c.fecha_crea DESC
                ";
        $resp = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $resp, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        return $this->render('ChecnesRegistroBundle:CuentasPorCobrar:index.html.twig', array(
            'titulo'    =>'Cuentas Por Cobrar',
            'pagination'=> $pagination
        ));
    }

    /**
     * Lists all cuentasPorCobrar entities.
     * @Route("/vercobro/{evento_id}", name="cuentasporcobrar_ver")
     * @Method("GET")
     */
    public function verCobroAction(Request $request, $evento_id)
    {
        $em = $this->getDoctrine()->getManager();

        $evento = $em->getRepository('ChecnesRegistroBundle:Evento')->find($evento_id);

        //Moneda
        $moneda = $em->getRepository('ChecnesRegistroBundle:Moneda')->findAll(array('activo'=>1));
        $hmt_moneda = '';
        foreach ($moneda as $key => $mon) {
            $hmt_moneda .= '<option value="'.$mon->getId().'">'.$mon->getNombre().'</option>';
        }
        $hmt_moneda = ($hmt_moneda!='')?$hmt_moneda:"<option>SIN MONEDA</option>";

        $dql = "SELECT c FROM ChecnesRegistroBundle:CuentasPorCobrar c WHERE c.estado IN (1,2) AND c.evento=$evento_id";
        $res = $em->createQuery($dql)->getResult();

        return $this->render('ChecnesRegistroBundle:CuentasPorCobrar:cobro.html.twig', array(
            'titulo'  => 'Realizar Cobro',
            'cobro'   => $res,
            'evento'  => $evento,
            'hmt_moneda'  => $hmt_moneda
        ));
    }

    /**
     * @Route("/cajabanco", name="cuentasporcobrar_cajabanco")
     * @Method({"GET"})
     */
    public function buscarPersonaAction(Request $request){   
        
        $conn = $this->get('database_connection');

        $moneda_id = $request->query->get('moneda_id');

        $sql = "SELECT * FROM caja_banco WHERE moneda_id='$moneda_id' AND activo=1";

        $resp = $conn->executeQuery($sql)->fetchAll();

        $array = array();
        foreach ($resp as $key => $row) {
            $array[] = $row;//array('value'=>10,'label'=>'Juan');
        }
        //return json_encode($resp);
        return new JsonResponse($array);
    }

    /**
     * @Route("/cobrar", name="cuentasporcobrar_cobrar")
     * @Method({"GET", "POST"})
     */
    public function cobrarAction(Request $request){   
        
        $conn = $this->get('database_connection');
        $em   = $this->getDoctrine()->getManager();

        $session    = $request->getSession();
        $anio       = $session->get("anio");
        $usuario_id = $session->get("usuario_id");
        $periodo    = date('m');

        $moneda_id     = $request->request->get('moneda_id');
        $evento_id     = $request->request->get('evento_id');
        $cajabanco_id  = $request->request->get('cajabanco_id');
        $cta_cobrar_id = $request->request->get('cta_cobrar_id');
        $importe       = $request->request->get('importe');
        $tipo_cambio   = 3.23;

        $obj_mon = $em->getRepository('ChecnesRegistroBundle:Moneda')->find($moneda_id);
        $obj_evn = $em->getRepository('ChecnesRegistroBundle:Evento')->find($evento_id);
        $obj_cjb = $em->getRepository('ChecnesRegistroBundle:CajaBanco')->find($cajabanco_id);
        $obj_cta = $em->getRepository('ChecnesRegistroBundle:CuentasPorCobrar')->find($cta_cobrar_id);
        $obj_use = $em->getRepository('ChecnesRegistroBundle:Usuario')->find($usuario_id);
        $obj_sta = $em->getRepository('ChecnesRegistroBundle:Estado')->find(1);
        //$obj_per = $em->getRepository('ChecnesRegistroBundle:Estado')->find(1);

        $impo_base = 0;
        $impo_sol  = 0;
        $impo_dol  = 0;

        if ($obj_mon->getAbrev() == 'PEN') {
                
            $impo_base = (double)number_format($importe,4,".","");
            $impo_sol  = (double)number_format($importe,4,".","");
            $impo_dol  = (double)number_format($importe / $tipo_cambio,4,".","");
        }

        //Registramos detalle de cobro
        $detcobro = new CuentasPorCobrarDetalle();
        $detcobro->setCuentasPorCobrar($obj_cta);
        $detcobro->setMoneda($obj_mon);
        $detcobro->setUsuario($obj_use);
        $detcobro->setFechaCobro(new \DateTime(date('Y-m-d h:i:sa')));
        $detcobro->setPeriodo($periodo);
        $detcobro->setAnio($anio);
        $detcobro->setImpoBase($impo_base);
        $detcobro->setImpoSol($impo_sol);
        $detcobro->setImpoDol($impo_dol);
        $detcobro->setEstado($obj_sta);
        $em->persist($detcobro);

        //Registramos Movimiento Caja Banco
        $movcb = new MovimientoCajaBanco();
        $movcb->setCajaBanco($obj_cjb);
        $movcb->setUsuario($obj_use);
        $movcb->setTipo(1);//1=Ingreso
        $movcb->setFechaCrea(new \DateTime(date('Y-m-d h:i:sa')));
        $movcb->setPeriodo($periodo);
        $movcb->setAnio($anio);
        $movcb->setImpoBase($impo_base);
        $movcb->setImpoSol($impo_sol);
        $movcb->setImpoDol($impo_dol);
        $movcb->setEvento($obj_evn);
        $movcb->setEstado($obj_sta);
        $movcb->setPersona($obj_cta->getPersona());
        $movcb->setDescripcion($obj_evn->getAsunto());

        $movcb->setCuentasPorCobrarDetalle($detcobro);
        $em->persist($movcb);

        $pend_cobro = $obj_cta->getImpoBase() - ($this->getMontoDetalleCobro($cta_cobrar_id)+$impo_sol);
        if ($pend_cobro <= 0) {
            $estado = 'CERRADO';
            $monto  = 0;
            $obj_statw = $em->getRepository('ChecnesRegistroBundle:Estado')->find(2);
            $obj_cta->setEstado($obj_statw);
            //$em->persist($obj_cta);

            //Justificamos asistencia luego que la persona termine de pagar
            if ($obj_evn->getTipoActividad()->getTipoTipoActividad()->getNombreSistema() == 'asistencia') {
                
                $obj_asist  = $em->getRepository('ChecnesRegistroBundle:AsistenciaEvento')->findOneBy(array('evento'=>$obj_evn->getId(),'persona'=>$obj_cta->getPersona()));
                if (is_object($obj_asist)) {
                    $obj_asist->setAsistio(1);
                    $obj_asist->setUsuarioJusasis($obj_use);
                    $obj_asist->setDescripcion('Pagó Multa');
                }
            }
        }else{
            $estado = 'PENDIENTE';
            $monto  = number_format($pend_cobro,2,".","");
        }

        $em->flush();

        $array = array('estado'=>$estado,'monto'=>$monto);
        //return json_encode($resp);
        return new JsonResponse($array);
    }

    private function getMontoDetalleCobro($cobro_id){

        $conn = $this->get('database_connection');

        $sql = "SELECT SUM(impo_base)AS impo_base FROM cuentas_por_cobrar_detalle WHERE cuentas_por_cobrar_id='$cobro_id'";
        $resp = $conn->executeQuery($sql)->fetchAll();

        $impo_base = 0;

        foreach ($resp as $key => $v) {
            $impo_base = $v['impo_base'];
        }
        
        return $impo_base;
    }

    /**
     * Finds and displays a cuentasPorCobrar entity.
     *
     * @Route("/{id}", name="cuentasporcobrar_show")
     * @Method("GET")
     */
    public function showAction(CuentasPorCobrar $cuentasPorCobrar)
    {

        return $this->render('cuentasporcobrar/show.html.twig', array(
            'cuentasPorCobrar' => $cuentasPorCobrar,
        ));
    }
}
