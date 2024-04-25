<?php

namespace App\DataFixtures;

use App\Factory\CategoryFactory;
use App\Factory\VegetableFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        CategoryFactory::createMany(20);
        VegetableFactory::createMany(20, fn() => ['category' => CategoryFactory::random()]);
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
