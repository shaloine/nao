<?php

namespace OC\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Vihuvac\Bundle\RecaptchaBundle\Form\Type\VihuvacRecaptchaType;


class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, array('label' => 'Prénom'))
            ->add('lastName', TextType::class, array('label' => 'Nom'))
            ->add('naturalist', CheckboxType::class, array(
                'label'    => 'Naturaliste',
                'required' => false,
            ))
            ->add("recaptcha", VihuvacRecaptchaType::class);
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';

    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

}
