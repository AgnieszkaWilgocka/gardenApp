<?php

namespace App\DataFixtures;

use App\Factory\CategoryFactory;
use App\Factory\GroupFactory;
use App\Factory\SpeciesFactory;
use App\Factory\VegetableFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        SpeciesFactory::createMany(20);
        CategoryFactory::createMany(20, fn() => ['species' => SpeciesFactory::random()]);
        VegetableFactory::createMany(20, fn() => ['category' => CategoryFactory::random()]);
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
