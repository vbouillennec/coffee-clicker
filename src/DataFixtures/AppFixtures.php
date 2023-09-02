<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use App\Entity\Player;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture
{
	/**
	 * @var Generator
	 */
	private Generator $faker;

	public function __construct()
	{
		$this->faker = Factory::create('fr_FR');
	}

	public function load(ObjectManager $manager): void
	{
		// $product = new Product();
		// $manager->persist($product);
		for ($i = 1; $i <= 10; $i++) {
			$player = new Player();
			$player->setPseudo($this->faker->userName() . "_0$i")
				->setEmail($this->faker->email())
				->setTotalPoints(rand(0, 1000));

			$manager->persist($player);
		}

		// Set Admin
		$user = new User();
		$user->setUsername('admin')
			->setEmail($_ENV['ADMIN_EMAIL'] ?? 'mail@example.com')
			->setRoles(['ROLE_ADMIN'])
			->setPlainPassword($_ENV['ADMIN_PASSWORD'] ?? 'password');

		$manager->persist($user);

		for ($i = 1; $i <= 10; $i++) {
			$user = new User();
			$user->setUsername($this->faker->userName())
				->setEmail($this->faker->email())
				->setRoles(['ROLE_USER'])
				->setNumberOfPoints(rand(0, 1000))
				->setPlainPassword('password');

			$manager->persist($user);
		}

		for ($i = 1; $i <= 5; $i++) {
			$user = new Contact();
			$user->setFullName($this->faker->firstName() . " " . $this->faker->lastName())
				->setEmail($this->faker->email())
				->setSubject("Demande N°" . $i . ": " . $this->faker->word())
				->setMessage($this->faker->sentence());

			$manager->persist($user);
		}

		$manager->flush();
	}
}
