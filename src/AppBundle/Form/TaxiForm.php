<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class TaxiForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class)
            ->add('phone',TextType::class)
            ->add('travelDate',TextType::class)
            ->add('from',TextType::class)
            ->add('to',TextType::class)
            ->add('trip',ChoiceType::class,array(
                'choices' => array(
                    'One Way' => 'One Way',
                    'Round Trip' => 'Round Trip'
                ),
                'expanded'=> true
            ))
            ->add('carType',ChoiceType::class, array(
                'choices'=>array(
                    'Alto' => 'Alto',
                    'Wagon r' => 'Wagon r',
                    'Sumo' => 'Sumo',
                    'Bolero Plus' => 'Bolero Plus',
                    'Xylo' => 'Xylo',
                    'Innova' => 'Innova'
                )
            ))
        ;

    }

}
