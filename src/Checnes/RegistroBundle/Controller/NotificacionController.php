<?php

namespace Checnes\RegistroBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Checnes\RegistroBundle\Entity\Evento;
//use Checnes\RegistroBundle\Form\LoteType;

/**
 * Evento controller.
 *
 * @Route("/notificacion")
 */
class NotificacionController extends Controller
{
    /**
     * Lists all Lote entities.
     *
     * @Route("/{id}/", name="notificacion_index")
      @Method("POST|GET")
     */
    public function indexAction(Request $request, $id){

        $em = $this->getDoctrine()->getManager();

        //$origen_solic = ($request->query->get('origen')!=null)?$request->query->get('origen'):"";

        $evento = $em->getRepository('ChecnesRegistroBundle:Evento')->find($id);

        $data['evento']       = $evento;
        $data['titulo']       = "Visualizar Evento: ".$evento->getFechaInicio()->format('Y-m-d');
        return $this->render('ChecnesRegistroBundle:Notificacion:index.html.twig', $data);
    }
  
}