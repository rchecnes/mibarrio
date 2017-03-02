<?php

namespace Checnes\RegistroBundle\Controller;

use Checnes\RegistroBundle\Entity\TipoActividad;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Tipoactividad controller.
 *
 * @Route("tipoactividad")
 */
class TipoActividadController extends Controller
{
    /**
     * Lists all tipoActividad entities.
     *
     * @Route("/", name="tipoactividad_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tipoActividads = $em->getRepository('ChecnesRegistroBundle:TipoActividad')->findAll();

        return $this->render('tipoactividad/index.html.twig', array(
            'tipoActividads' => $tipoActividads,
        ));
    }

    /**
     * Creates a new tipoActividad entity.
     *
     * @Route("/new", name="tipoactividad_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tipoActividad = new Tipoactividad();
        $form = $this->createForm('Checnes\RegistroBundle\Form\TipoActividadType', $tipoActividad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tipoActividad);
            $em->flush($tipoActividad);

            return $this->redirectToRoute('tipoactividad_show', array('id' => $tipoActividad->getId()));
        }

        return $this->render('tipoactividad/new.html.twig', array(
            'tipoActividad' => $tipoActividad,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a tipoActividad entity.
     *
     * @Route("/{id}", name="tipoactividad_show")
     * @Method("GET")
     */
    public function showAction(TipoActividad $tipoActividad)
    {
        $deleteForm = $this->createDeleteForm($tipoActividad);

        return $this->render('tipoactividad/show.html.twig', array(
            'tipoActividad' => $tipoActividad,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing tipoActividad entity.
     *
     * @Route("/{id}/edit", name="tipoactividad_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TipoActividad $tipoActividad)
    {
        $deleteForm = $this->createDeleteForm($tipoActividad);
        $editForm = $this->createForm('Checnes\RegistroBundle\Form\TipoActividadType', $tipoActividad);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tipoactividad_edit', array('id' => $tipoActividad->getId()));
        }

        return $this->render('tipoactividad/edit.html.twig', array(
            'tipoActividad' => $tipoActividad,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a tipoActividad entity.
     *
     * @Route("/{id}", name="tipoactividad_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TipoActividad $tipoActividad)
    {
        $form = $this->createDeleteForm($tipoActividad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tipoActividad);
            $em->flush($tipoActividad);
        }

        return $this->redirectToRoute('tipoactividad_index');
    }

    /**
     * Creates a form to delete a tipoActividad entity.
     *
     * @param TipoActividad $tipoActividad The tipoActividad entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TipoActividad $tipoActividad)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tipoactividad_delete', array('id' => $tipoActividad->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
