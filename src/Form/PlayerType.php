<?php

namespace App\Form;

use App\Entity\Player;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class PlayerType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add(
        'pseudo',
        TextType::class,
        ['label' => 'Pseudo'],
        ['attr' => [
          'minlength' => '2',
          'maxlength' => '50',
          'placeholder' => 'amazingPseudo01'
        ]],
        ['label_attr' => 'form-label px-4'],
        ['constraints' => [
          new Assert\NotBlank(),
          new Assert\Length(['min' => 2, 'max' => 50]),
        ]]
      )
      ->add(
        'email',
        EmailType::class,
        ['label' => 'Email address'],
        ['attr' => ['placeholder' => 'amazingPseudo01']],
        ['constraints' => [
          new Assert\NotBlank(),
          new Assert\Email(),
        ]]
      )
      ->add(
        'totalPoints',
        NumberType::class,
        ['label' => 'Total points'],
        ['constraints' => [new Assert\PositiveOrZero()]]
      )
      ->add(
        'submit',
        SubmitType::class,
        ['label' => 'Create player']

      );
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => Player::class,
    ]);
  }
}
