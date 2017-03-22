<?php

namespace Checnes\RegistroBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

class AsistenciaEventoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $date = date('Y-m-d');

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
            ->add('evento', 'entity', array(
                'attr'          => array('class' => 'form-control'),
                'class'         => 'ChecnesRegistroBundle:Evento',
                'label'         => 'Evento',
                'empty_value'   => '[Seleccionar]',
                'required'      => true,
                'query_builder' => function(EntityRepository $er) use ($options)
                {
                    $qb = $er->createQueryBuilder('e');
                    $qb->where("e.estado <> 'porconfirmar'");
                    $qb->andWhere("e.estado <> 'cancelado'");
                    $qb->andWhere("e.estado <> 'confirmado'");

                    $qb->andWhere(":date >= e.fecha_inicio");
                    $qb->andWhere(":date <= e.fecha_fin");
                    $qb->setParameter('date', date('Y-m-d'));

                    return $qb;
                }                
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
