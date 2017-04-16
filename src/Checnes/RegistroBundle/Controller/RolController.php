<?php

namespace Checnes\RegistroBundle\Controller;

use Checnes\RegistroBundle\Entity\Rol;
use Checnes\RegistroBundle\Entity\MenuXRol;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Rol controller.
 *
 * @Route("rol")
 */
class RolController extends Controller
{
    /**
     * Lists all rol entities.
     *
     * @Route("/", name="rol_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $rols = $em->getRepository('ChecnesRegistroBundle:Rol')->findAll();

        return $this->render('rol/index.html.twig', array(
            'rols' => $rols,
            'titulo' => 'Rol'
        ));
    }

    /**
     * Creates a new rol entity.
     *
     * @Route("/new", name="rol_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $rol = new Rol();
        $form = $this->createForm('Checnes\RegistroBundle\Form\RolType', $rol);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($rol);
            $em->flush();

            return $this->redirectToRoute('rol_show', array('id' => $rol->getId()));
        }

        return $this->render('rol/new.html.twig', array(
            'rol' => $rol,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a rol entity.
     *
     * @Route("/{id}", name="rol_show")
     * @Method("GET")
     */
    public function showAction(Rol $rol)
    {
        $deleteForm = $this->createDeleteForm($rol);

        return $this->render('rol/show.html.twig', array(
            'rol' => $rol,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing rol entity.
     *
     * @Route("/{id}/edit", name="rol_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Rol $rol)
    {
        $deleteForm = $this->createDeleteForm($rol);
        $editForm = $this->createForm('Checnes\RegistroBundle\Form\RolType', $rol);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rol_edit', array('id' => $rol->getId()));
        }

        return $this->render('rol/edit.html.twig', array(
            'rol' => $rol,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Lists all rol entities.
     *
     * @Route("/{id}/permiso", name="rol_permiso")
     * @Method("GET")
     */
    public function permisoAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        /*$dql   = "SELECT m FROM ChecnesRegistroBundle:Menu m ORDER BY m.orden DESC";
        $menus = $em->createQuery($dql)->getResult();*/
        $menu = "<table class='table table-bordered'>";
        $menu .= "<thead>";
        $menu .= "<tr><th>Nombre</th><th>Permiso</th><th>Defecto</th></tr>";
        $menu .= "</thead>";
        $menu .= $this->getMenuPermiso('',0, $id);
        $menu .= "</table>";

        return $this->render('rol/permiso.html.twig', array(
            'menus'   => $menu,//$this->getMenuPermiso(0),
            'titulo' => 'Asignar Permiso',
            'rol_id' => $id
        ));
    }

    private function getMenuPermiso($espacio, $padre=0, $rol_id){

        $conn = $this->get('database_connection');

        $sql = "SELECT * FROM menu WHERE padre=$padre ORDER BY orden DESC";
        $resp = $conn->executeQuery($sql)->fetchAll();

        if(empty($resp)){return "";}

        $menu = array();

        $array_menu_x_rol = $this->getMenuXRol($rol_id);

        $menu = "";
        $espacio .= ($espacio !='' && $padre !=0)?$espacio."&nbsp;&nbsp;":"";
        foreach ($resp as $key => $m) {
            //Si es que ya se ingreso el permiso
            $activo  = (in_array($m['id'], $array_menu_x_rol))?'checked="checked"':'';
        
            

            $oculto  = (in_array($m['id'], $array_menu_x_rol))?'style="display:block"':'style="display:none"'; 

            $icono = ($m['css_icono'] !='')?$m['css_icono']:"fa-circle";

            if ($m['tiene_hijo'] == 0) {

                //Defecto si ya se guardo permiso
                $defecto = $this->getDefecto($rol_id, $m['id']);
                $defecto = ($defecto == 1)?"checked='checked'":"";

                $menu .= "<tr>";
                    $menu .= "<td>".$espacio;
                    $menu .= "<a href='#'>";
                    $menu .= "<i class='menu-icon fa ".$icono."'></i><span class='menu-text'>&nbsp;&nbsp;".$m['nombre']."</span>";
                    $menu .= "</a>";
                    $menu .= "</td>";
                    $menu .= "<td><input type='checkbox' id='check_".$m['id']."' name='check_".$m['id']."' onclick='add(".$m['id'].",".$m['tiene_hijo'].")' value='".$m['id']."' ".$activo."></td>";
                    $menu .= "<td><input type='radio' ".$oculto." id='defecto_".$m['id']."' name='defecto' value='".$m['id']."' ".$defecto."></td>";
                $menu .= "</tr>";

            }else{
                $menu .= "<tr>";
                    $menu .= "<td>".$espacio;
                    $menu .= "<a href='#' class='dropdown-toggle'>";
                    $menu .= "<i class='menu-icon fa ".$icono."'></i><span class='menu-text'>&nbsp;&nbsp;".$m['nombre']."</span>";
                    $menu .= "</a>";
                    $menu .= "</td>";
                    $menu .= "<td><input type='checkbox' id='check_".$m['id']."' name='check_".$m['id']."' onclick='add(".$m['id'].",".$m['tiene_hijo'].")' value='".$m['id']."'".$activo."></td>";
                    $menu .= "<td>&nbsp;</td>";
                $menu .= "</tr>";
                $menu .= $this->getMenuPermiso($espacio.'&nbsp;&nbsp;',$m['id'], $rol_id);
            }
        }
        
        return $menu;
    }

    private function getMenuXRol($rol_id){

        $conn = $this->get('database_connection');
        $sql  = "SELECT * FROM menu_x_rol WHERE rol_id=$rol_id";
        $resp = $conn->executeQuery($sql)->fetchAll();

        $menu    = array();
        $defecto = "";

        foreach ($resp as $key => $m) {
            $menu[] = $m['menu_id'];
            if ($m['defecto']==1) {
                $defecto = $m['menu_id'];
            }
            
        }

        return $menu;
    }

    private function getDefecto($rol_id, $menu_id){

        $conn = $this->get('database_connection');
        $sql  = "SELECT * FROM menu_x_rol WHERE rol_id=$rol_id AND menu_id=$menu_id";
        $resp = $conn->executeQuery($sql)->fetchAll();
        $defecto = 0;
        foreach ($resp as $key => $c) {
            $defecto = $c['defecto'];
        }
        return $defecto;
    }

    /**
     * Lists all sav entities.
     *
     * @Route("/savpermiso", name="rol_savpermiso")
     * @Method("POST")
     */
    public function savPermisoAction(Request $request)
    {   

        $session = $request->getSession();
        $em   = $this->getDoctrine()->getManager();
        $form = $request->request;

        $rol_id          = $form->get('rol_id');
        $menu_grupo_id   = $form->get('menu_grupo_id');
        $menu_default_id = $form->get('menu_default_id');

        $explode_menu = explode(',', $menu_grupo_id);

        //Eliminamos antes los permisos existentes
        $conn = $this->get('database_connection');
        $sql  = "DELETE FROM menu_x_rol WHERE rol_id=$rol_id";
        $conn->executeQuery($sql);
        //Fin eliminar

       $objrol = $em->getRepository('ChecnesRegistroBundle:Rol')->find($rol_id);

        for ($i=0; $i < count($explode_menu); $i++) { 
            
            $acceso = new MenuXRol();

            $objmenu = $em->getRepository('ChecnesRegistroBundle:Menu')->find($explode_menu[$i]);

            $acceso->setRol($objrol);
            $acceso->setMenu($objmenu);
            $acceso->setEstado(1);
            if ($explode_menu[$i]==$menu_default_id) {
                $acceso->setDefecto(1);
            }else{
                $acceso->setDefecto(0);
            }            

            $em->persist($acceso);
        }

        $em->flush();

        
        $session->getFlashBag()->add("success",'Permiso Asignado!');

        return $this->redirectToRoute('rol_permiso', array('id'=>$rol_id));
    }


    /**
     * Deletes a rol entity.
     *
     * @Route("/{id}", name="rol_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Rol $rol)
    {
        $form = $this->createDeleteForm($rol);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($rol);
            $em->flush();
        }

        return $this->redirectToRoute('rol_index');
    }

    /**
     * Creates a form to delete a rol entity.
     *
     * @param Rol $rol The rol entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Rol $rol)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('rol_delete', array('id' => $rol->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
