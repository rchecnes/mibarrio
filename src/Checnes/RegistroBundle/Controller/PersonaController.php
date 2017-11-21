<?php

namespace Checnes\RegistroBundle\Controller;

use Checnes\RegistroBundle\Entity\Persona;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

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
    public function indexAction(Request $request)
    {
        
        $em = $this->getDoctrine()->getManager();
        $dql   = "SELECT p FROM ChecnesRegistroBundle:Persona p WHERE p.estado=1";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        return $this->render('persona/index.html.twig', array(
            //'personas' => $personas,
            'titulo' => 'Personas',
            'pagination' => $pagination
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
        $form    = $this->createForm('Checnes\RegistroBundle\Form\PersonaType', $persona);

        return $this->render('persona/new.html.twig', array(
            'persona' => $persona,
            'titulo'  => 'Nueva Persona',
            'form'    => $form->createView(),
        ));
    }


    /**
     * Creates a new persona entity.
     *
     * @Route("/sav", name="persona_sav")
     * @Method({"GET", "POST"})
     */
    public function savAction(Request $request)
    {   
        $form    = $request->request->get('checnes_registrobundle_persona');
        $session = $request->getSession();

        if ($form) {
            
            $em = $this->getDoctrine()->getManager();
            $persona = new Persona();
            $persona->setDni($form['dni']);
            $persona->setNombre($form['nombre']);
            $persona->setApellidoPaterno($form['apellido_paterno']);
            $persona->setApellidoMaterno($form['apellido_materno']);
            $persona->setNumero($form['numero']);
            $es_dirigente = (isset($form['es_dirigente']))?$form['es_dirigente']:0;
            $persona->setEsDirigente($es_dirigente);
            $activo = (isset($form['activo']))?$form['activo']:0;
            $persona->setActivo($activo);
            $persona->setEstado(1);
            $persona->setAnio($session->get('anio'));
            $persona->setEstadoCivil($form['estado_civil']);

            $obj_lote  = $em->getRepository('ChecnesRegistroBundle:Lote')->find($form['lote']);
            $obj_cargo = $em->getRepository('ChecnesRegistroBundle:Cargo')->find($form['cargo']);

            $persona->setLote($obj_lote);
            $persona->setCargo($obj_cargo);
            $persona->setFechaCrea(new \DateTime(date('Y-m-d h:i:s')));
            
            $em->persist($persona);
            $em->flush($persona);

            $session->getFlashBag()->add("success",'La persona se creo de manera correcta!.');

        }else{
            $session->getFlashBag()->add("error",'Ocurrio un error!');
        }

        return $this->redirectToRoute('persona_index');
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

        $editForm = $this->createForm('Checnes\RegistroBundle\Form\PersonaType', $persona);

        return $this->render('persona/edit.html.twig', array(
            'edit_form' => $editForm->createView(),
            'titulo'    => 'Editar Persona',
            'id'        => $persona->getId()
        ));
    }

    /**
     * Displays a form to edit an existing persona entity.
     *
     * @Route("/{id}/update", name="persona_update")
     * @Method({"GET", "POST"})
     */
    public function updateAction(Request $request, Persona $persona)
    {

        $form    = $request->request->get('checnes_registrobundle_persona');
        $session = $request->getSession();

        if ($form) {
            
            $em = $this->getDoctrine()->getManager();
            $persona->setDni($form['dni']);
            $persona->setNombre($form['nombre']);
            $persona->setApellidoPaterno($form['apellido_paterno']);
            $persona->setApellidoMaterno($form['apellido_materno']);
            $persona->setNumero($form['numero']);
            $es_dirigente = (isset($form['es_dirigente']))?$form['es_dirigente']:0;
            $persona->setEsDirigente($es_dirigente);
            $activo = (isset($form['activo']))?$form['activo']:0;
            $persona->setActivo($activo);
            $persona->setEstado(1);
            $persona->setAnio($session->get('anio'));
            $persona->setEstadoCivil($form['estado_civil']);

            $obj_lote  = $em->getRepository('ChecnesRegistroBundle:Lote')->find($form['lote']);
            $obj_cargo = $em->getRepository('ChecnesRegistroBundle:Cargo')->find($form['cargo']);

            $persona->setLote($obj_lote);
            $persona->setCargo($obj_cargo);
            $persona->setFechaMod(new \DateTime(date('Y-m-d h:i:s')));
            
            $em->persist($persona);
            $em->flush($persona);

            $session->getFlashBag()->add("success",'La persona se creo de manera correcta!.');

        }else{
            $session->getFlashBag()->add("error",'Ocurrio un error!');
        }

        return $this->redirectToRoute('persona_index');
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
