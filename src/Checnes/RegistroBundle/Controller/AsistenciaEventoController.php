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

        $dql  = "SELECT e FROM ChecnesRegistroBundle:Evento e
                INNER JOIN e.tipo_actividad a
                INNER JOIN a.tipo_tipo_actividad ta
                WHERE e.estado IN(1,2)
                AND ta.nombre_sistema='asistencia'
                ORDER BY e.estado,e.fecha_inicio DESC";
        $resp = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $resp, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

    	return $this->render('ChecnesRegistroBundle:AsistenciaEvento:index.html.twig', array(
            'personas' => '',
            'titulo'   =>'Tomar Asistencia',
            'pagination'   => $pagination
        ));
    }

    /**
     * Lists all Lote entities.
     *
     * @Route("/aportacion", name="asistenciaevento_aportacion")
     * @Method("GET")
     */
    public function aportacionAction(Request $request)
    {   
        $em = $this->getDoctrine()->getManager();

        $request = $this->getRequest();
        $session = $request->getSession();

        $usuario_id = $session->get("usuario_id");
        $anio       = $session->get("anio");

        $dql  = "SELECT e FROM ChecnesRegistroBundle:Evento e
                INNER JOIN e.tipo_actividad a
                INNER JOIN a.tipo_tipo_actividad ta
                WHERE e.estado=1
                AND e.estado NOT IN(5)
                AND (ta.nombre_sistema='tesoreria' OR e.multa=1)
                ORDER BY e.fecha_inicio DESC";
        $resp = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $resp, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        return $this->render('ChecnesRegistroBundle:RegistrarAportacion:index.html.twig', array(
            'personas'   => '',
            'titulo'     =>'Listado de Aportación / Cobro',
            'pagination' => $pagination
        ));
    }

     /**
     * @Route("/listpersona", name="asistenciaevento_listapersona")
     * @Method({"GET", "POST"})
     */
    public function listaPersonaAction(Request $request)
    { 
        $em = $this->getDoctrine()->getManager();

        $request = $this->getRequest();
        $session = $request->getSession();

        //Variables
        $block = $request->query->get('block');

        $evento = $em->getRepository('ChecnesRegistroBundle:Evento')->find($request->query->get('evento'));

        $dql = "SELECT p FROM ChecnesRegistroBundle:Persona p";
        if ($evento->getTipoPersona() == 'dirigente') {
            $dql .= " WHERE p.es_dirigente=1";
        }
        $dql .= " ORDER BY p.numero ASC";
        
        $respuesta     = $em->createQuery($dql)->getResult();

        $participantes = $evento->getEventoParticipante();

        $personas = array();

        if (count($participantes) == 0 ) {
            //echo "llega arriba";
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
            //echo "llega abajo";
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
            'titulo'   => ($block=='NO')?'Registrar Asistencia':'Visualizar Asistencia',
            'block'   => $block,
            'evento'   => $evento
        ));
    }

    /**
     *
     * @Route("/guardarasistencia", name="asistenciaevento_guardar")
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

                $obj_asist->setFechaMod(new \DateTime(date('Y-m-d h:i:sa')));
                $obj_asist->setUsuarioMod($obj_usu);
                $em->persist($obj_asist);
                
            }else{

                $obj_pers   = $em->getRepository('ChecnesRegistroBundle:Persona')->find($persona_id);

                $entityAsEv = new AsistenciaEvento();

                $entityAsEv->setEvento($obj_evnt);
                $entityAsEv->setPersona($obj_pers);
                $entityAsEv->setFechaCrea(new \DateTime(date('Y-m-d h:i:sa')));
                $entityAsEv->setAsistio($asistio);
                $entityAsEv->setTardanza($tardanza);
                $entityAsEv->setAnio($anio);
                $entityAsEv->setUsuarioCrea($obj_usu);
                $entityAsEv->setEstado(1);
                $em->persist($entityAsEv);
            }
        }
        $em->flush();

        //ld($request->request->get("guardarcerrar"));exit();
        if ($request->request->get("guardarcerrar")=='guardarcerrar') {
           
           $resp = $this->registrarCuentasCobrar($obj_evnt->getId());

        }else{

        }

        

        return $this->redirectToRoute("asistenciaevento_index");
    }


    private function registrarCuentasCobrar($id_evento){

        $conn = $this->get('database_connection');

        //Consultamos a las personas que no asistieron al evento

        $sql = "SELECT * FROM persona WHERE id NOT IN( SELECT persona_id FROM asistencia_evento WHERE evento_id='$id_evento')";

        $resp = $conn->executeQuery($sql)->fetchAll();

        $array = array();
        foreach ($resp as $key => $row) {
            $array[] = $row;//array('value'=>10,'label'=>'Juan');
        }
        //return json_encode($resp);
    }

    
}

?>