<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HotelType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('address')
            ->add('email')
            ->add('phone')
            ->add('amenities')
            ->add('gmap')
            ->add('website')
            ->add('priceRangeA')
            ->add('priceRangeB')
            ->add('star')
            ->add('imageurl',FileType::class,array('label'=>'Hotel image','required'=>false))
            ->add('destination')
            ->add('milestone', CollectionType::class, array(
                'entry_type'=> MilestoneType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => false,
                'required' => false
            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Hotel'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_hotel';
    }


}
