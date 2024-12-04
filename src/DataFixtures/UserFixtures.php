<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Wish;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $wishes = $manager->getRepository(Wish::class)->findAll();

        $faker = Factory::create('fr_FR');

        for($i = 0; $i < 50; $i++){
            $user = new User();

            $user
                ->setUsername($faker->userName)
                ->setEmail($faker->email)
                ->setPassword($faker->password())
            ;

            $manager->persist($user);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            WishFixtures::class,
        ];
    }
}
