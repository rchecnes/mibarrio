<?php

namespace Checnes\RegistroBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Checnes\RegistroBundle\Entity\Evento;
//use Checnes\RegistroBundle\Form\LoteType;

/**
 * Evento controller.
 *
 * @Route("/evento")
 */
class EventoController extends Controller
{
    /**
     * Lists all Lote entities.
     *
     * @Route("/", name="evento_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        //$lotes = $em->getRepository('ChecnesRegistroBundle:Lote')->findAll();

        $dql = "SELECT e FROM ChecnesRegistroBundle:Evento e";
        $resp_dql = $em->createQuery($dql)->getResult();

        $evento = array();

        foreach ($resp_dql as $entity) {

            $background_color = '#f39c12';//color de pendiente
            $border_color = '#f39c12';

            //condicion
            if (strtolower($entity->getCondicion())=='porconfirmar') {
                $background_color = '#E0BA7E';
                $border_color = '#E0BA7E';
            }else if(strtolower($entity->getCondicion())=='confirmado'){
                $background_color = '#f39c12';
                $border_color = '#f39c12';
            }else if(strtolower($entity->getCondicion())=='realizandose'){
                $background_color = '#00a65a';
                $border_color = '#00a65a';
            }else if(strtolower($entity->getCondicion())=='finalizo'){
                $background_color = '#dd4b39';
                $border_color = '#dd4b39';
            }else if(strtolower($entity->getCondicion())=='cancelado'){
                $background_color = '#00c0ef';
                $border_color = '#00c0ef';
            }

            $evento[] = array(
                'title'=>ucwords($entity->getTipoActividad()->getNombre()).':',//title for calendar
                'nombre'=>"",//nombre for bd
                'description'=>$entity->getDescripcion(),
                'start'=>date_format($entity->getFechaInicio(), 'Y-m-d'),
                'end'=>date_format($entity->getFechaFin(), 'Y-m-d'),
                'backgroundColor'=>$background_color,
                'borderColor'=>$border_color,
                'class'=>'evento_calendar',
                'id_event' => $entity->getId(),
                'detalle' => $entity->getDescripcion(),
                'tipo_actividad'=> $entity->getTipoActividad()->getId(),
                'condicion'=>$entity->getCondicion(),
                'hora_inicio'=>$entity->getHoraInicio(),
                'hora_final'=>$entity->getHoraFinal(),
                'tipo_persona'=>$entity->getTipoPersona()
            );
            //print(date_format($entity->getFechaInicio(), 'Y/m/d'));
        }

        //print(json_encode($evento));
        
        //Ge tipo actividad
        $tipo_actividad = $em->getRepository('ChecnesRegistroBundle:TipoActividad')->findAll();
        $html_op_tipac = '';
        foreach ($tipo_actividad as $key => $entity) {
            $html_op_tipac .= '<option value="'.$entity->getId().'">'.$entity->getNombre().'</option>';
        }

        return $this->render('ChecnesRegistroBundle:Evento:index.html.twig', array(
            'eventos' => json_encode($evento),'titulo'=>'Eventos de calendario', 'tipo_actividad_html'=>$html_op_tipac
        ));
    }

    /**
     *
     * @Route("/create", name="evento_create")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        //ld($request->request->get('tipo'));
        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();

        $anio = $session->get("anio");
        $usuario_id = $session->get("usuario_id");

        $entity = new Evento();

        $obj_tipa = $em->getRepository('ChecnesRegistroBundle:TipoActividad')->find($request->request->get('tipo_actividad'));
        $obj_usu = $em->getRepository('ChecnesRegistroBundle:Usuario')->find($usuario_id);

        $entity->setTipoActividad($obj_tipa);
        $entity->setCondicion($request->request->get('condicion'));
        $entity->setCondicion($request->request->get('condicion'));
        $entity->setFechaInicio(new \DateTime($request->request->get('fecha')));
        $entity->setFechaFin(new \DateTime($request->request->get('fecha')));
        $entity->setFechaCreacion(new \DateTime(date('Y-m-d')));
        $entity->setDescripcion($request->request->get('detalle'));
        $entity->setHoraInicio($request->request->get('hora_inicio'));
        $entity->setHoraFinal($request->request->get('hora_final'));
        $entity->setTipoPersona($request->request->get('tipo_persona'));

        $entity->setUsuario($obj_usu);
        $entity->setAnio($anio);

        $entity->setEstado(1);

        $em->persist($entity);
        $em->flush();

        return $this->redirectToRoute("evento_index");
    }

    /**
     * @Route("/{id}/update", name="evento_update")
     * @Method({"GET", "POST"})
     */
    public function updateAction(Request $request, $id)
    {   
        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();

        $entity = $em->getRepository('ChecnesRegistroBundle:Evento')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Evento entity.');
        }

        $anio         = $session->get("anio");
        $usuario_id     = $session->get("usuario_id");
        $reg_asistencia = $request->request->get('reg_asistencia');

        if (strtolower($entity->getCondicion()) != 'finalizo') {

            if (strtolower($entity->getCondicion()) == 'porconfirmar') {

                $obj_tipa = $em->getRepository('ChecnesRegistroBundle:TipoActividad')->find($request->request->get('tipo_actividad'));
                $obj_usu = $em->getRepository('ChecnesRegistroBundle:Usuario')->find($usuario_id);

                $entity->setTipoActividad($obj_tipa);
                $entity->setCondicion($request->request->get('condicion'));
                $entity->setFechaInicio(new \DateTime($request->request->get('fecha')));
                $entity->setFechaFin(new \DateTime($request->request->get('fecha')));
                $entity->setFechaCreacion(new \DateTime(date('Y-m-d')));
                $entity->setDescripcion($request->request->get('detalle'));
                $entity->setHoraInicio($request->request->get('hora_inicio'));
                $entity->setHoraFinal($request->request->get('hora_final'));
                $entity->setTipoPersona($request->request->get('tipo_persona'));

                $entity->setUsuario($obj_usu);
                $entity->setAnio($anio);

            }else{
                $entity->setCondicion($request->request->get('condicion'));
            }

            

            $em->persist($entity);
            $em->flush();
        }
        
        if ($reg_asistencia == 'REG_ASISTENCIA') {
            return $this->redirectToRoute("asistenciaevento_index",array('evento'=>$id));
        }else{
            return $this->redirectToRoute("evento_index");
        }
        
    }

    /**
     * @Route("/delete", name="evento_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request)
    {   
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ChecnesRegistroBundle:Evento')->find($request->request->get('id'));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Evento entity.');
        }

        if ($entity->getCondicion() == 'porconfirmar' || $entity->getCondicion() == 'cancelado') {
            $em->remove($entity);
            $em->flush();
        }
        
        return new JsonResponse(array('exito' => 'exito'));

        //ld($entity);
    }
}