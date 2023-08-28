<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Form\Type\VichImageType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'username',
                TextType::class,
                ['label' => 'Username'],
                ['attr' => [
                    'minlength' => '2',
                    'maxlength' => '50',
                    'placeholder' => 'johnDoe01'
                ]],
                ['constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 2, 'max' => 50]),
                ]]
            )
            ->add(
                'email',
                EmailType::class,
                ['label' => 'Email address'],
                ['attr' => [
                    'maxlength' => '50',
                    'placeholder' => 'mail@example.com'
                ]],
                ['constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Email(),
                    new Assert\Length(['max' => 50]),
                ]]
            )
            ->add(
                'numberOfPoints',
                NumberType::class,
                ['label' => 'Number of points'],
                ['constraints' => [new Assert\PositiveOrZero()]]
            )
            ->add(
                'imageFile',
                VichImageType::class,
                [
                    'label' => 'Profile picture',
                    'required' => false,
                    'allow_delete' => true,
                    'download_uri' => false,
                    'image_uri' => false,
                    'asset_helper' => true,
                ]
            )
            ->add(
                'plainPassword',
                RepeatedType::class,
                [
                    'type' => PasswordType::class,
                    'invalid_message' => 'The password fields must match.',
                    'options' => ['attr' => ['class' => 'block text-sm rounded-lg dark:bg-gray-600 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 w-full p-2.5']],
                    'required' => true,
                    'first_options'  => ['label' => 'Password'],
                    'second_options' => ['label' => 'Repeat Password'],
                ]
            )
            ->add('submit', SubmitType::class, [
                'label' => 'Register',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
