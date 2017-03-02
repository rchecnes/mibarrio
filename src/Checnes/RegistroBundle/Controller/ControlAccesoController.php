<?php

namespace Checnes\RegistroBundle\Controller;

use Checnes\RegistroBundle\Entity\ControlAcceso;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Controlacceso controller.
 *
 * @Route("controlacceso")
 */
class ControlAccesoController extends Controller
{
    /**
     * Lists all controlAcceso entities.
     *
     * @Route("/", name="controlacceso_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $controlAccesos = $em->getRepository('ChecnesRegistroBundle:ControlAcceso')->findAll();

        return $this->render('controlacceso/index.html.twig', array(
            'controlAccesos' => $controlAccesos,
        ));
    }

    /**
     * Creates a new controlAcceso entity.
     *
     * @Route("/new", name="controlacceso_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $controlAcceso = new Controlacceso();
        $form = $this->createForm('Checnes\RegistroBundle\Form\ControlAccesoType', $controlAcceso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($controlAcceso);
            $em->flush($controlAcceso);

            return $this->redirectToRoute('controlacceso_show', array('id' => $controlAcceso->getId()));
        }

        return $this->render('controlacceso/new.html.twig', array(
            'controlAcceso' => $controlAcceso,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a controlAcceso entity.
     *
     * @Route("/{id}", name="controlacceso_show")
     * @Method("GET")
     */
    public function showAction(ControlAcceso $controlAcceso)
    {
        $deleteForm = $this->createDeleteForm($controlAcceso);

        return $this->render('controlacceso/show.html.twig', array(
            'controlAcceso' => $controlAcceso,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing controlAcceso entity.
     *
     * @Route("/{id}/edit", name="controlacceso_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ControlAcceso $controlAcceso)
    {
        $deleteForm = $this->createDeleteForm($controlAcceso);
        $editForm = $this->createForm('Checnes\RegistroBundle\Form\ControlAccesoType', $controlAcceso);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('controlacceso_edit', array('id' => $controlAcceso->getId()));
        }

        return $this->render('controlacceso/edit.html.twig', array(
            'controlAcceso' => $controlAcceso,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a controlAcceso entity.
     *
     * @Route("/{id}", name="controlacceso_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ControlAcceso $controlAcceso)
    {
        $form = $this->createDeleteForm($controlAcceso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($controlAcceso);
            $em->flush($controlAcceso);
        }

        return $this->redirectToRoute('controlacceso_index');
    }

    /**
     * Creates a form to delete a controlAcceso entity.
     *
     * @param ControlAcceso $controlAcceso The controlAcceso entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ControlAcceso $controlAcceso)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('controlacceso_delete', array('id' => $controlAcceso->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
