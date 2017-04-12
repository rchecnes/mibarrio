<?php

namespace Checnes\RegistroBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

class PersonaType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder->add('dni', 'text',array(
            'attr'  =>array('class'=>'form-control'),
            'label' => 'DNI:',
        ))
        ->add('nombre', 'text',array(
            'attr'  =>array('class'=>'form-control'),
            'label' => 'Nombre:'
        ))
        ->add('apellido_paterno', 'text',array(
            'attr'  =>array('class'=>'form-control'),
            'label' => 'Apellido Paterno:'
        ))
        ->add('apellido_materno', 'text',array(
            'attr'  =>array('class'=>'form-control'),
            'label' => 'Apellido Materno:'
        ))
        ->add('estado_civil', 'choice',array(
            'attr'    =>array('class'=>'form-control'),
            'choices' => array('Soltero'=>'Soltero(a)','Casado'=>'Casado(a)','Divorciado'=>'Divorciado(a)', 'Viudo'=>'Viudo(a)'),
            'label'   => 'Estado Civil:'
        ))
        ->add('numero', 'text',array(
            'attr'     =>array('class'=>'form-control'),
            'label'    => 'Número:',
            'required' => false
        ))
        ->add('lote', 'entity', array(
                'attr'          => array('class' => 'form-control'),
                'class'         => 'ChecnesRegistroBundle:Lote',
                'label'         => 'Lote',
                'empty_value'   => '[Seleccionar]',
                'required'      => true,
                'query_builder' => function(EntityRepository $er) use ($options)
                {
                    $qb = $er->createQueryBuilder('l');
                    $qb->where("l.estado='1'");
                    return $qb;
                }                
        ))
        ->add('cargo', 'entity', array(
                'attr'          => array('class' => 'form-control'),
                'class'         => 'ChecnesRegistroBundle:Cargo',
                'label'         => 'Cargo',
                'empty_value'   => '[Seleccionar]',
                'required'      => true,
                'query_builder' => function(EntityRepository $er) use ($options)
                {
                    $qb = $er->createQueryBuilder('c');
                    $qb->where("c.estado='1'");
                    return $qb;
                }                
        ))  
        
        ->add('es_dirigente', 'checkbox',array(
            'attr'=>array('class'=>''),
            'label' => '¿Es Diregente?:'
        ))
        ->add('estado', 'checkbox',array(
            'attr'=>array('class'=>''),
            'label' => '¿Activo?:'
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
        return 'checnes_registrobundle_persona';
    }


}
