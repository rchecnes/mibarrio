<?php

namespace Checnes\RegistroBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

class TipoActividadType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nombre', 'text',array(
            'attr'  =>array('class'=>'form-control'),
            'label' => 'Nombre:',
        ))
        ->add('descripcion', 'textarea',array(
            'attr'  =>array('class'=>'form-control'),
            'label' => 'Descripción:',
        ))
        /*->add('nombre_sistema', 'hidden',array(
            'attr'  =>array('class'=>'form-control'),
            'label' => 'Nombre Sistema:',
        ))*/
        /*->add('estado', 'checkbox',array(
            'attr'  =>array('class'=>'form-control'),
            'label' => 'Estado:',
        ))*/
        ->add('activo', 'checkbox',array(
            'attr'  =>array('class'=>'form-control'),
            'label' => 'Habilitado:',
        ))
        ->add('tipo_tipo_actividad', 'entity', array(
                'attr'          => array('class' => 'form-control'),
                'class'         => 'ChecnesRegistroBundle:TipoTipoActividad',
                'label'         => 'Tipo Tipo Actividad:',
                'empty_value'   => '[Seleccionar]',
                'required'      => true,
                'query_builder' => function(EntityRepository $er) use ($options)
                {
                    $qb = $er->createQueryBuilder('t');
                    $qb->where("t.estado='1'");
                    $qb->andWhere("t.activo='1'");
                    return $qb;
                }                
        ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Checnes\RegistroBundle\Entity\TipoActividad'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'checnes_registrobundle_tipoactividad';
    }


}
