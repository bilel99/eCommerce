<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfilUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'label' => 'Name',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Your name'
                ]
            ])
            ->add('firstname', TextType::class, [
                'required' => true,
                'label' => 'Firstname',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Your firstname'
                ]
            ])
            ->add('media', UserAvatarType::class, [
                'required' => false,
                'label' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
