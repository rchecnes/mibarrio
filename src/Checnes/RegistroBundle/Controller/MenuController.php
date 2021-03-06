<?php

namespace Checnes\RegistroBundle\Controller;

use Checnes\RegistroBundle\Entity\Menu;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Menu controller.
 *
 * @Route("menu")
 */
class MenuController extends Controller
{
    /**
     * Lists all menu entities.
     *
     * @Route("/", name="menu_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $menus = $em->getRepository('ChecnesRegistroBundle:Menu')->findAll();
        
        return $this->render('menu/index.html.twig', array(
            'menus' => $menus,
            'titulo' => 'Menú'
        ));
    }

    private function getMenuPadre(){
         //Menu
        $em  = $this->getDoctrine()->getManager();
        $dql = "SELECT m FROM ChecnesRegistroBundle:Menu m WHERE m.estado=1 AND m.tiene_hijo=1 ORDER BY m.orden DESC";
        $resp = $em->createQuery($dql)->getResult();

        $padre = array('0'=>'Ninguno');
        foreach ($resp as $key => $f) {
            $padre[$f->getId()] = $f->getNombre();
        }

        return $padre;
    }

    /**
     * Creates a new menu entity.
     *
     * @Route("/new", name="menu_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {  
        $session = $request->getSession();

        $padreM = $this->getMenuPadre();
        $menu = new Menu();
        $form = $this->createForm('Checnes\RegistroBundle\Form\MenuType', $menu, array('padreM'=>$padreM));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($menu);
            $em->flush($menu);

            $session->getFlashBag()->add("success",'El nuevo registro se creo con éxito.');

            return $this->redirectToRoute('menu_index', array('id' => $menu->getId()));

        }

        return $this->render('menu/new.html.twig', array(
            'menu' => $menu,
            'titulo' => 'Nuevo Menú',
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a menu entity.
     *
     * @Route("/{id}", name="menu_show")
     * @Method("GET")
     */
    public function showAction(Menu $menu)
    {
        $deleteForm = $this->createDeleteForm($menu);

        return $this->render('menu/show.html.twig', array(
            'menu' => $menu,
            'titulo' => 'Ver Menú',
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing menu entity.
     *
     * @Route("/{id}/edit", name="menu_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Menu $menu)
    {   
        $session = $request->getSession();

        $padreM = $this->getMenuPadre();
        $deleteForm = $this->createDeleteForm($menu);
        $editForm = $this->createForm('Checnes\RegistroBundle\Form\MenuType', $menu, array('padreM'=>$padreM));
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $session->getFlashBag()->add("success",'El registro se editó con éxito.');

            return $this->redirectToRoute('menu_index', array('id' => $menu->getId()));
        }

        return $this->render('menu/edit.html.twig', array(
            'menu' => $menu,
            'titulo' => 'Editar Menú',
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a menu entity.
     *
     * @Route("/{id}/delete", name="menu_delete")
     * @Method({"DELETE","GET", "POST"})
     */
    public function deleteAction(Request $request, Menu $menu)
    {
        $session = $request->getSession();
        
        if (is_object($menu)) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($menu);
            $em->flush($menu);

            $session->getFlashBag()->add("success",'El registro se elimino con éxito.');
        }

        return $this->redirectToRoute('menu_index');
        
    }

    /**
     * Creates a form to delete a menu entity.
     *
     * @param Menu $menu The menu entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Menu $menu)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('menu_delete', array('id' => $menu->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
