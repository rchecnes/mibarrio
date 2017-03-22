<?php

namespace Checnes\RegistroBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Checnes\RegistroBundle\Entity\Evento;
use Checnes\RegistroBundle\Entity\EventoParticipante;
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
                'title'=>ucwords($entity->getTipoActividad()->getNombre().': '.$entity->getTipoPersona()),//title for calendar
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
            'eventos' => json_encode($evento),'titulo'=>'Eventos de calendario', 'tipo_actividad_html'=>$html_op_tipac,
            'fecha_actual'=>date('Y-m-d')
        ));
    }

    /**
     *
     * @Route("/new", name="evento_new")
     * @Method("POST")
     */
    public function newAction(Request $request){

        $em = $this->getDoctrine()->getManager();

        $tipo_actividad = $em->getRepository('ChecnesRegistroBundle:TipoActividad')->findAll();
        $html_op_tipac = '';
        foreach ($tipo_actividad as $key => $entity) {
            $html_op_tipac .= '<option value="'.$entity->getId().'">'.$entity->getNombre().'</option>';
        }

        $data['tipo_actividad_html'] = $html_op_tipac;
        $data['fecha_fin']     = $request->request->get('dayClick');
        $data['titulo']              = "Nuevo evento de calendario - ".$request->request->get('dayClick');
        return $this->render('ChecnesRegistroBundle:Evento:new.html.twig', $data);
    }

    /**
     *
     * @Route("/create", name="evento_create")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();

        $anio = $session->get("anio");
        $usuario_id = $session->get("usuario_id");

        $entity = new Evento();

        $obj_tipa = $em->getRepository('ChecnesRegistroBundle:TipoActividad')->find($request->request->get('tipo_actividad'));
        $obj_usu = $em->getRepository('ChecnesRegistroBundle:Usuario')->find($usuario_id);

        $entity->setTipoActividad($obj_tipa);
        $entity->setCondicion($request->request->get('condicion'));
        $entity->setFechaInicio(new \DateTime($request->request->get('fecha')));
        $entity->setFechaFin(new \DateTime($request->request->get('fecha_fin')));
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

        //Resgistramos participantes
        $participantes = $request->request->get('codigo_participantes');
        $participantes = explode('-', $participantes);

        if ($participantes !='') {

            $obj_evento = $em->getRepository('ChecnesRegistroBundle:Evento')->find($entity->getId());

            for ($i=0; $i < count($participantes); $i++) {

                if ($participantes[$i] !='') {

                    $obj_per = $em->getRepository('ChecnesRegistroBundle:Persona')->find($participantes[$i]);

                    $responsable = ($request->request->get('perresp_'.$participantes[$i]))?true:false;

                    $participante = new EventoParticipante();
                    $participante->setPersona($obj_per);
                    $participante->setUsuario($obj_usu);
                    $participante->setEvento($obj_evento);
                    $participante->setFechaCreacion(new \DateTime(date('Y-m-d H:i:s')));
                    $participante->setFechaActualizacion(new \DateTime(date('Y-m-d H:i:s')));
                    $participante->setResponsable($responsable);
                    $em->persist($participante);
                }
               
            }
        }
        
        $em->flush();
        //Fin registro participante
        

        $reg_asistencia = $request->request->get('reg_asistencia');

        if ($reg_asistencia == 'REG_ASISTENCIA') {
            return $this->redirectToRoute("asistenciaevento_index",array('evento'=>$entity->getId()));
        }else{
            return $this->redirectToRoute("evento_index");
        }

    }

    /**
     *
     * @Route("/edit", name="evento_edit")
     * @Method("POST")
     */
    public function editAction(Request $request){

        $em = $this->getDoctrine()->getManager();

        $id = $request->request->get('evento_id');

        $evento = $em->getRepository('ChecnesRegistroBundle:Evento')->find($id);

        $tipo_actividad = $em->getRepository('ChecnesRegistroBundle:TipoActividad')->findAll();
        $html_op_tipac = '';
        foreach ($tipo_actividad as $key => $entity) {
            $html_op_tipac .= '<option value="'.$entity->getId().'">'.$entity->getNombre().'</option>';
        }       

        $evento = $em->getRepository('ChecnesRegistroBundle:Evento')->find($id);

        $data['tipo_actividad_html'] = $html_op_tipac;
        $data['evento']              = $evento;
        $data['participantes']       = $evento->getEventoParticipante();
        $titulo                      = "Editar evento de calendario: ".$evento->getFechaInicio()->format('Y-m-d')." - ".$evento->getFechaFin()->format('Y-m-d');
        $data['titulo']              = $titulo;
        $data['id']                  = $id;

        return $this->render('ChecnesRegistroBundle:Evento:edit.html.twig', $data);
    }

    /**
     * @Route("/{id}/update", name="evento_update")
     * @Method({"GET", "POST"})
     */
    public function updateAction(Request $request, $id)
    {   
        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();

        //ld($request);exit();

        $entity = $em->getRepository('ChecnesRegistroBundle:Evento')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Evento entity.');
        }

        $anio         = $session->get("anio");
        $usuario_id     = $session->get("usuario_id");
        $reg_asistencia = $request->request->get('reg_asistencia');

        //if (strtolower($entity->getCondicion()) != 'finalizo' && strtolower($entity->getCondicion()) != 'cancelado') {

            //if (strtolower($entity->getCondicion()) != 'cancelado') {

                $obj_tipa = $em->getRepository('ChecnesRegistroBundle:TipoActividad')->find($request->request->get('tipo_actividad'));
                $obj_usu = $em->getRepository('ChecnesRegistroBundle:Usuario')->find($usuario_id);

                $entity->setTipoActividad($obj_tipa);
                $entity->setCondicion($request->request->get('condicion'));
                $entity->setFechaInicio(new \DateTime($request->request->get('fecha')));
                $entity->setFechaFin(new \DateTime($request->request->get('fecha_fin')));
                $entity->setFechaCreacion(new \DateTime(date('Y-m-d')));
                $entity->setDescripcion($request->request->get('detalle'));
                $entity->setHoraInicio($request->request->get('hora_inicio'));
                $entity->setHoraFinal($request->request->get('hora_final'));
                $entity->setTipoPersona($request->request->get('tipo_persona'));
                $entity->setUsuario($obj_usu);
                $entity->setAnio($anio);
                $em->persist($entity);
                $em->flush();

                //Eliminamos y Resgistramos participantes
                $participantes = $request->request->get('codigo_participantes');
                $participantes = explode('-', $participantes);

                $obj_participantes = $entity->getEventoParticipante();
                if (is_object($obj_participantes)) {
                    foreach ($obj_participantes as $key => $parti) {

                        $em->remove($parti);

                    }
                    $em->flush();
                }
                //Fin eliminar y registrar
                         

                if ($participantes !='') {

                    $obj_evento = $em->getRepository('ChecnesRegistroBundle:Evento')->find($entity->getId());

                    for ($i=0; $i < count($participantes); $i++) {

                        if ($participantes[$i] !='') {

                            $obj_per = $em->getRepository('ChecnesRegistroBundle:Persona')->find($participantes[$i]);

                            $responsable = ($request->request->get('perresp_'.$participantes[$i]))?true:false;

                            $participante = new EventoParticipante();
                            $participante->setPersona($obj_per);
                            $participante->setUsuario($obj_usu);
                            $participante->setEvento($obj_evento);
                            $participante->setFechaCreacion(new \DateTime(date('Y-m-d H:i:s')));
                            $participante->setFechaActualizacion(new \DateTime(date('Y-m-d H:i:s')));
                            $participante->setResponsable($responsable);
                            $em->persist($participante);
                        }
                       
                    }

                    $em->flush();
                }
                //Fin registro participante

            //}else{

            //    $entity->setCondicion($request->request->get('condicion'));
            //    $em->persist($entity);
            //    $em->flush(); 
            //}
        //}
        
        if ($reg_asistencia == 'REG_ASISTENCIA') {
            return $this->redirectToRoute("asistenciaevento_index",array('evento'=>$id));
        }else{
            return $this->redirectToRoute("evento_index");
        }
        
    }

    /**
     *
     * @Route("/show", name="evento_show")
     * @Method("POST")
     */
    public function showAction(Request $request){

        $em = $this->getDoctrine()->getManager();

        $id = $request->request->get('evento_id');

        $evento = $em->getRepository('ChecnesRegistroBundle:Evento')->find($id);

        $data['evento']              = $evento;
        $titulo                      = "Visualizar evento de calendario: ".$evento->getFechaInicio()->format('Y-m-d')." - ".$evento->getFechaFin()->format('Y-m-d');
        $data['titulo']              = $titulo;
        return $this->render('ChecnesRegistroBundle:Evento:show.html.twig', $data);
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

            $obj_participantes = $entity->getEventoParticipante();
            if (is_object($obj_participantes)) {
                foreach ($obj_participantes as $key => $parti) {
                    $em->remove($parti);
                }
                $em->flush();
            }
        }
        
        return new JsonResponse(array('exito' => 'exito'));

        //ld($entity);
    }

    /**
     * @Route("/buscarpersona", name="evento_buscarpersona")
     * @Method({"GET"})
     */
    public function buscarPersonaAction(Request $request)
    {   
        $em = $this->getDoctrine()->getManager();

        $conn = $this->get('database_connection');

        $es_dirigente = ($request->request->get('tipoP') == 'dirigente')?'1':'1,0';
        $term         = $request->request->get('term');

        $sql = "SELECT *,
                CONCAT(apellido_paterno,' ',apellido_materno,', ',nombre)AS label,
                CONCAT(apellido_paterno,' ',apellido_materno,',',nombre)AS value
                FROM persona WHERE es_dirigente IN($es_dirigente) AND (nombre LIKE '%$term%' OR apellido_paterno LIKE '%$term%' OR apellido_materno LIKE '%$term%') LIMIT 5";

        $resp = $conn->executeQuery($sql)->fetchAll();

        $array = array();
        foreach ($resp as $key => $row) {
            $array[] = $row;//array('value'=>10,'label'=>'Juan');
        }
        //return json_encode($resp);

        return new JsonResponse($array);
    }
}