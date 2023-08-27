<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class UserType extends AbstractType
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
                'plainPassword',
                PasswordType::class,
                ['label' => 'Confirm password'],
                ['attr' => [
                    'maxlength' => '50',
                    'placeholder' => '********',
                    'required' => true
                ]],
                ['constraints' => [
                    new Assert\NotBlank(),
                ]]
            )
            ->add('submit', SubmitType::class, [
                'label' => 'Update user',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
