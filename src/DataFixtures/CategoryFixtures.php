<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\User;
use App\Entity\Wish;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for($i = 0; $i < 50; $i++){
            $category = new Category();

            $category->setName($faker->randomElement(['Travel & Adventure', 'Sport', 'Entertainment', 'Humain Relations', 'Others']));

            $manager->persist($category);
        }

        $manager->flush();
    }
}
