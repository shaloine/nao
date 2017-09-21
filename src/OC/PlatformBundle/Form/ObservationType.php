<?php

namespace OC\PlatformBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ObservationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('taxref', EntityType::class, array(
                'class' => 'OCPlatformBundle:Taxref',
                'query_builder' => function (EntityRepository $er){
                    $qb = $er->createQueryBuilder('t');
                    $qb->orderBy("t.nomVern", "ASC");
                    return $qb;
                },
                'placeholder' => '',
                'choice_label' => 'speciesToSearch',
            ))
            ->add('latitude', TextType::class)
            ->add('longitude', TextType::class)
            ->add('date',     DateType::Class, array(
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy'
            ))
            ->add('picture', PictureType::class, array(
                'required' => false
            ))
            ->add('flying', CheckboxType::class, array(
                'required' => false
            ))
            ->add('comment', TextareaType::class, array(
                'required' => false
            ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'OC\PlatformBundle\Entity\Observation'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'oc_platformbundle_observation';
    }


}
