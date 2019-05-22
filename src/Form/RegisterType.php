<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'label' => 'Name',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Your name!'
                ]
            ])
            ->add('firstname', TextType::class, [
                'required' => true,
                'label' => 'Firstname',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Your firstname!'
                ]
            ])
            ->add('email', EmailType::class, [
                'required' => true,
                'label' => 'Email',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Your email!'
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password field must match!',
                'required' => true,
                'first_options' => [
                    'label' => 'Your password',
                    'attr' => [
                        'class' => 'form-group form-control',
                        'placeholder' => 'Your password!'
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirm your password!',
                    'attr' => [
                        'class' => 'form-group form-control',
                        'placeholder' => 'Confirm your password!'
                    ]
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
