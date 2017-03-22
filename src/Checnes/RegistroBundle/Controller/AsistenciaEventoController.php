<?php
namespace Checnes\RegistroBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Checnes\RegistroBundle\Form\AsistenciaEventoType;
use Checnes\RegistroBundle\Entity\AsistenciaEvento;

/**
 * Evento controller.
 *
 * @Route("/asistenciaevento")
 */
class AsistenciaEventoController extends Controller
{
    /**
     * Lists all Lote entities.
     *
     * @Route("/", name="asistenciaevento_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {   
        $em = $this->getDoctrine()->getManager();

        $request = $this->getRequest();
        $session = $request->getSession();

        $usuario_id = $session->get("usuario_id");
        $anio       = $session->get("anio");

        $evento_id    = '';
        if ($request->query->get('evento') !=null) {
            
            $obj_evnt = $em->getRepository('ChecnesRegistroBundle:Evento')->find($request->query->get('evento'));
            $evento_id = $obj_evnt->getId();
        }

		$form = $this->createForm(new AsistenciaEventoType(), null, array());

    	return $this->render('ChecnesRegistroBundle:AsistenciaEvento:index.html.twig', array(
            'personas' => '',
            'titulo'=>'Asistencia a evento',
            'evento_id' => $evento_id,
            'form'=>$form->createView()
        ));
    }

    /**
     * Lists all Lote entities.
     *
     * @Route("/getevento", name="get_evento")
     * @Method("GET")
     */
    public function getEventoAction(Request $request)
    {   
        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();

        $anio = $session->get("anio");
        $tipo_persona = $request->query->get('tipo');
        //Listado de eventos
        $evento = "SELECT e FROM ChecnesRegistroBundle:Evento e";
        $evento .= " WHERE e.condicion != 'cancelado'";
        $evento .= " AND e.estado=1";
        $evento .= " AND e.anio=:anio";
        $evento .= " AND e.tipo_persona=:tipo_persona";

        $res_evento = $em->createQuery($evento)
        ->setParameter('anio',$anio)
        ->setParameter('tipo_persona', $tipo_persona)
        ->getResult();

        $response = new JsonResponse();

        $eventos = array();

        foreach ($res_evento as $entity) {
            $eventos[] = array('id'=>$entity->getId(), 'nombre'=>$entity->getNombre());
        }
        
        $response->setData($eventos);

        return $response;
    }

    /**
     *
     * @Route("/listadopersona", name="listado_persona")
     * @Method("GET")
     */
    public function listaPersonasAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $request = $this->getRequest();
        $session = $request->getSession();

        $evento = $em->getRepository('ChecnesRegistroBundle:Evento')->find($request->query->get('evento_id'));

        $dql = "SELECT p FROM ChecnesRegistroBundle:Persona p";
        if ($evento->getTipoPersona() == 'dirigente') {
            $dql .= " WHERE p.es_dirigente=1";
        }
        $dql .= " ORDER BY p.numero ASC";
        
        $respuesta     = $em->createQuery($dql)->getResult();

        $participantes = $evento->getEventoParticipante();

        $personas = array();

        if (count($participantes) == 0 ) {

            foreach ($respuesta as $key => $entity) {

                $obj_asist  = $em->getRepository('ChecnesRegistroBundle:AsistenciaEvento')->findOneBy(array('evento'=>$evento->getId(),'persona'=>$entity->getId()));

                $asistio    = (is_object($obj_asist))?$obj_asist->getAsistio():0;

                $tardanza   =  (is_object($obj_asist) && $obj_asist->getTardanza() == true)?$obj_asist->getTardanza():0;

                $personas[] = array(
                                'id'=>$entity->getId(),
                                'dni'=>$entity->getDni(),
                                'numero'=>$entity->getNumero(),
                                'nombres'=>$entity->getApellidoPaterno().' '.$entity->getApellidoMaterno().', '.$entity->getNombre(),
                                'asistio' => $asistio,
                                'tardanza' => $tardanza
                                );
            }

        }else{

            foreach ($participantes as $key => $entity) {  

                $obj_asist  = $em->getRepository('ChecnesRegistroBundle:AsistenciaEvento')->findOneBy(array('evento'=>$entity->getEvento()->getId(),'persona'=>$entity->getPersona()->getId()));

                $asistio    = (is_object($obj_asist))?$obj_asist->getAsistio():0;

                $tardanza   =  (is_object($obj_asist) && $obj_asist->getTardanza() == true)?$obj_asist->getTardanza():0;

                $personas[] = array(
                                'id'=>$entity->getPersona()->getId(),
                                'dni'=>$entity->getPersona()->getDni(),
                                'numero'=>$entity->getPersona()->getNumero(),
                                'nombres'=>$entity->getPersona()->getApellidoPaterno().' '.$entity->getPersona()->getApellidoMaterno().', '.$entity->getPersona()->getNombre(),
                                'asistio' => $asistio,
                                'tardanza' => $tardanza
                                );
            }
        }
        

        return $this->render('ChecnesRegistroBundle:AsistenciaEvento:listaPersona.html.twig', array(
            'personas' => $personas,
            'evento'=>$request->query->get('evento_id')
        ));
    }

    /**
     *
     * @Route("/savasistencia", name="sav_asistencia")
     * @Method("POST")
     */
    public function savAsistenciaAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        //$request = $this->getRequest();
        $session = $request->getSession();
        $anio  = $session->get("anio");
        $usuario_id = $session->get("usuario_id");

        $count_personas = $request->request->get('count_personas');
        $evento_id      = $request->request->get('evento');

        $obj_evnt = $em->getRepository('ChecnesRegistroBundle:Evento')->find($evento_id);
        
        $obj_usu = $em->getRepository('ChecnesRegistroBundle:Usuario')->find($usuario_id);                                  


        for ($i=1; $i <= $count_personas; $i++) { 
            
            $persona_id = $request->request->get('persona_'.$i);

            $obj_asist  = $em->getRepository('ChecnesRegistroBundle:AsistenciaEvento')->findOneBy(array('evento'=>$evento_id,'persona'=>$persona_id));

            $asistio    = $request->request->get('asistio_'.$i);
            $asistio    = ($asistio == true)?true:false;

            $tardanza    = $request->request->get('tardanza_'.$i);
            $tardanza    = ($tardanza == true)?true:false;
            
            if (is_object($obj_asist)) {

                if ($obj_asist->getAsistio() != $asistio) {
                    $obj_asist->setAsistio($asistio);
                }
                if ($obj_asist->getTardanza() != $tardanza) {
                    $obj_asist->setTardanza($tardanza);
                }

                $obj_asist->setFechaModificacion(new \DateTime(date('Y-m-d h:i:sa')));
                $em->persist($obj_asist);
                
            }else{

                $obj_pers   = $em->getRepository('ChecnesRegistroBundle:Persona')->find($persona_id);

                $entityAsEv = new AsistenciaEvento();

                $entityAsEv->setEvento($obj_evnt);
                $entityAsEv->setPersona($obj_pers);
                $entityAsEv->setFechaCreacion(new \DateTime(date('Y-m-d h:i:sa')));
                $entityAsEv->setFechaModificacion(new \DateTime(date('Y-m-d h:i:sa')));
                $entityAsEv->setAsistio($asistio);
                $entityAsEv->setTardanza($tardanza);
                $entityAsEv->setAnio($anio);
                $entityAsEv->setUsuario($obj_usu);
                $entityAsEv->setEstado(true);
                $em->persist($entityAsEv);
            }
        }

        
        $em->flush();

        return $this->redirectToRoute("asistenciaevento_index",array('evento'=>$evento_id));
    }

    
}

?>