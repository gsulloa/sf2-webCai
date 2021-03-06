<?php

namespace Cai\WebBundle\Controller;

use Cai\WebBundle\Entity\Slide;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Cai\WebBundle\Entity\Slider;
use Cai\WebBundle\Form\SliderType;

/**
 * Slider controller.
 *
 */
class SliderController extends Controller
{

    /**
     * Lists all Slider entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CaiWebBundle:Slider')->findAll();

        return $this->render('CaiWebBundle:Slider:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Slider entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Slider();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('slider_show', array('id' => $entity->getId())));
        }

        return $this->render('CaiWebBundle:Slider:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Slider entity.
     *
     * @param Slider $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Slider $entity)
    {
        $form = $this->createForm(new SliderType(), $entity, array(
            'action' => $this->generateUrl('slider_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Slider entity.
     *
     */
    public function newAction()
    {
        $entity = new Slider();
        $form   = $this->createCreateForm($entity);

        return $this->render('CaiWebBundle:Slider:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Slider entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CaiWebBundle:Slider')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Slider entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $auxiliar = $this->get('cai_web.auxiliar');
        $images = $auxiliar->getImages();

        return $this->render('CaiWebBundle:Slider:show.html.twig', array(
            'entity'            => $entity,
            'delete_form'       => $deleteForm->createView(),
            'previous_slides'   => sizeof($entity->getSlides())>0,
            'images'            => $images
        ));
    }

    /**
     * Displays a form to edit an existing Slider entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CaiWebBundle:Slider')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Slider entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CaiWebBundle:Slider:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Slider entity.
    *
    * @param Slider $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Slider $entity)
    {
        $form = $this->createForm(new SliderType(), $entity, array(
            'action' => $this->generateUrl('slider_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Slider entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CaiWebBundle:Slider')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Slider entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('slider_edit', array('id' => $id)));
        }

        return $this->render('CaiWebBundle:Slider:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Slider entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CaiWebBundle:Slider')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Slider entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('slider'));
    }

    /**
     * Creates a form to delete a Slider entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('slider_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    public function slidesGenerateAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CaiWebBundle:Slider')->find($id);
        $data = $request->request->all();
        $slides = $entity->getSlides();
        if(sizeof($entity->getSlides()) < sizeof($data)/2) {
            while (sizeof($entity->getSlides()) !== sizeof($data) / 2) {
                $slide = new Slide();
                $entity->addSlide($slide);
                $slide->setSlider($entity);
            }
        }elseif(sizeof($entity->getSlides()) > sizeof($data)/2){
            while (sizeof($entity->getSlides()) !== sizeof($data) / 2) {
                $slide_to_delete = $entity->getSlides()->last();
                $entity->removeSlide($slide_to_delete);
                $em->remove($slide_to_delete);
            }
        }
        $i = 0;
        foreach($data as $key => $item){
            if(strpos($key,'path_slide') !== false){
                $slides[intval($i/2)]->setPath($item);
            }elseif(strpos($key,'img_slide') !== false){
                $image = $em->getRepository('CaiWebBundle:Imagen')->find(substr($item,6));
                //$image->setSlide($slide);
                $slides[intval($i/2)]->setImagen($image);
            }
            $slides[intval($i/2)]->setPosicion(intval($i/2));
            $i++;
        }
        foreach($slides as $slide){
            $em->persist($slide);
        }
        $em->flush();
        return $this->redirect($this->generateUrl('slider_show',array(
            'id'=>$id
        )));
    }
}
