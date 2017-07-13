<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class HotelType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('address', TextareaType::class, array(
                'constraints' => array(
                    new NotBlank(array("message" => "This field cannot be blank")),
                )
            ))
            ->add('email', EmailType::class, array('attr' => array('placeholder' => 'Email address'),
                'constraints' => array(
                    new NotBlank(array("message" => "Please provide a valid email")),
//                    new Email(array("message" => "Your email doesn't seems to be valid")),
                )
            ))
            ->add('phone', TextType::class, array('attr' => array('placeholder' => 'Phone number'),
                'constraints' => array(
                    new NotBlank(array("message" => "Please provide phone no.")),
                )
            ))
            ->add('amenities', ChoiceType::class, array(
                'choices' => array(
                    'Wifi' => 'fa-wifi',
                    'Cab Service' => 'fa-cab',
                    'Travel Desk'=>'fa-plane',
                    'CCTV'=> 'fa-file-video-o',
                    'Dr. On Call' => 'fa-medkit',
                    'Power Backup' => 'fa-plug',
                    'Laundry' => 'fa-shopping-basket',
                    'Room Service' => 'fa-coffee',
                    'Food' => 'fa-cutlery',
                    'Casino' => 'fa-support'

                ),
                'multiple' => true,
                'expanded' => true
            ))
            ->add('gmap', TextareaType::class, array(
                'required' => true
            ))
            ->add('website', TextType::class, array(
                'required' => true
            ))
            ->add('priceRangeA', TextType::class, array('attr' => array('placeholder' => '2000'),
                'constraints' => array(
                    new NotBlank(array("message" => "Please provide price")),
                )
            ))
            ->add('priceRangeB', TextType::class, array('attr' => array('placeholder' => '3000'),
                'constraints' => array(
                    new NotBlank(array("message" => "Please provide price")),
                )
            ))
            ->add('star', ChoiceType::class, array(
                'choices'=>array(
                    '1 Star' => '1',
                    '2 Star' => '2',
                    '3 Star' => '3',
                    '4 Star' => '4',
                    '5 Star' => '5'
                )
            ))
            ->add('imageurl',FileType::class,array('label'=>'Hotel image',
                    'constraints' => array(
                        new NotBlank(array("message" => "Please provide image")),
                    ))
            )
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
