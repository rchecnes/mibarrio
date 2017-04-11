<?php

namespace Checnes\RegistroBundle\Controller;

use Checnes\RegistroBundle\Entity\Persona;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Persona controller.
 *
 * @Route("persona")
 */
class PersonaController extends Controller
{
    /**
     * Lists all persona entities.
     *
     * @Route("/", name="persona_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $personas = $em->getRepository('ChecnesRegistroBundle:Persona')->findAll();

        return $this->render('persona/index.html.twig', array(
            'personas' => $personas,
            'titulo' => 'Personas'
        ));
    }

    /**
     * Creates a new persona entity.
     *
     * @Route("/new", name="persona_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $persona = new Persona();
        $form = $this->createForm('Checnes\RegistroBundle\Form\PersonaType', $persona);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($persona);
            $em->flush($persona);

            return $this->redirectToRoute('persona_show', array('id' => $persona->getId()));
        }

        return $this->render('persona/new.html.twig', array(
            'persona' => $persona,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a persona entity.
     *
     * @Route("/{id}", name="persona_show")
     * @Method("GET")
     */
    public function showAction(Persona $persona)
    {
        $deleteForm = $this->createDeleteForm($persona);

        return $this->render('persona/show.html.twig', array(
            'persona' => $persona,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing persona entity.
     *
     * @Route("/{id}/edit", name="persona_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Persona $persona)
    {

        $deleteForm = $this->createDeleteForm($persona);
        $editForm = $this->createForm('Checnes\RegistroBundle\Form\PersonaType', $persona);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('persona_edit', array('id' => $persona->getId()));
        }

        return $this->render('persona/edit.html.twig', array(
            'persona' => $persona,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit perfil an existing persona entity.
     *
     * @Route("/{id}/editperfil", name="persona_editperfil")
     * @Method({"GET", "POST"})
     */
    public function editPerfilAction(Request $request, Persona $persona)
    {
       
        $editForm = $this->createForm('Checnes\RegistroBundle\Form\PersonaPerfilType', $persona);

        return $this->render('persona/editPerfil.html.twig', array(
            'persona'   => $persona,
            'edit_form' => $editForm->createView(),
            'titulo'    => 'Editar Información',
            'id' => $persona->getId()
        ));
    }

    /**
     * Displays a form to sav perfil an existing persona entity.
     *
     * @Route("/{id}/savperfil", name="persona_savperfil")
     * @Method({"GET", "POST"})
     */
    public function savPerfilAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();

        $persona = $em->getRepository('ChecnesRegistroBundle:Persona')->find($id);
        
        if (is_object($persona)) {

            $info = $request->request->get('checnes_registrobundle_persona_perfil');

            $persona->setNombre($info['nombre']);
            $persona->setApellidoPaterno($info['apellido_paterno']);
            $persona->setApellidoMaterno($info['apellido_materno']);
            $persona->setDni($info['dni']);
            $persona->setEstadoCivil($info['estado_civil']);

            $em->persist($persona);
            $em->flush();

            $session->getFlashBag()->add("success",'Su información se actualizó.');
        }else{
            $session->getFlashBag()->add("error",'Ocurrió un error');
        }

        return $this->redirectToRoute('persona_editperfil', array('id' => $persona->getId()));
    }

    /**
     * Deletes a persona entity.
     *
     * @Route("/{id}", name="persona_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Persona $persona)
    {
        $form = $this->createDeleteForm($persona);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($persona);
            $em->flush($persona);
        }

        return $this->redirectToRoute('persona_index');
    }

    /**
     * Creates a form to delete a persona entity.
     *
     * @param Persona $persona The persona entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Persona $persona)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('persona_delete', array('id' => $persona->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
