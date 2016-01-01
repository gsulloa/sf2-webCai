<?php

namespace Cai\WebBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Cai\WebBundle\Entity\Entrada;
use Cai\WebBundle\Form\EntradaType;

/**
 * Entrada controller.
 *
 */
class EntradaController extends Controller
{

    /**
     * Lists all Entrada entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $query = "
                SELECT e
                FROM CaiWebBundle:Entrada e
                ORDER BY e.id DESC
        ";
        $entities = $em->createQuery($query)->getResult();

        return $this->render('CaiWebBundle:Entrada:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Entrada entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Entrada();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);


        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            //generar Slug
            $this->generatingSlug($entity);
            //agregar creado por usuario logeado
            $entity->setUser($this->getUser());
            //agregar imagen
            $image = $em->getRepository('CaiWebBundle:Imagen')->find(substr($request->request->get('img_slide_0'),6));
            $entity->setImagen($image);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('entrada_show', array('id' => $entity->getId())));
        }

        return $this->render('CaiWebBundle:Entrada:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Entrada entity.
     *
     * @param Entrada $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Entrada $entity)
    {
        $form = $this->createForm(new EntradaType(), $entity, array(
            'action' => $this->generateUrl('entrada_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Entrada entity.
     *
     */
    public function newAction()
    {
        $entity = new Entrada();
        $entity->setFecha(new \DateTime());
        $form   = $this->createCreateForm($entity);
        $em = $this->getDoctrine()->getManager();
        $images = $em->getRepository('CaiWebBundle:Imagen')->findAll();
        $aux = $this->get('cai_web.auxiliar');
        $images = $aux->getImages();
        return $this->render('CaiWebBundle:Entrada:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'images' => $images
        ));
    }

    /**
     * Finds and displays a Entrada entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CaiWebBundle:Entrada')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Entrada entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CaiWebBundle:Entrada:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Entrada entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CaiWebBundle:Entrada')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Entrada entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CaiWebBundle:Entrada:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Entrada entity.
    *
    * @param Entrada $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Entrada $entity)
    {
        $form = $this->createForm(new EntradaType(), $entity, array(
            'action' => $this->generateUrl('entrada_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Entrada entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CaiWebBundle:Entrada')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Entrada entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $this->generatingSlug($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('entrada_edit', array('id' => $id)));
        }

        return $this->render('CaiWebBundle:Entrada:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Entrada entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CaiWebBundle:Entrada')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Entrada entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('entrada'));
    }

    /**
     * Creates a form to delete a Entrada entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('entrada_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    /**
     * @param Entrada $entity
     * Generar Slug unico
     */
    private function generatingSlug(Entrada $entity)
    {
        $em = $this->getDoctrine()->getManager();
        $aux = $this->get('cai_web.auxiliar');
        $slug = $aux->toAscii($entity->getTitulo());
        $querySlug = $slug . '%';
        $entradas = $em->createQuery("
                    SELECT entrada
                    FROM CaiWebBundle:Entrada entrada
                    WHERE entrada.slug LIKE '$querySlug'
            ")->getResult();
        $generateSlug = true;
        for ($i = 0; $i < sizeof($entradas); $i++) {
            if ($entradas[$i]->getId() == $entity->getId()) {
                $generateSlug = false;
            }
            $entradas[$i] = $entradas[$i]->getSlug();
        }
        if ($generateSlug) {
            $slug = $aux->slugGenerator($slug, $entradas);
        } else {
            $slug = $entity->getSlug();
        }
        $entity->setSlug($slug);
        //
    }
}
