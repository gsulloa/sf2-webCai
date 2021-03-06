<?php

namespace Cai\WebBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Cai\WebBundle\Entity\Imagen;
use Cai\WebBundle\Form\ImagenType;

/**
 * Imagen controller.
 *
 */
class ImagenController extends Controller
{

    /**
     * Lists all Imagen entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $sql = "
            SELECT image
            FROM CaiWebBundle:Imagen image
            ORDER BY image.id DESC
        ";
        $query = $em->createQuery($sql);

        $paginator  = $this->get('knp_paginator');
        $entities = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            20/*limit per page*/
        );

        return $this->render('CaiWebBundle:Imagen:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Imagen entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Imagen();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('imagen_show', array('id' => $entity->getId())));
        }

        return $this->render('CaiWebBundle:Imagen:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Imagen entity.
     *
     * @param Imagen $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Imagen $entity)
    {
        $form = $this->createForm(new ImagenType(), $entity, array(
            'action' => $this->generateUrl('imagen_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Imagen entity.
     *
     */
    public function newAction()
    {
        $entity = new Imagen();
        $form   = $this->createCreateForm($entity);

        return $this->render('CaiWebBundle:Imagen:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Imagen entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CaiWebBundle:Imagen')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Imagen entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CaiWebBundle:Imagen:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Imagen entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CaiWebBundle:Imagen')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Imagen entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('imagen'));
    }

    /**
     * Creates a form to delete a Imagen entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('imagen_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
