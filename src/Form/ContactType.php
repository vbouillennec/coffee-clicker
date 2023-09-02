<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ContactType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add(
				'fullName',
				TextType::class,
				['label' => 'Full name'],
				['attr' => [
					'maxlength' => '50',
					'placeholder' => 'John DOE'
				]],
				['constraints' => [
					new Assert\Length(['max' => 50]),
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
				'subject',
				TextType::class,
				['label' => 'Subject'],
				['attr' => [
					'maxlength' => '100',
					'placeholder' => 'Type your subject here'
				]],
				['constraints' => [
					new Assert\Length(['max' => 100]),
				]]
			)
			->add(
				'message',
				TextareaType::class,
				['label' => 'Message'],
				['attr' => [
					'placeholder' => 'Type your message here'
				]],
				['constraints' => [
					new Assert\NotBlank(),
				]]
			)
			->add('submit', SubmitType::class, [
				'label' => 'Send',
			]);
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			'data_class' => Contact::class,
		]);
	}
}
