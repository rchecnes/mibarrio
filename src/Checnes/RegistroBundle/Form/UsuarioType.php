<?php

namespace Checnes\RegistroBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsuarioType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('usuario')
        ->add('password')
        ->add('salt')
        ->add('fecha_creacion')
        ->add('ultimo_acceso')
        ->add('activo')
        ->add('estado')
        ->add('anio')
        //->add('rol')
        //->add('persona')
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Checnes\RegistroBundle\Entity\Usuario'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'checnes_registrobundle_usuario';
    }


}
