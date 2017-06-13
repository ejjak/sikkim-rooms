<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class PackageForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class)
            ->add('phone',TextType::class)
            ->add('email',EmailType::class)
            ->add('adult',TextType::class)
            ->add('minor',TextType::class)
            ->add('hotel',TextType::class)
            ->add('nights',TextType::class)
            ->add('details',TextareaType::class)
        ;

    }

}
