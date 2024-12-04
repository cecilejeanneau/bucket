<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\User;
use App\Entity\Wish;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class WishFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categories = $manager->getRepository(Category::class)->findAll();
        $users = $manager->getRepository(User::class)->findAll();

        $faker = Factory::create('fr_FR');

        for($i = 0; $i < 50; $i++){
            $wish = new Wish();

            $wish->setTitle($faker->word)
                ->setDescription($faker->text)
                ->setDateCreated($faker->dateTime)
                ->setCategory($faker->randomElement($categories))
                ->setUser($users[array_rand($users)]);

            $manager->persist($wish);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
        ];
    }
}
