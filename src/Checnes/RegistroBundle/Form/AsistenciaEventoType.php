<?php

namespace Checnes\RegistroBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AsistenciaEventoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tipo_persona', 'choice', array(
                'attr'          => array('class' => 'form-control'),
                'choices'       => array('dirigente'=>'Dirigentes','general'=>'General'),
                'label'         => 'Tipo de personas',
                //'data'          => 'dirigentes',
                'empty_value'   => 'Seleccionar',
                'mapped'        => false,
                'required'      => false
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'asistencia_evento';
    }
}
