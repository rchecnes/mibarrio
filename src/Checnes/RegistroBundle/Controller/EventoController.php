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
    public function indexAction(){

        $em = $this->getDoctrine()->getManager();

        //$lotes = $em->getRepository('ChecnesRegistroBundle:Lote')->findAll();

        $dql = "SELECT e FROM ChecnesRegistroBundle:Evento e WHERE e.activo=1";
        $resp_dql = $em->createQuery($dql)->getResult();

        $evento = array();

        foreach ($resp_dql as $entity) {

            $background_color = '#f39c12';//color de pendiente
            $border_color = '#f39c12';

            //Estados
            if ($entity->getEstado()->getId()==1) { //Emitido
                $background_color = '#87b87f';
                $border_color = '#6d9865';
            }else if($entity->getEstado()->getId()==2){//Cerrado
                $background_color = '#d15b47';
                $border_color = '#6d9865';
            }else if($entity->getEstado()->getId()==3){//Cerrado
                $background_color = '#892e65';
                $border_color = '#6d9865';
            }


            $evento[] = array(
                'title'          =>ucwords($entity->getTipoActividad()->getNombre().': '.$entity->getTipoPersona()),//title for calendar
                'nombre'         =>"",//nombre for bd
                'description'    =>$entity->getDescripcion(),
                'start'          =>date_format($entity->getFechaInicio(), 'Y-m-d'),
                'end'            =>date_format($entity->getFechaFin(), 'Y-m-d'),
                'backgroundColor'=>$background_color,
                'border'    =>'1px solid '.$border_color,
                'class'          =>'evento_calendar',
                'id_event'       =>$entity->getId(),
                'detalle'        =>$entity->getDescripcion(),
                'tipo_actividad' =>$entity->getTipoActividad()->getId(),
                'estado'         =>$entity->getEstado()->getId(),
                'hora_inicio'    =>strtoupper(date_format($entity->getHoraInicio(),'g:i a')),
                'hora_final'     =>strtoupper(date_format($entity->getHoraFinal(),'g:i a')),
                'tipo_persona'   =>$entity->getTipoPersona()
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
     * @Method("POST|GET")
     */
    public function newAction(Request $request){

        $em = $this->getDoctrine()->getManager();

        $tipo_actividad = $em->getRepository('ChecnesRegistroBundle:TipoActividad')->findAll();
        $html_op_tipac = '';
        foreach ($tipo_actividad as $key => $entity) {
            $html_op_tipac .= '<option value="'.$entity->getId().'">'.$entity->getNombre().'</option>';
        }

        $data['tipo_actividad_html'] = $html_op_tipac;
        $data['fecha_inicio']        = $request->request->get('dayClick');
        $data['titulo']              = "Nuevo Evento: ".$request->request->get('dayClick');
        return $this->render('ChecnesRegistroBundle:Evento:new.html.twig', $data);
    }

    /**
     *
     * @Route("/create", name="evento_create")
     * @Method("POST")
     */
    public function createAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();

        $anio       = $session->get("anio");
        $usuario_id = $session->get("usuario_id");
        $entity     = new Evento();

        $obj_tipa = $em->getRepository('ChecnesRegistroBundle:TipoActividad')->find($request->request->get('tipo_actividad'));
        $obj_usu  = $em->getRepository('ChecnesRegistroBundle:Usuario')->find($usuario_id);
        $obj_stat = $em->getRepository('ChecnesRegistroBundle:Estado')->find($request->request->get('estado'));

        $multa = ($obj_tipa->getTipoTipoActividad()->getNombreSistema()=='tesoreria')?2:$request->request->get('multa');//2=aportacion no es multa

        $entity->setTipoActividad($obj_tipa);
        $entity->setEstado($obj_stat);
        $entity->setFechaInicio(new \DateTime($request->request->get('fecha_inicio')));
        $entity->setFechaFin(new \DateTime($request->request->get('fecha_fin')));
        $entity->setFechaCrea(new \DateTime(date('Y-m-d H:i:s')));
        $entity->setDescripcion($request->request->get('detalle'));
        $entity->setHoraInicio(new \DateTime($request->request->get('hora_inicio')) );
        $entity->setHoraFinal(new \DateTime($request->request->get('hora_final')) );
        $entity->setTipoPersona($request->request->get('tipo_persona'));
        $entity->setAsunto($request->request->get('asunto'));
        $entity->setUsuarioCrea($obj_usu);
        $entity->setAnio($anio);
        $entity->setMulta($multa);
        $entity->setMontoMulta($request->request->get('monto_multa'));
        $entity->setActivo(1);
        $em->persist($entity);
        $em->flush();

        //Resgistramos participantes
        $participantes = $request->request->get('codigo_participantes');
        $participantes = explode('-', $participantes);

        if ($participantes !='' && $request->request->get('tipo_persona') == 'seleccionar') {

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
            return $this->redirectToRoute("asistenciaevento_listapersona",array('evento'=>$entity->getId()));
        }else{

            if ($request->request->get('origen')) {
                return $this->redirectToRoute("evento_listado");
            }else{
                return $this->redirectToRoute("evento_index");
            }
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
        $titulo                      = "Editar Evento: ".$evento->getFechaInicio()->format('Y-m-d')." - ".$evento->getFechaFin()->format('Y-m-d');
        $data['titulo']              = $titulo;
        $data['id']                  = $id;

        return $this->render('ChecnesRegistroBundle:Evento:edit.html.twig', $data);
    }

    /**
     * @Route("/{id}/update", name="evento_update")
     * @Method({"GET", "POST"})
     */
    public function updateAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();

        //ld($request);exit();

        $entity = $em->getRepository('ChecnesRegistroBundle:Evento')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Evento entity.');
        }

        $anio           = $session->get("anio");
        $usuario_id     = $session->get("usuario_id");
        $reg_asistencia = $request->request->get('reg_asistencia');

        

        $obj_tipa = $em->getRepository('ChecnesRegistroBundle:TipoActividad')->find($request->request->get('tipo_actividad'));
        $obj_usu = $em->getRepository('ChecnesRegistroBundle:Usuario')->find($usuario_id);
        $obj_stat = $em->getRepository('ChecnesRegistroBundle:Estado')->find($request->request->get('estado'));

        $entity->setTipoActividad($obj_tipa);
        $entity->setEstado($obj_stat);
        $entity->setFechaInicio(new \DateTime($request->request->get('fecha_inicio')));
        $entity->setFechaFin(new \DateTime($request->request->get('fecha_fin')));
        $entity->setFechaMod(new \DateTime(date('Y-m-d H:i:s')));
        $entity->setDescripcion($request->request->get('detalle'));
        $entity->setHoraInicio(new \DateTime($request->request->get('hora_inicio')));
        $entity->setHoraFinal(new \DateTime($request->request->get('hora_final')));
        $entity->setTipoPersona($request->request->get('tipo_persona'));
        $entity->setAsunto($request->request->get('asunto'));
        $entity->setUsuarioMod($obj_usu);
        $entity->setAnio($anio);
        $entity->setMulta($request->request->get('multa'));
        $entity->setMontoMulta($request->request->get('monto_multa'));
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
                 

        if ($participantes !='' && $request->request->get('tipo_persona')=='seleccionar') {

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
        
        if ($reg_asistencia == 'REG_ASISTENCIA') {
            return $this->redirectToRoute("asistenciaevento_listapersona",array('evento'=>$id));
        }else{
            if ($request->request->get('origen')) {
                return $this->redirectToRoute("evento_listado");
            }else{
                return $this->redirectToRoute("evento_index");
            }
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
    public function deleteAction(Request $request){   
        $em         = $this->getDoctrine()->getManager();
        $session    = $request->getSession();
        $usuario_id = $session->get("usuario_id");

        $entity = $em->getRepository('ChecnesRegistroBundle:Evento')->find($request->request->get('id'));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Evento entity.');
        }

        if ($entity->getCondicion() == 'porconfirmar' || $entity->getCondicion() == 'cancelado') {

            $obj_usu = $em->getRepository('ChecnesRegistroBundle:Usuario')->find($usuario_id);

            $entity->setFechaElim(new \DateTime(date('Y-m-d H:i:s')));
            $entity->setUsuarioElim($obj_usu);
            $entity->setEstado(0);
            //$em->remove($entity);
            $em->persist($entity);
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
    public function buscarPersonaAction(Request $request){   
        $em = $this->getDoctrine()->getManager();

        $conn = $this->get('database_connection');

        $es_dirigente = ($request->query->get('tipoP') == 'dirigente')?'1':'1,0';
        $term         = $request->query->get('term');

        $sql = "SELECT id,numero,
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

    /**
     * @Route("/tipotipoac", name="evento_tipotipoactividad")
     * @Method({"GET"})
     */
    public function tipoTipoActividadAction(Request $request){
        //ld($request->query->get('tipo_actividad'));
        $em = $this->getDoctrine()->getManager();

        $obj_tiac = $em->getRepository('ChecnesRegistroBundle:TipoActividad')->find($request->query->get('tipo_actividad'));

        $array['tipo']        = $obj_tiac->getTipoTipoActividad()->getId();
        $array['tip_nom_sis'] = $obj_tiac->getTipoTipoActividad()->getNombreSistema();
        //return json_encode($resp);
        return new JsonResponse($array);
    }

    /**
     * Lists all Lote entities.
     *
     * @Route("/lista", name="evento_listado")
     * @Method("GET")
     */
    public function listadoAction(Request $request){
        
        $em = $this->getDoctrine()->getManager();

        $resp = $em->createQuery("SELECT e FROM ChecnesRegistroBundle:Evento e WHERE e.estado IN(1,2) ORDER BY e.fecha_inicio DESC");

        #$em    = $this->get('doctrine.orm.entity_manager');
        #$dql   = "SELECT a FROM AcmeMainBundle:Article a";
        #$query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $resp, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );
        
        $data['eventos'] = $resp;
        $data['pagination'] = $pagination;
        $data['titulo']  = "Listado de evento";

        return $this->render('ChecnesRegistroBundle:Evento:listado.html.twig',$data);
    }

    /**
     *
     * @Route("/newlistado", name="evento_newlistado")
     * @Method("POST|GET")
     */
    public function newListadoAction(Request $request){

        $em = $this->getDoctrine()->getManager();

        $tipo_actividad = $em->getRepository('ChecnesRegistroBundle:TipoActividad')->findAll();
        $html_op_tipac = '';
        foreach ($tipo_actividad as $key => $entity) {
            $html_op_tipac .= '<option value="'.$entity->getId().'">'.$entity->getNombre().'</option>';
        }

        $data['tipo_actividad_html'] = $html_op_tipac;
        $data['fecha_inicio']        = date('Y-m-d');
        $data['titulo']              = "Nuevo Evento: ".date('Y-m-d');

        return $this->render('ChecnesRegistroBundle:Evento:newListado.html.twig', $data);
    }

    /**
     *
     * @Route("/{id}/editlistado", name="evento_editlistado")
     * @Method("POST|GET")
     */
    public function editListadoAction(Request $request, $id){

        $em = $this->getDoctrine()->getManager();

        $evento = $em->getRepository('ChecnesRegistroBundle:Evento')->find($id);

        $tipo_actividad = $em->getRepository('ChecnesRegistroBundle:TipoActividad')->findAll();
        $html_op_tipac = '';
        foreach ($tipo_actividad as $key => $entity) {
            $selected = ($entity->getId()==$evento->getTipoActividad()->getId())?"selected='selected'":"";
            $html_op_tipac .= '<option value="'.$entity->getId().'" '.$selected.'>'.$entity->getNombre().'</option>';
        }       

        $evento = $em->getRepository('ChecnesRegistroBundle:Evento')->find($id);

        $data['tipo_actividad_html'] = $html_op_tipac;
        $data['evento']              = $evento;
        $data['participantes']       = $evento->getEventoParticipante();
        $data['titulo']              = "Editar Evento: ".$evento->getFechaInicio()->format('Y-m-d');

        return $this->render('ChecnesRegistroBundle:Evento:editListado.html.twig', $data);
    }

    /**
     *
     * @Route("/{id}/showlistado", name="evento_showlistado")
     * @Method("POST|GET")
     */
    public function showListadoAction(Request $request,$id){

        $em = $this->getDoctrine()->getManager();

        $origen_solic = ($request->query->get('origen')!=null)?$request->query->get('origen'):"";

        $evento = $em->getRepository('ChecnesRegistroBundle:Evento')->find($id);

        $data['evento']       = $evento;
        $data['titulo']       = "Visualizar Evento: ".$evento->getFechaInicio()->format('Y-m-d');
        $data['origen_solic'] = $origen_solic;
        return $this->render('ChecnesRegistroBundle:Evento:showListado.html.twig', $data);
    }
}