<?php

namespace Checnes\RegistroBundle\Controller;

use Checnes\RegistroBundle\Entity\MenuXRol;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Menuxrol controller.
 *
 * @Route("menuxrol")
 */
class MenuXRolController extends Controller
{
    /**
     * Lists all menuXRol entities.
     *
     * @Route("/", name="menuxrol_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $menuXRols = $em->getRepository('ChecnesRegistroBundle:MenuXRol')->findAll();

        return $this->render('menuxrol/index.html.twig', array(
            'menuXRols' => $menuXRols,
        ));
    }

    /**
     * Creates a new menuXRol entity.
     *
     * @Route("/new", name="menuxrol_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $menuXRol = new Menuxrol();
        $form = $this->createForm('Checnes\RegistroBundle\Form\MenuXRolType', $menuXRol);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($menuXRol);
            $em->flush($menuXRol);

            return $this->redirectToRoute('menuxrol_show', array('id' => $menuXRol->getId()));
        }

        return $this->render('menuxrol/new.html.twig', array(
            'menuXRol' => $menuXRol,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a menuXRol entity.
     *
     * @Route("/{id}", name="menuxrol_show")
     * @Method("GET")
     */
    public function showAction(MenuXRol $menuXRol)
    {
        $deleteForm = $this->createDeleteForm($menuXRol);

        return $this->render('menuxrol/show.html.twig', array(
            'menuXRol' => $menuXRol,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing menuXRol entity.
     *
     * @Route("/{id}/edit", name="menuxrol_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, MenuXRol $menuXRol)
    {
        $deleteForm = $this->createDeleteForm($menuXRol);
        $editForm = $this->createForm('Checnes\RegistroBundle\Form\MenuXRolType', $menuXRol);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('menuxrol_edit', array('id' => $menuXRol->getId()));
        }

        return $this->render('menuxrol/edit.html.twig', array(
            'menuXRol' => $menuXRol,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a menuXRol entity.
     *
     * @Route("/{id}", name="menuxrol_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MenuXRol $menuXRol)
    {
        $form = $this->createDeleteForm($menuXRol);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($menuXRol);
            $em->flush($menuXRol);
        }

        return $this->redirectToRoute('menuxrol_index');
    }

    /**
     * Creates a form to delete a menuXRol entity.
     *
     * @param MenuXRol $menuXRol The menuXRol entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MenuXRol $menuXRol)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('menuxrol_delete', array('id' => $menuXRol->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
