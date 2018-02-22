<?php

namespace Checnes\RegistroBundle\Controller;

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
    public function indexAction()
    {

        $em   = $this->getDoctrine()->getManager();
        $dql  = "SELECT e FROM ChecnesRegistroBundle:Evento e WHERE e.estado IN(1,2)";
        $resp = $em->createQuery($dql)->getResult();

        $tarjetacontrol = array();
        foreach ($resp as $key => $f) {
            $tarjetacontrol[] = $f;
        }

        return $this->render('ChecnesRegistroBundle:TarjetaControl:index.html.twig', array(
            'titulo'=>'Tarjeta De Control',
            'tarjetacontrol' => $tarjetacontrol
        ));
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
