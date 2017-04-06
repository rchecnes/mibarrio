<?php

namespace Checnes\RegistroBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonaPerfilType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder->add('dni', 'text',array(
            'attr'=>array('class'=>'form-control'),
            'label' => 'DNI:'
        ))
        ->add('nombre', 'text',array(
            'attr'=>array('class'=>'form-control'),
            'label' => 'Nombre:'
        ))
        ->add('apellido_paterno', 'text',array(
            'attr'=>array('class'=>'form-control'),
            'label' => 'Apellido Paterno:'
        ))
        ->add('apellido_materno', 'text',array(
            'attr'=>array('class'=>'form-control'),
            'label' => 'Apellido Materno:'
        ))
        ->add('estado_civil', 'choice',array(
            'attr'=>array('class'=>'form-control'),
            'choices' => array('Soltero'=>'Soltero(a)','Casado'=>'Casado(a)','Divorciado'=>'Divorciado(a)', 'Viudo'=>'Viudo(a)'),
            'label' => 'Estado Civil:'
        ))
        ->add('numero', 'text',array(
            'attr'=>array('class'=>'form-control','disabled'=>'disabled'),
            'label' => 'Número:'
        ))
        ->add('lote', 'text',array(
            'attr'=>array('class'=>'form-control','disabled'=>'disabled'),
            'label' => 'Lote:'
        ))
        ->add('cargo', 'text',array(
            'attr'=>array('class'=>'form-control','disabled'=>'disabled'),
            'label' => 'Cargo:'
        ))
        ->add('es_dirigente', 'checkbox',array(
            'attr'=>array('class'=>'','disabled'=>'disabled'),
            'label' => '¿Es Diregente?:'
        ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Checnes\RegistroBundle\Entity\Persona'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'checnes_registrobundle_persona_perfil';
    }


}
