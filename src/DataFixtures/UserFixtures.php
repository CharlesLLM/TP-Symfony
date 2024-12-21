<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class UserFixtures extends Fixture
{
    public const string REFERENCE_IDENTIFIER = 'user_';
    public const int FIXTURE_RANGE = 6;

    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $user = new User();
        $user->setUsername('superadmin')
            ->setEmail('superadmin@esgi.fr')
            ->setPassword($this->passwordHasher->hashPassword($user, 'superadmin'))
            ->setRoles(['ROLE_SUPER_ADMIN'])
        ;

        $manager->persist($user);
        $this->setReference(self::REFERENCE_IDENTIFIER.'superadmin', $user);

        foreach (range(0, self::FIXTURE_RANGE - 1) as $i) {
            $isAdmin = 0 === $i;
            $username = $isAdmin ? 'admin' : "user{$i}";

            $user = new User();
            $user
                ->setUsername($username)
                ->setEmail("{$username}@esgi.fr")
                ->setPassword($this->passwordHasher->hashPassword(
                    $user,
                    $isAdmin ? 'admin' : 'user' // admin password is 'admin', user password is 'user'
                ))
                ->setRoles($isAdmin ? ['ROLE_ADMIN'] : ['ROLE_USER'])
            ;

            ++$i;
            $manager->persist($user);
            $this->setReference(self::REFERENCE_IDENTIFIER.$i, $user);
        }

        $manager->flush();
    }
}
