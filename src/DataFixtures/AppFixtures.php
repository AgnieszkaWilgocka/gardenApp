<?php

namespace App\DataFixtures;

use App\Factory\VegetableFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        VegetableFactory::createMany(20);
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
