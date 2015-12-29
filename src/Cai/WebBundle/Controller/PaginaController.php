<?php

namespace Cai\WebBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Cai\WebBundle\Entity\Pagina;
use Cai\WebBundle\Form\PaginaType;

/**
 * Pagina controller.
 *
 */
class PaginaController extends Controller
{

    /**
     * Lists all Pagina entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CaiWebBundle:Pagina')->findAll();

        return $this->render('CaiWebBundle:Pagina:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Pagina entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Pagina();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('pagina_show', array('id' => $entity->getId())));
        }

        return $this->render('CaiWebBundle:Pagina:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Pagina entity.
     *
     * @param Pagina $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Pagina $entity)
    {
        $form = $this->createForm(new PaginaType(), $entity, array(
            'action' => $this->generateUrl('pagina_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Pagina entity.
     *
     */
    public function newAction()
    {
        $entity = new Pagina();
        $form   = $this->createCreateForm($entity);

        return $this->render('CaiWebBundle:Pagina:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Pagina entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CaiWebBundle:Pagina')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pagina entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CaiWebBundle:Pagina:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Pagina entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CaiWebBundle:Pagina')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pagina entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CaiWebBundle:Pagina:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Pagina entity.
    *
    * @param Pagina $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Pagina $entity)
    {
        $form = $this->createForm(new PaginaType(), $entity, array(
            'action' => $this->generateUrl('pagina_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Pagina entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CaiWebBundle:Pagina')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pagina entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('pagina_edit', array('id' => $id)));
        }

        return $this->render('CaiWebBundle:Pagina:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Pagina entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CaiWebBundle:Pagina')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Pagina entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('pagina'));
    }

    /**
     * Creates a form to delete a Pagina entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pagina_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
