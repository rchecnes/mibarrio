<?php

namespace Checnes\RegistroBundle\Controller;

use Checnes\RegistroBundle\Entity\Cargo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Cargo controller.
 *
 * @Route("cargo")
 */
class CargoController extends Controller
{
    /**
     * Lists all cargo entities.
     *
     * @Route("/", name="cargo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cargos = $em->getRepository('ChecnesRegistroBundle:Cargo')->findAll();

        return $this->render('cargo/index.html.twig', array(
            'cargos' => $cargos,
        ));
    }

    /**
     * Creates a new cargo entity.
     *
     * @Route("/new", name="cargo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $cargo = new Cargo();
        $form = $this->createForm('Checnes\RegistroBundle\Form\CargoType', $cargo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cargo);
            $em->flush($cargo);

            return $this->redirectToRoute('cargo_show', array('id' => $cargo->getId()));
        }

        return $this->render('cargo/new.html.twig', array(
            'cargo' => $cargo,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a cargo entity.
     *
     * @Route("/{id}", name="cargo_show")
     * @Method("GET")
     */
    public function showAction(Cargo $cargo)
    {
        $deleteForm = $this->createDeleteForm($cargo);

        return $this->render('cargo/show.html.twig', array(
            'cargo' => $cargo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cargo entity.
     *
     * @Route("/{id}/edit", name="cargo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Cargo $cargo)
    {
        $deleteForm = $this->createDeleteForm($cargo);
        $editForm = $this->createForm('Checnes\RegistroBundle\Form\CargoType', $cargo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cargo_edit', array('id' => $cargo->getId()));
        }

        return $this->render('cargo/edit.html.twig', array(
            'cargo' => $cargo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a cargo entity.
     *
     * @Route("/{id}", name="cargo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Cargo $cargo)
    {
        $form = $this->createDeleteForm($cargo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cargo);
            $em->flush($cargo);
        }

        return $this->redirectToRoute('cargo_index');
    }

    /**
     * Creates a form to delete a cargo entity.
     *
     * @param Cargo $cargo The cargo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Cargo $cargo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cargo_delete', array('id' => $cargo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
