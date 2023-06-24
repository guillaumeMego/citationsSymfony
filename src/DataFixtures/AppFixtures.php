<?php

namespace App\DataFixtures;


use Faker\Factory;
use Faker\Generator;
use App\Entity\Auteurs;

use App\Entity\Citations;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

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
        for ($i = 0; $i < 20; $i++) {
            $auteur = new Auteurs();
            $auteur->setAuteur($this->faker->name());
            $auteur->setBio($this->faker->text());
            $manager->persist($auteur);
        }

        for ($i = 0; $i < 100; $i++) {
            $citation = new Citations();
            $citation->setCitation($this->faker->text(127));
            $citation->setExplication($this->faker->text());
            $citation->setAuteurs($auteur);
            $manager->persist($citation);
        }

        $manager->flush();
    }
}
