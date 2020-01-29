<?php

namespace AppBundle\Form;

use AppBundle\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
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
            ->add('email', EmailType::class,array('attr'=>array('class'=> 'form-control')))
            ->add('phone', NumberType::class,array('attr'=>array('class'=> 'form-control')))
            ->add('dob', BirthdayType::class,array('attr'=>array('class'=> 'form-control')))
            ->add('street', TextType::class,array('attr'=>array('class'=> 'form-control')))
            ->add('city', TextType::class,array('attr'=>array('class'=> 'form-control')))
            ->add('zip', NumberType::class,array('attr'=>array('class'=> 'form-control')))
            ->add('country', CountryType::class,array('attr'=>array('class'=> 'form-control')))
            ->add('picture', FileType::class,
                array(
                    'label'=> 'Insert Image',
                    'mapped' => false,
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