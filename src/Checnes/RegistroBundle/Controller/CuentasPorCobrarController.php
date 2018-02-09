<?php

namespace Checnes\RegistroBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Checnes\RegistroBundle\Entity\CuentasPorCobrar;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

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
        
        $dql = "SELECT c FROM ChecnesRegistroBundle:CuentasPorCobrar c WHERE c.estado=1 AND c.evento=$evento_id";
        $res = $em->createQuery($dql)->getResult();

        return $this->render('ChecnesRegistroBundle:CuentasPorCobrar:cobro.html.twig', array(
            'titulo'  =>ucwords('Cobrar Por - '.$evento->getAsunto().' - '.date_format($evento->getFechaInicio(),'d/m/Y')),
            'cobro'   => $res
        ));
    }//strtoupper(date_format($entity->getHoraInicio(),'g:i a'))

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
