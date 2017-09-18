<?php

namespace OC\PlatformBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaxrefType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nomVern', EntityType::class, array(
            'class' => 'OCPlatformBundle:Taxref',
            'query_builder' => function (EntityRepository $er){
                $qb = $er->createQueryBuilder('t');
                $qb
                    ->where("t.nomVern IS NOT NULL")
                    ->andWhere("t.nomVern != ''")
                    ->orderBy("t.nomVern", "ASC");
                return $qb;
            },
            'placeholder' => 'Sélectionnez une espèce ci-dessous ou saisissez son nom',
            'choice_label' => 'speciesToSearch',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'OC\PlatformBundle\Entity\Taxref'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'oc_platformbundle_taxref';
    }

}
