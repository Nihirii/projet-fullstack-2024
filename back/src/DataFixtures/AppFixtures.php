<?php

namespace App\DataFixtures;


use App\Entity\Restaurant;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        $today = new \DateTime();


        $restaurant = new Restaurant();
        $restaurant->setName("Restaurant Test")
            ->setStatus("on")->setCreatedAt($today)->setUpdatedAt($today);
        // $manager->persist($product);
        $manager->persist($restaurant);
        $manager->flush();
    }
}
