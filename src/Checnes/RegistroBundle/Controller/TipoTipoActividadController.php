<?php

namespace Checnes\RegistroBundle\Controller;

use Checnes\RegistroBundle\Entity\TipoTipoActividad;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Tipotipoactividad controller.
 *
 * @Route("tipotipoactividad")
 */
class TipoTipoActividadController extends Controller
{
    /**
     * Lists all tipoTipoActividad entities.
     *
     * @Route("/", name="tipotipoactividad_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tipoTipoActividads = $em->getRepository('ChecnesRegistroBundle:TipoTipoActividad')->findAll();

        return $this->render('tipotipoactividad/index.html.twig', array(
            'tipoTipoActividads' => $tipoTipoActividads,
        ));
    }

    /**
     * Creates a new tipoTipoActividad entity.
     *
     * @Route("/new", name="tipotipoactividad_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tipoTipoActividad = new Tipotipoactividad();
        $form = $this->createForm('Checnes\RegistroBundle\Form\TipoTipoActividadType', $tipoTipoActividad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tipoTipoActividad);
            $em->flush();

            return $this->redirectToRoute('tipotipoactividad_show', array('id' => $tipoTipoActividad->getId()));
        }

        return $this->render('tipotipoactividad/new.html.twig', array(
            'tipoTipoActividad' => $tipoTipoActividad,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a tipoTipoActividad entity.
     *
     * @Route("/{id}", name="tipotipoactividad_show")
     * @Method("GET")
     */
    public function showAction(TipoTipoActividad $tipoTipoActividad)
    {
        $deleteForm = $this->createDeleteForm($tipoTipoActividad);

        return $this->render('tipotipoactividad/show.html.twig', array(
            'tipoTipoActividad' => $tipoTipoActividad,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing tipoTipoActividad entity.
     *
     * @Route("/{id}/edit", name="tipotipoactividad_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TipoTipoActividad $tipoTipoActividad)
    {
        $deleteForm = $this->createDeleteForm($tipoTipoActividad);
        $editForm = $this->createForm('Checnes\RegistroBundle\Form\TipoTipoActividadType', $tipoTipoActividad);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tipotipoactividad_edit', array('id' => $tipoTipoActividad->getId()));
        }

        return $this->render('tipotipoactividad/edit.html.twig', array(
            'tipoTipoActividad' => $tipoTipoActividad,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a tipoTipoActividad entity.
     *
     * @Route("/{id}", name="tipotipoactividad_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TipoTipoActividad $tipoTipoActividad)
    {
        $form = $this->createDeleteForm($tipoTipoActividad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tipoTipoActividad);
            $em->flush();
        }

        return $this->redirectToRoute('tipotipoactividad_index');
    }

    /**
     * Creates a form to delete a tipoTipoActividad entity.
     *
     * @param TipoTipoActividad $tipoTipoActividad The tipoTipoActividad entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TipoTipoActividad $tipoTipoActividad)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tipotipoactividad_delete', array('id' => $tipoTipoActividad->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
