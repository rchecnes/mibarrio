<?php

namespace Checnes\RegistroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Checnes\RegistroBundle\Entity\Usuario;
use Checnes\RegistroBundle\Entity\ControlAcceso;
use Symfony\Component\HttpFoundation\Session\Session;

class LoginController extends Controller
{
    /**
     * @Route("/", name="acceso")
     */
    public function indexAction()
    {

        $em = $this->getDoctrine()->getManager();

        $usuario = (isset($_COOKIE['usuario']))? $_COOKIE['usuario']: '';
        $password = (isset($_COOKIE['password']))? $_COOKIE['password']: '';
        $remenber = (isset($_COOKIE['remenber']))? $_COOKIE['remenber'] : '';

        //$obj_rol = $em->getRepository('ChecnesRegistroBundle:Rol')->find(1);

        return $this->render('ChecnesRegistroBundle:Login:login.html.twig', array(
            'titulo'=>'Login',
            'usuario'=>$usuario,
            'password'=>$password,
            'remenber'=>$remenber
        ));
    }

    /**
     * @Route("/validarusuario", name="validar_usuario")
     */
    public function validarUsuarioAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
    
        $usuario = $request->request->get('usuario');
        $password = $request->request->get('password');
        $remenber = $request->request->get('remenber');

        $entity = $em->getRepository('ChecnesRegistroBundle:Usuario')->findOneBy(array('usuario'=>$usuario));

        if (is_object($entity)) {
            
            $obj_acso = $em->getRepository('ChecnesRegistroBundle:ControlAcceso')->findOneBy(array('usuario'=>$entity->getId()));

            if (md5($password) == $entity->getSalt()) {

                $session = $request->getSession();

                if(!$this->container->get('session')->isStarted())
                {
                    $session = new Session();
                    $session->start();
                } 

                $session->set('user',$entity);
                
                //set and get session attributes
                //$session->set('user', $entity);
                //$session->set('nombre_completo', $entity->getPersona()->getApellidoPaterno().' '.$entity->getPersona()->getApellidoMaterno().' '.$entity->getPersona()->getNombre());

                //$session->set('empresa_id', $entity->getEmpresa()->getId());
                //$session->set('usuario_id', $entity->getId());
                //$session->set('anio', $entity->getAnio());
                

                //Set cookie
                $this->setCookie($usuario,$password,$remenber);

                //Registramos acceso;
                $acceso = new ControlAcceso();
                $acceso->setUsuario($entity);
                $acceso->setFechaAcceso(new \DateTime(date('Y-m-d h:i:sa')));
                $acceso->setIp('200.200.200.200');
                $acceso->setAnio(date('Y'));
                $em->persist($acceso);
                $em->flush();
                

                if (!is_object($obj_acso)) {
                    return $this->redirectToRoute("acceso_change_password");
                }else{
                    return $this->redirectToRoute("evento_index");
                }

            }else{
                return $this->redirectToRoute("acceso");
            }
        }else{
            return $this->redirectToRoute("acceso");
        }
        
    }


    private function setCookie($usuario, $password, $cookie=null){
        
        if($cookie == 'on'){
            setcookie("usuario", $usuario, time()+3600*24);
            setcookie("password", $password, time()+3600*24);
            setcookie("remenber", "checked='checked'", time()+3600*24);
        }else {

            //ld("llega");
            setcookie('usuario', null, -1);
            setcookie('password', null, -1);
            setcookie('remenber', null, -1);

            unset($_COOKIE['usuario']);
            unset($_COOKIE['password']);
            unset($_COOKIE['remenber']);
        }
    }

    /**
     * @Route("/cerrarsesion", name="cerrar_sesion")
     */
    public function cerrarSesionAction()
    {
        
    	//ld("holaaaa validando");

        $session = $this->get('session');
        $ses_vars = $session->all();

        foreach ($ses_vars as $key => $value) {
            $session->remove($key);
        }

        return $this->redirectToRoute("acceso");
    }

    /**
     * @Route("/newuser", name="new_user")
     */
    public function newAction()
    {

        $em = $this->getDoctrine()->getManager();

        
        //$obj_rol = $em->getRepository('ChecnesRegistroBundle:Rol')->find(1);

        return $this->render('ChecnesRegistroBundle:Login:new.html.twig', array(
            'titulo'=>'Nueva cuenta',
            
        ));
    }

    /**
     * @Route("/createuser", name="create_user")
     */
    public function createAction()
    {

        $em = $this->getDoctrine()->getManager();

        
        //$obj_rol = $em->getRepository('ChecnesRegistroBundle:Rol')->find(1);

        return $this->render('ChecnesRegistroBundle:Login:new.html.twig', array(
            'titulo'=>'Nueva cuenta',
        ));
    }

    /**
     * @Route("/changepassword", name="acceso_change_password")
     */
    public function changePasswordAction()
    {

        $em = $this->getDoctrine()->getManager();

        
        //$obj_rol = $em->getRepository('ChecnesRegistroBundle:Rol')->find(1);

        return $this->render('ChecnesRegistroBundle:Login:changePassword.html.twig', array('titulo'=>'Le Recomendamos Actualizar Su Contraseña'));
    }

    /**
     * @Route("/updatepassword", name="acceso_update_password")
     */
    public function updatePasswordAction(Request $request)
    {
        $em      = $this->getDoctrine()->getManager();
        $session = $request->getSession();
        $anio    = $session->get("anio");
        $usuario = $session->get("usuario_id");

        $entity = $em->getRepository('ChecnesRegistroBundle:Usuario')->find($usuario);

        $entity->setPassword($request->request->get('password'));
        $entity->setSalt(md5($request->request->get('password')));
        $em->persist($entity);
        $em->flush();

        return $this->redirectToRoute("evento_index");
    }
}
