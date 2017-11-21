<?php

namespace Checnes\RegistroBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

class UsuarioType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('usuario', 'text',array(
            'attr'=>array('class'=>'form-control','autocomplete'=>false),
            'label' => 'Usuario:'
        ))
        ->add('password', 'password',array(
            'attr'=>array('class'=>'form-control'),
            'label' => 'Password:'
        ))
        ->add('activo', 'checkbox',array(
            'attr'=>array('class'=>'form-control'),
            'label' => 'Habilitado:'
        ))
        ->add('rol', 'entity', array(
                'attr'          => array('class' => 'form-control'),
                'class'         => 'ChecnesRegistroBundle:Rol',
                'label'         => 'Rol:',
                'empty_value'   => '[Seleccionar]',
                'required'      => true,
                'query_builder' => function(EntityRepository $er) use ($options)
                {
                    $qb = $er->createQueryBuilder('r');
                    $qb->where("r.estado='1'");
                    return $qb;
                }                
        ))
        ->add('persona','hidden')
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
