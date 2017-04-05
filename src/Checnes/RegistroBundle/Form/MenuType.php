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

        $orden = array();

        for ($i=100; $i >= 1 ; $i--) { 
            $orden[$i]=$i;
        }

        $builder->add('nombre', 'text',array(
            'attr'=>array('class'=>'form-control'),
            'label' => 'Nombre:'
        ))
        ->add('padre', 'choice',array(
            'attr'=>array('class'=>'form-control'),
            'choices' => $options['padreM'],
            'label' => 'Padre:'
        ))
        ->add('nivel', 'text',array(
            'attr'     =>array('class'=>'form-control'),
            'label'    => 'Nivel:',
            'required' => false
        ))
        ->add('enlace', 'text',array(
            'attr'     =>array('class'=>'form-control'),
            'label'    => 'Enlace:',
            'required' => false
        ))
        ->add('css_icono', 'choice',array(
            'attr'     =>array('class'=>'form-control'),
            'label'    => 'Clase Ícono:',
            'empty_value'   => 'Ninguno',
            'choices'  => array(
                    'fa-envelope-o'    => 'fa-envelope-o',
                    'fa-folder-o'      => 'fa-folder-o',
                    'fa-folder-open-o' => 'fa-folder-open-o',
                    'fa-users'         => 'fa-users',
                    'fa-home'          => 'fa-home',
                    'fa-laptop'        => 'fa-laptop',
                    'fa-cog'           => 'fa-cog',
                    'fa-cogs'          => 'fa-cogs',
                    'fa-calendar'      => 'fa-calendar',
                    'fa-book'          => 'fa-book',
                    'fa-eye'           => 'fa-eye',
                    'fa-bar-chart-o'   => 'fa-bar-chart-o',
                    'fa-barcode'       => 'fa-barcode',
                    'fa-flask'         => 'fa-flask',
                    'fa-beer'          => 'fa-beer',
                    'fa-bell-o'        => 'fa-bell-o',
                    'fa-bell'          => 'fa-bell'
                ),
            'required' => false
        ))
        ->add('orden', 'choice',array(
            'attr'     =>array('class'=>'form-control'),
            'label'    => 'Nivel:',
            'empty_value'   => false,
            'choices' => $orden,
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
            'data_class' => 'Checnes\RegistroBundle\Entity\Menu',
            'padreM' => ''
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
