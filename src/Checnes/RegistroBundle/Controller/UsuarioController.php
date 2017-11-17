<?php

namespace Checnes\RegistroBundle\Controller;

use Checnes\RegistroBundle\Entity\Usuario;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Usuario controller.
 *
 * @Route("usuario")
 */
class UsuarioController extends Controller
{
    /**
     * Lists all usuario entities.
     *
     * @Route("/", name="usuario_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $usuarios = $em->getRepository('ChecnesRegistroBundle:Usuario')->findAll();

        return $this->render('usuario/index.html.twig', array(
            'usuarios' => $usuarios,
            'titulo'   =>'Usuarios'
        ));
    }

    /**
     * Creates a new usuario entity.
     *
     * @Route("/new", name="usuario_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $usuario = new Usuario();
        $form    = $this->createForm('Checnes\RegistroBundle\Form\UsuarioType', $usuario);

        $data['usuario'] = $usuario;
        $data['form']    = $form->createView();
        $data['titulo']  = "Nuevo Usuario";

        return $this->render('usuario/new.html.twig', $data);
    }

    /**
     * @Route("/listapersona", name="usuario_listapersona")
     * @Method({"GET"})
     */
    public function listaPersonaAction(Request $request)
    {   
        $em = $this->getDoctrine()->getManager();

        $conn = $this->get('database_connection');

        $term         = $request->query->get('term');

        $sql = "SELECT id,numero,dni,
                CONCAT(apellido_paterno,' ',apellido_materno,', ',nombre)AS label,
                CONCAT(apellido_paterno,' ',apellido_materno,',',nombre)AS value
                FROM persona WHERE activo=1 AND estado=1 AND id NOT IN(SELECT persona_id FROM usuario) AND (nombre LIKE '%$term%' OR apellido_paterno LIKE '%$term%' OR apellido_materno LIKE '%$term%') LIMIT 5";

        $resp = $conn->executeQuery($sql)->fetchAll();

        $array = array();
        foreach ($resp as $key => $row) {
            $array[] = $row;//array('value'=>10,'label'=>'Juan');
        }
        //return json_encode($resp);
        return new JsonResponse($array);
    }

    /**
     * Finds and displays a usuario entity.
     *
     * @Route("/{id}", name="usuario_show")
     * @Method("GET")
     */
    public function showAction(Usuario $usuario)
    {
        $deleteForm = $this->createDeleteForm($usuario);

        return $this->render('usuario/show.html.twig', array(
            'usuario' => $usuario,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing usuario entity.
     *
     * @Route("/{id}/edit", name="usuario_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Usuario $usuario)
    {
        $deleteForm = $this->createDeleteForm($usuario);
        $editForm = $this->createForm('Checnes\RegistroBundle\Form\UsuarioType', $usuario);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('usuario_edit', array('id' => $usuario->getId()));
        }

        return $this->render('usuario/edit.html.twig', array(
            'usuario' => $usuario,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a usuario entity.
     *
     * @Route("/{id}", name="usuario_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Usuario $usuario)
    {
        $form = $this->createDeleteForm($usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($usuario);
            $em->flush();
        }

        return $this->redirectToRoute('usuario_index');
    }

    /**
     * Creates a form to delete a usuario entity.
     *
     * @param Usuario $usuario The usuario entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Usuario $usuario)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('usuario_delete', array('id' => $usuario->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
