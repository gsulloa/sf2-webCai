<?php

namespace Cai\WebBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Cai\WebBundle\Entity\Directiva;
use Cai\WebBundle\Form\DirectivaType;

/**
 * Directiva controller.
 *
 */
class DirectivaController extends Controller
{

    /**
     * Lists all Directiva entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CaiWebBundle:Directiva')->findAll();

        return $this->render('CaiWebBundle:Directiva:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Directiva entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Directiva();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('directiva_show', array('id' => $entity->getId())));
        }

        return $this->render('CaiWebBundle:Directiva:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Directiva entity.
     *
     * @param Directiva $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Directiva $entity)
    {
        $form = $this->createForm(new DirectivaType(), $entity, array(
            'action' => $this->generateUrl('directiva_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Directiva entity.
     *
     */
    public function newAction()
    {
        $entity = new Directiva();
        $form   = $this->createCreateForm($entity);

        return $this->render('CaiWebBundle:Directiva:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Directiva entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CaiWebBundle:Directiva')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Directiva entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CaiWebBundle:Directiva:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Directiva entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CaiWebBundle:Directiva')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Directiva entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CaiWebBundle:Directiva:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Directiva entity.
    *
    * @param Directiva $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Directiva $entity)
    {
        $form = $this->createForm(new DirectivaType(), $entity, array(
            'action' => $this->generateUrl('directiva_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Directiva entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CaiWebBundle:Directiva')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Directiva entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('directiva_edit', array('id' => $id)));
        }

        return $this->render('CaiWebBundle:Directiva:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Directiva entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CaiWebBundle:Directiva')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Directiva entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('directiva'));
    }

    /**
     * Creates a form to delete a Directiva entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('directiva_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
