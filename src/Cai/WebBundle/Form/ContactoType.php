<?php

namespace Cai\WebBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContactoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lema')
            ->add('direccion')
            ->add('telefono')
            ->add('twitter')
            ->add('facebook')
            ->add('youtube')
            ->add('mail')
            ->add('vimeo')
            ->add('descripcion')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Cai\WebBundle\Entity\Contacto'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'cai_webbundle_contacto';
    }
}
