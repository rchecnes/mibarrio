<?php

namespace Checnes\RegistroBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

class MenuType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nombre', 'text',array(
            'attr'=>array('class'=>'form-control'),
            'label' => 'Nombre:'
        ))
        /*->add('padre', 'text',array(
            'attr'=>array('class'=>'form-control'),
            'label' => 'Padre:'
        ))*/
        ->add('padre', 'entity', array(
            'attr'          => array('class' => 'form-control'),
            'class'         => 'ChecnesRegistroBundle:Menu',
            'label'         => 'Padre',
            'empty_value'   => 'Ninguno',
            'required'      => false,
            'query_builder' => function(EntityRepository $er) use ($options)
            {
                $qb = $er->createQueryBuilder('m');
                $qb->where("m.estado = '1'");
                $qb->andWhere("m.padre = '1'");

                return $qb;
            }                
        ))  
        ->add('nivel', 'hidden',array(
            'attr'     =>array('class'=>'form-control'),
            'label'    => 'Nivel:',
            'required' => false
        ))
        ->add('enlace', 'text',array(
            'attr'     =>array('class'=>'form-control'),
            'label'    => 'Enlace:',
            'required' => false
        ))
        ->add('css_icono', 'text',array(
            'attr'     =>array('class'=>'form-control'),
            'label'    => 'Clase Ícono:',
            'required' => false
        ))
        ->add('estado', 'checkbox',array(
            'label'    => '¿Activo?:',
            'required' => false
        ))
        ->add('tiene_hijo', 'checkbox',array(
            'label'     => '¿Tiene Hijo?:',
            'required'  => false
        ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Checnes\RegistroBundle\Entity\Menu'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'checnes_registrobundle_menu';
    }


}
