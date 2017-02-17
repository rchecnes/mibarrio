<?php
namespace Checnes\RegistroBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
//use Symfony\Component\HttpFoundation\Session\Session;
use Checnes\RegistroBundle\Entity\Evento;
use Checnes\RegistroBundle\Form\AsistenciaEventoType;
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
    public function indexAction()
    {   
        $em = $this->getDoctrine()->getManager();

        $request = $this->getRequest();
        $session = $request->getSession();

        $usuario_id = $session->get("usuario_id");
        $ano_id     = $session->get("ano_id");

		$form = $this->createForm(new AsistenciaEventoType(), null, array());

    	return $this->render('ChecnesRegistroBundle:AsistenciaEvento:index.html.twig', array(
            'personas' => '',
            'titulo'=>'Asistencia a evento',
            //'evento_html' =>$evento_html,
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

        $ano_id = $session->get("ano_id");
        $tipo_persona = $request->query->get('tipo');
        //Listado de eventos
        $evento = "SELECT e FROM ChecnesRegistroBundle:Evento e";
        $evento .= " WHERE e.condicion != 'cancelado'";
        $evento .= " AND e.estado=1";
        $evento .= " AND e.ano=:ano";
        $evento .= " AND e.tipo_persona=:tipo_persona";

        $res_evento = $em->createQuery($evento)
        ->setParameter('ano',$ano_id)
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

        $response = new JsonResponse();

        $personas = array();

        $dql = "SELECT p FROM ChecnesRegistroBundle:Persona p";
        //$dql .= " WHERE p.empresa=:empresa";


        $respuesta = $em->createQuery($dql)->getResult();

        foreach ($respuesta as $entity) {
            $personas[] = array(
                'id'=>$entity->getId(),
                'nombre'=>$entity->getNombre(),
                'apellido_paterno'=>$entity->getApellidoPaterno()
            );
        }


        $response->setData($personas);

        return $response;
    }

    /**
     *
     * @Route("/savasistencia", name="sav_asistencia")
     * @Method("POST")
     */
    public function savAsistenciaAction(Request $request)
    {
        //$params = $request->request;

        ld($request->request);
    }
}

?>