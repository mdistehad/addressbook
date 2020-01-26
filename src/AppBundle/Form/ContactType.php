<?php

namespace AppBundle\Form;

use AppBundle\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class,array('attr'=>array('class'=> 'form-control')))
            ->add('lastname', TextType::class,array('attr'=>array('class'=> 'form-control')))
            ->add('email', TextType::class,array('attr'=>array('class'=> 'form-control')))
            ->add('phone', TextType::class,array('attr'=>array('class'=> 'form-control')))
            ->add('dob', DateType::class,array('attr'=>array('class'=> 'form-control')))
            ->add('street', TextType::class,array('attr'=>array('class'=> 'form-control')))
            ->add('city', TextType::class,array('attr'=>array('class'=> 'form-control')))
            ->add('zip', TextType::class,array('attr'=>array('class'=> 'form-control')))
            ->add('country', TextType::class,array('attr'=>array('class'=> 'form-control')))
            ->add('picture', FileType::class,
                array(
                    'label'=> 'Insert Image',
                    // unmapped means that this field is not associated to any entity property
                    'mapped' => false,

                    // make it optional so you don't have to re-upload the PDF file
                    // everytime you edit the Product details
                    'required' => false,
                    'constraints' => [
                        new File([
                            'maxSize' => '1024k',
                            'mimeTypes' => [
                                'image/jpeg',
                                'image/png'
                            ],
                            'mimeTypesMessage' => 'Please upload a Image',
                        ])
                    ],
                    'attr'=>array('class'=> 'form-control')
                ))

            ->add('save',SubmitType::class, array('label'=> $options['label'],'attr' => array('class'=> 'btn btn-success mt-3')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}