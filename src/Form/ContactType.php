<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'label' => 'Your name?',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Your name?'
                ]
            ])
            ->add('firstname', TextType::class, [
                'required' => true,
                'label' => 'Your firstname?',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Your firstname?'
                ]
            ])
            ->add('email', EmailType::class, [
                'required' => true,
                'label' => 'Your email?',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Your email?'
                ]
            ])
            ->add('product', TextType::class, [
                'required' => true,
                'label' => 'Your product?',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Your product?'
                ]
            ])
            ->add('message', TextareaType::class, [
                'required' => true,
                'label' => 'Your message?',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Your message?'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
