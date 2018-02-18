<?php

namespace Checnes\RegistroBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Checnes\RegistroBundle\Entity\MovimientoCajaBanco;
/**
 * Evento controller.
 *
 * @Route("/movcajabanco")
 */

class MovimientoCajaBancoController extends Controller
{
    /**
     * @Route("/", name="movcajabanco_index")
     */
    public function indexAction(Request $request)
    {   

        $em = $this->getDoctrine()->getManager();

        $obcajabanco = $em->getRepository('ChecnesRegistroBundle:CajaBanco')->findAll();

        return $this->render('ChecnesRegistroBundle:MovimientoCajaBanco:index.html.twig', array(
            'titulo'   => 'Movimiento Caja Banco',
            'cajabanco'=> $obcajabanco
        ));
    }

    /**
     * @Route("/detalle", name="movcajabanco_detalle")
     * @Method("POST|GET")
     */
    public function detalleAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $cajabanco_id = $request->query->get('cajabanco_id');

        $obj_cb = $em->getRepository('ChecnesRegistroBundle:CajaBanco')->find($cajabanco_id);

        $em = $this->getDoctrine()->getManager();

        $resp = $em->createQuery("SELECT m FROM ChecnesRegistroBundle:MovimientoCajaBanco m WHERE m.estado IN(1) AND m.caja_banco='$cajabanco_id' ORDER BY m.id DESC");

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $resp, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );
        
        $data['eventos']    = $resp;
        $data['pagination'] = $pagination;
        $data['titulo']     = "Movimiento: ".$obj_cb->getNombre();
        $data['caja_banco_id'] = $obj_cb->getId();

        return $this->render('ChecnesRegistroBundle:MovimientoCajaBanco:detalle.html.twig',$data);
    }

    /**
     *
     * @Route("/new", name="movcajabanco_new")
     * @Method("POST|GET")
     */
    public function newAction(Request $request){

        $em = $this->getDoctrine()->getManager();

        $cajabanco_id = $request->query->get('caja_banco_id');

        $obj_cb = $em->getRepository('ChecnesRegistroBundle:CajaBanco')->find($cajabanco_id);

        $data['titulo']    = "Nueva Operación en: ".$obj_cb->getNombre();
        $data['cajabanco'] = $obj_cb;

        return $this->render('ChecnesRegistroBundle:MovimientoCajaBanco:new.html.twig', $data);
    }

    /**
     *
     * @Route("/create", name="movcajabanco_sav")
     * @Method("POST")
     */
    public function createAction(Request $request){

        $em = $this->getDoctrine()->getManager();

        $session = $request->getSession();

        $anio       = $session->get("anio");
        $usuario_id = $session->get("usuario_id");

        $importe = $request->request->get('importe');
        $persona_id = $request->request->get('persona_id');

        $obj_cb   = $em->getRepository('ChecnesRegistroBundle:CajaBanco')->find($request->request->get('caja_banco_id'));
        $obj_usu  = $em->getRepository('ChecnesRegistroBundle:Usuario')->find($usuario_id);
        
        
        $obj_per = 'NULL';
        if ($persona_id !='') {
            $obj_per  = $em->getRepository('ChecnesRegistroBundle:Persona')->find($request->request->get('persona_id'));
        }
        //ld($obj_per);exit();

        $obj_est  = $em->getRepository('ChecnesRegistroBundle:Estado')->find(1);

        $impo_sol    = 0;
        $impo_dol    = 0;
        $tipo_cambio = 3.23;

        if ($obj_cb->getMoneda()->getAbrev() == 'PEN') {
            $impo_sol = $importe;
            $impo_dol = $importe/$tipo_cambio;
        }else if($obj_cb->getMoneda()->getAbrev() == 'USD'){
            $impo_sol = $importe * $tipo_cambio;
            $impo_dol = $importe;
        }

        $entity = new MovimientoCajaBanco();
        $entity->setCajaBanco($obj_cb);
        $entity->setUsuario($obj_usu);
        $entity->setTipo($request->request->get('tipo'));
        $entity->setFechaCrea(new \DateTime(date('Y-m-d H:i:s')));
        $entity->setPeriodo(date('m'));
        $entity->setAnio($anio);
        $entity->setImpoBase($importe);
        $entity->setImpoSol($impo_sol);
        $entity->setImpoDol($impo_dol);
        $entity->setEstado($obj_est);
        if ($obj_per !='NULL') {
            $entity->setPersona($obj_per);
        }
        $entity->setDescripcion($request->request->get('descripcion'));
        $em->persist($entity);
        $em->flush();

        //new \DateTime($request->request->get('fecha_inicio'))
    
        $session->getFlashBag()->add("success",'La operaciòn se realizo correctamente!');

        return $this->redirectToRoute("movcajabanco_detalle", array('cajabanco_id'=>$obj_cb->getId()));
    }

}
