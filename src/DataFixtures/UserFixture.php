<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\User;

class UserFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $roles = ['ROLE_USER', 'ROLE_RESTAURANT', 'ROLE_ADMIN'];
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setEmail($faker->email);
            $user->setRoles((array)$roles[array_rand($roles)]);
            $user->setPassword(password_hash($faker->password,PASSWORD_ARGON2I));
            $user->setPseudo($faker->userName);
            $user->setPrenom($faker->firstName);
            $user->setNom($faker->lastName);
            $user->setCreatedAt($faker->dateTime);
            $user->setActif($faker->boolean);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
