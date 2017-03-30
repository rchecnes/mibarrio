<?php

namespace Checnes\RegistroBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Checnes\RegistroBundle\Entity\Lote;
use Checnes\RegistroBundle\Form\LoteType;

/**
 * Lote controller.
 *
 * @Route("/lote")
 */
class LoteController extends Controller
{
    /**
     * Lists all Lote entities.
     *
     * @Route("/", name="lote_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $lotes = $em->getRepository('ChecnesRegistroBundle:Lote')->findAll();

        return $this->render('ChecnesRegistroBundle:Lote:index.html.twig', array(
            'lotes' => $lotes,
            'titulo' => 'Lote'
        ));
    }

    /**
     * Creates a new Lote entity.
     *
     * @Route("/new", name="lote_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $lote = new Lote();
        $form = $this->createForm('Checnes\RegistroBundle\Form\LoteType', $lote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($lote);
            $em->flush();

            return $this->redirectToRoute('lote_show', array('id' => $lote->getId()));
        }

        return $this->render('ChecnesRegistroBundle:Lote:new.html.twig', array(
            'lote' => $lote,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Lote entity.
     *
     * @Route("/{id}", name="lote_show")
     * @Method("GET")
     */
    public function showAction(Lote $lote)
    {
        $deleteForm = $this->createDeleteForm($lote);

        return $this->render('ChecnesRegistroBundle:Lote:show.html.twig', array(
            'lote' => $lote,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Lote entity.
     *
     * @Route("/{id}/edit", name="lote_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Lote $lote)
    {
        $deleteForm = $this->createDeleteForm($lote);
        $editForm = $this->createForm('Checnes\RegistroBundle\Form\LoteType', $lote);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($lote);
            $em->flush();

            return $this->redirectToRoute('lote_edit', array('id' => $lote->getId()));
        }

        return $this->render('ChecnesRegistroBundle:Lote:edit.html.twig', array(
            'lote' => $lote,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Lote entity.
     *
     * @Route("/{id}", name="lote_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Lote $lote)
    {
        $form = $this->createDeleteForm($lote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($lote);
            $em->flush();
        }

        return $this->redirectToRoute('lote_index');
    }

    /**
     * Creates a form to delete a Lote entity.
     *
     * @param Lote $lote The Lote entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Lote $lote)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('lote_delete', array('id' => $lote->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
