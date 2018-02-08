<?php

namespace Checnes\RegistroBundle\Controller;

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

        $cuentasporcobrar = $em->getRepository('ChecnesRegistroBundle:CuentasPorCobrar')->findAll();

        return $this->render('ChecnesRegistroBundle:CuentasPorCobrar:index.html.twig', array(
            'personas' => '',
            'titulo'   =>'Cuentas Por Cobrar',
            'pagination'   => $cuentasporcobrar
        ));
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
