<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail as MimeTemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\TemplatedEmail;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
	#[Route('/contact', name: 'contact.index')]
	public function index(Request $request, EntityManagerInterface $manager, MailerInterface $mailer): Response
	{
		$contact = new Contact();
		if ($this->getUser()) {
			$contact->setFullName($this->getUser()->getUserName());
			$contact->setEmail($this->getUser()->getEmail());
		}
		$form = $this->createForm(ContactType::class, $contact);

		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {

			$contact = $form->getData();

			$manager->persist($contact);
			$manager->flush();

			$email = (new MimeTemplatedEmail())
				->from($contact->getEmail())
				->to('admin@mail.com')
				//->cc('cc@example.com')
				//->bcc('bcc@example.com')
				//->replyTo('fabien@example.com')
				//->priority(Email::PRIORITY_HIGH)
				->subject($contact->getSubject())
				// path of the Twig template to render
				->htmlTemplate('emails/contact.html.twig')

				// pass variables (name => value) to the template
				->context([
					'contact' => $contact,
				]);

			$mailer->send($email);

			$this->addFlash(
				'success',
				"Request successfully sent"
			);

			return $this->redirectToRoute('contact.index');
		}

		return $this->render('contact/index.html.twig', [
			'form' => $form->createView(),
		]);
	}
}
