<?php

namespace Checnes\RegistroBundle\Controller;

use Checnes\RegistroBundle\Entity\CajaBanco;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Cajabanco controller.
 *
 * @Route("cajabanco")
 */
class CajaBancoController extends Controller
{
    /**
     * Lists all cajaBanco entities.
     *
     * @Route("/", name="cajabanco_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cajaBancos = $em->getRepository('ChecnesRegistroBundle:CajaBanco')->findAll();

        return $this->render('cajabanco/index.html.twig', array(
            'cajaBancos' => $cajaBancos,
            'titulo' => 'Caja Banco'
        ));
    }

    /**
     * Creates a new cajaBanco entity.
     *
     * @Route("/new", name="cajabanco_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $cajaBanco = new Cajabanco();
        $form = $this->createForm('Checnes\RegistroBundle\Form\CajaBancoType', $cajaBanco);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cajaBanco);
            $em->flush();

            return $this->redirectToRoute('cajabanco_index');
        }

        return $this->render('cajabanco/new.html.twig', array(
            'cajaBanco' => $cajaBanco,
            'form' => $form->createView(),
            'titulo' => 'Nuevo Caja Banco'

        ));
    }

    /**
     * Finds and displays a cajaBanco entity.
     *
     * @Route("/{id}", name="cajabanco_show")
     * @Method("GET")
     */
    public function showAction(CajaBanco $cajaBanco)
    {
        $deleteForm = $this->createDeleteForm($cajaBanco);

        return $this->render('cajabanco/show.html.twig', array(
            'cajaBanco' => $cajaBanco,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cajaBanco entity.
     *
     * @Route("/{id}/edit", name="cajabanco_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CajaBanco $cajaBanco)
    {
        $deleteForm = $this->createDeleteForm($cajaBanco);
        $editForm = $this->createForm('Checnes\RegistroBundle\Form\CajaBancoType', $cajaBanco);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cajabanco_index');
        }

        return $this->render('cajabanco/edit.html.twig', array(
            'cajaBanco' => $cajaBanco,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'titulo' => 'Nuevo Caja Banco'
        ));
    }

    /**
     * Deletes a cajaBanco entity.
     *
     * @Route("/{id}", name="cajabanco_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CajaBanco $cajaBanco)
    {
        $form = $this->createDeleteForm($cajaBanco);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cajaBanco);
            $em->flush();
        }

        return $this->redirectToRoute('cajabanco_index');
    }

    /**
     * Creates a form to delete a cajaBanco entity.
     *
     * @param CajaBanco $cajaBanco The cajaBanco entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CajaBanco $cajaBanco)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cajabanco_delete', array('id' => $cajaBanco->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
