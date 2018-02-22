<?php

namespace Checnes\RegistroBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

class CajaBancoType extends AbstractType
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
        ->add('nro_cuenta', 'text',array(
            'attr'  =>array('class'=>'form-control'),
            'label' => 'Nro. Cuenta:',
        ))
        ->add('caja_banco', 'checkbox',array(
            'attr'  =>array('class'=>''),
            'label' => 'Caja / Banco:',
            'required' => true

        ))
        ->add('activo', 'checkbox',array(
            'attr'  =>array('class'=>''),
            'label' => 'Activo:',
            'required' => true
        ))
        ->add('observacion', 'textarea',array(
            'attr'  =>array('class'=>'form-control'),
            'label' => 'Observación:',
            'required' => false,
        ))
        ->add('moneda', 'entity', array(
                'attr'          => array('class' => 'form-control'),
                'class'         => 'ChecnesRegistroBundle:Moneda',
                'label'         => 'Moneda:',
                'required'      => true,
                'query_builder' => function(EntityRepository $er) use ($options)
                {
                    $qb = $er->createQueryBuilder('m');
                    $qb->where("m.activo=1");
                    return $qb;
                }                
        ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Checnes\RegistroBundle\Entity\CajaBanco'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'checnes_registrobundle_cajabanco';
    }


}
