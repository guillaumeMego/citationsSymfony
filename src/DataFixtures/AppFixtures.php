<?php

namespace App\DataFixtures;


use Faker\Factory;
use App\Entity\User;
use Faker\Generator;

use App\Entity\Auteurs;
use App\Entity\Citations;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    /**
     * @var Generator
     */
    private Generator $faker;

    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->faker = Factory::create('fr_FR');
        $this->hasher = $hasher;
    }
    
    /**
     * @param ObjectManager $manager
     * @return void 
     */
    public function load(ObjectManager $manager): void
    {

        // auteurs
        for ($i = 0; $i < 20; $i++) {
            $auteur = new Auteurs();
            $auteur->setAuteur($this->faker->name());
            $auteur->setBio($this->faker->text());
            $manager->persist($auteur);
        }

        // citations
        for ($i = 0; $i < 100; $i++) {
            $citation = new Citations();
            $citation->setCitation($this->faker->text(127));
            $citation->setExplication($this->faker->text());
            $citation->setAuteurs($auteur);
            $manager->persist($citation);
        }

        // Utilisateurs
        $user = new User();
        $userOne = new User();
        $user->setEmail('guillaume.ganne@gmail.com');
        $userOne->setEmail('test@test.com');

        $userOne->setRoles(['ROLE_USER']);
        $user->setRoles(['ROLE_ADMIN']);

        $hashPassword = $this->hasher->hashPassword(
            $user,
            '1234'
        );

        $hashPasswordOne = $this->hasher->hashPassword(
            $userOne,
            '1234'
        );

        $userOne->setPassword($hashPasswordOne);
        $user->setPassword($hashPassword);

        $manager->persist($user);
        $manager->persist($userOne);

        $manager->flush();
    }
}
