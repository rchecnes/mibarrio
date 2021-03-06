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
     * @Route("/login", name="login")
     */
    public function indexAction(){

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
     * @Route("/check", name="login_check")
     */
    public function checkAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();
        $usuario  = $request->request->get('usuario');
        $password = $request->request->get('password');
        $remenber = $request->request->get('remenber');

        $entity = $em->getRepository('ChecnesRegistroBundle:Usuario')->findOneBy(array('usuario'=>$usuario,'estado'=>1));

        if (is_object($entity)) {

            if ($entity->getActivo() == 1) {

                $obj_acso = $em->getRepository('ChecnesRegistroBundle:ControlAcceso')->findOneBy(array('usuario'=>$entity->getId()));

                if (md5($password) == $entity->getSalt()) {

                    $session = $request->getSession();

                    if(!$this->container->get('session')->isStarted())
                    {
                        $session = new Session();
                        $session->start();
                    }

                    //Actualizar el ultimo acceso
                    $entity->setUltimoAcceso(new \DateTime(date('Y-m-d h:i:sa')));

                    //Sesion
                    $session->set('user',$entity);
                    $session->set('rol_id',$entity->getRol()->getId());
                    $session->set('rol_nombre',$entity->getRol()->getNombre());
                    $session->set('rol_nombre_sis',$entity->getRol()->getNombreSis());
                    $session->set('usuario_id',$entity->getId());
                    $session->set('anio',date('Y'));
                    $session->set('persona_id',$entity->getPersona()->getId());
                    $session->set('nombre',$entity->getPersona()->getNombre());
                    $session->set('nombre_completo',$entity->getPersona()->getNombre().' '.$entity->getPersona()->getApellidoPaterno().' '.$entity->getPersona()->getApellidoMaterno());

                    //Set cookie
                    $this->setCookie($usuario,$password,$remenber);
                    

                    //Registramos acceso;
                    $acceso = new ControlAcceso();
                    
                    $acceso->setUsuario($entity);
                    $acceso->setFechaAcceso(new \DateTime(date('Y-m-d h:i:sa')));
                    $acceso->setIp($this->ObtenerIP());
                    $acceso->setAnio(date('Y'));
                    $em->persist($acceso);
                    $em->flush();
                    

                    if (is_object($obj_acso)==false && $entity->getRol()->getNombre() !='DEMO' && $entity->getRol()->getNombre() !='demo') {

                        return $this->redirectToRoute("acceso_change_password");
                    }else{

                        $conn = $this->get('database_connection');
                        //Obtenemos la ruta por defecto
                        $rol_id=$entity->getRol()->getId();

                        $sql = "SELECT * FROM menu_x_rol mxr
                        INNER JOIN menu m ON(mxr.menu_id=m.id)
                        WHERE mxr.rol_id=$rol_id AND mxr.defecto=1";
                      
                        $resp = $conn->executeQuery($sql)->fetchAll();

                        $ruta_def = '';
                        foreach ($resp as $key => $f) {
                            $ruta_def = $f['enlace'];
                        }

                        if ($ruta_def!='') {
                            return $this->redirect($ruta_def);
                        }else{
                            $session->getFlashBag()->add("error",'No tiene definido perfil para ingresar');
                            return $this->redirectToRoute("login");
                        }
                    }

                }else{
                    $session->getFlashBag()->add("error",'Usuario o clave incorrecto');
                    return $this->redirectToRoute("login");

                }
            }else{
                $session->getFlashBag()->add("error",'El usuario está deshabilitado');
                return $this->redirectToRoute("login");
            }
        }else{
            $session->getFlashBag()->add("error",'Usuario o clave incorrecto');
            return $this->redirectToRoute("login");
        }
        
    }


    private function setCookie($usuario, $password, $cookie=null){
        
        if($cookie == 'on'){
            setcookie("usuario", $usuario, time()+3600*24);
            setcookie("password", $password, time()+3600*24);
            setcookie("remenber", "checked='checked'", time()+3600*24);
        }else {

            setcookie('usuario', null, -1);
            setcookie('password', null, -1);
            setcookie('remenber', null, -1);

            unset($_COOKIE['usuario']);
            unset($_COOKIE['password']);
            unset($_COOKIE['remenber']);
        }
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
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
    public function changePasswordAction(Request $request)
    {
        $session = $request->getSession();

        $em = $this->getDoctrine()->getManager();

        $obj_user = $em->getRepository('ChecnesRegistroBundle:Usuario')->find($session->get('usuario_id'));

        return $this->render('ChecnesRegistroBundle:Login:changePassword.html.twig', array('titulo'=>'Actualizar Usuario | Contraseña','entity'=>$obj_user));
    }

    /**
     * @Route("/updatepassword", name="acceso_update_password")
     */
    public function updatePasswordAction(Request $request)
    {
        $em      = $this->getDoctrine()->getManager();
        $session = $request->getSession();

        $entity = $em->getRepository('ChecnesRegistroBundle:Usuario')->find($session->get('usuario_id'));

        $password_ant_sis = $entity->getSalt();
        $new_password = md5($request->request->get('password'));
        $ant_password = md5($request->request->get('password_anterior'));
        $user_name = $request->request->get('user_name');
        //ld($ant_password."---".$password_ant_sis);exit();
        if ($ant_password == $password_ant_sis) {
            
            $entity->setPassword($request->request->get('password'));
            $entity->setSalt($new_password);
            $entity->setUsuario($user_name);

            $em->persist($entity);
            $em->flush();

            $session->getFlashBag()->add("success",'La contraseña se actualizó correctamente!');

        }else{

            $session->getFlashBag()->add("error",'La contraseña anterior no coincide con la nueva contraseña');
            
        }

        return $this->render('ChecnesRegistroBundle:Login:changePassword.html.twig', array('titulo'=>'Actualizar Usuario | Contraseña','entity'=>$entity));
        
    }


    private function ObtenerIP(){

        $client  = @$_SERVER['HTTP_CLIENT_IP']; 
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR']; 
        $remote  = $_SERVER['REMOTE_ADDR']; 

        $ip= gethostbyname( gethostbyaddr($_SERVER['REMOTE_ADDR']) );
        return ($ip !='')?$ip:"20.20.20.20";
    }
}
