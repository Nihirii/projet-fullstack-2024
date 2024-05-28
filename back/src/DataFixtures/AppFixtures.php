<?php

namespace App\DataFixtures;


use App\Entity\Restaurant;
use Faker\Generator;
use Faker\Factory;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private Generator $faker;

    public function __construct() {
        $this->faker = Factory::create("fr_FR");
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        $today = new \DateTime();
        
        for($i = 0; $i <100; $i++){
            $created = $this->faker->dateTime();
            $updated = $this->faker->dateTimeBetween($created, "now");
            $restaurant = new Restaurant();
            $restaurant->setName($this->faker->word())
                ->setStatus("on")
                ->setCreatedAt($created)
                ->setUpdatedAt($updated);
            $manager->persist($restaurant);

        }

        // $manager->persist($product);
        $manager->flush();
    }
}
