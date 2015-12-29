<?php

namespace Cai\WebBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Cai\WebBundle\Entity\Contacto;
use Cai\WebBundle\Form\ContactoType;

/**
 * Contacto controller.
 *
 */
class ContactoController extends Controller
{

    /**
     * Lists all Contacto entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CaiWebBundle:Contacto')->find(1);

        return $this->render('CaiWebBundle:Contacto:index.html.twig', array(
            'entity' => $entity,
        ));
    }

    /**
     * Displays a form to edit an existing Contacto entity.
     *
     */
    public function editAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CaiWebBundle:Contacto')->find(1);
        $editForm = $this->createEditForm($entity);
        return $this->render('CaiWebBundle:Contacto:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView()
        ));
    }

    /**
    * Creates a form to edit a Contacto entity.
    *
    * @param Contacto $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Contacto $entity)
    {
        $form = $this->createForm(new ContactoType(), $entity, array(
            'action' => $this->generateUrl('contacto_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Contacto entity.
     *
     */
    public function updateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CaiWebBundle:Contacto')->find(1);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('contacto'));
        }

        return $this->render('CaiWebBundle:Contacto:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }
}
