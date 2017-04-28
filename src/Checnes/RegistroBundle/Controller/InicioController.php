<?php

namespace Checnes\RegistroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Inicio controller.
 *
 * @Route("inicio")
 */
class InicioController extends Controller
{
	/**
     * @Route("/", name="inicio_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        /*$em = $this->getDoctrine()->getManager();

        $rols = $em->getRepository('ChecnesRegistroBundle:Rol')->findAll();*/

        $data_meses  = array();
        $data_evento_faena = array();
        $data_evento_reunion = array();
        $data_evento_salida = array();
        $mes_actual  = date('m');

        foreach ($this->getMeses() as $key => $m) {
        	if ($m['id'] <= $mes_actual) {
        		$data_meses[] = $m['abrev'];
        		$data_evento_faena[] = rand(1,4);
                $data_evento_reunion[] = rand(1,4);
                $data_evento_salida[] = rand(1,4);
        	}
        }
        
        return $this->render('inicio/index.html.twig', array(
            'titulo'             => 'Inicio',
            'data_meses'         => json_encode($data_meses),
            'data_evento_faena'  => json_encode($data_evento_faena),
            'data_evento_reunion'=> json_encode($data_evento_reunion),
            'data_evento_salida' => json_encode($data_evento_salida)
        ));
    }

    private function getMeses(){

    	$meses = array(
    		array('id'=>'01', 'nombre'=>'Enero', 'abrev'     =>'Ene'),
    		array('id'=>'02', 'nombre'=>'Febrero', 'abrev'   =>'Feb'),
    		array('id'=>'03', 'nombre'=>'Marzo', 'abrev'     =>'Mar'),
    		array('id'=>'04', 'nombre'=>'Abril', 'abrev'     =>'Abr'),
    		array('id'=>'05', 'nombre'=>'Mayo', 'abrev'      =>'May'),
    		array('id'=>'06', 'nombre'=>'Junio', 'abrev'     =>'Jun'),
    		array('id'=>'07', 'nombre'=>'Julio', 'abrev'     =>'Jul'),
    		array('id'=>'08', 'nombre'=>'Agosto', 'abrev'    =>'Ago'),
    		array('id'=>'09', 'nombre'=>'Septiembre', 'abrev'=>'Sep'),
    		array('id'=>'10', 'nombre'=>'Octubre', 'abrev'   =>'Oct'),
    		array('id'=>'11', 'nombre'=>'Noviembre', 'abrev' =>'Nov'),
    		array('id'=>'12', 'nombre'=>'Diciembre', 'abrev' =>'Dic')
    	);

    	return $meses;
    }
}
