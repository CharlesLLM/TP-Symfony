<?php

namespace App\DataFixtures;

use App\Entity\Tutorial;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

final class TutorialFixtures extends Fixture implements DependentFixtureInterface
{
    public const string REFERENCE_IDENTIFIER = 'tutorial_';
    public const int FIXTURE_RANGE = 10;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        foreach (range(0, self::FIXTURE_RANGE - 1) as $i) {
            $tutorial = new Tutorial();
            $tutorial
                ->setName($faker->unique()->word())
                ->setCreatedBy($this->getReference(UserFixtures::REFERENCE_IDENTIFIER.'superadmin'))
                ->setCreatedAt($faker->dateTimeBetween('-1 years', 'now'));

            ++$i;
            $manager->persist($tutorial);
            $this->setReference(self::REFERENCE_IDENTIFIER.$i, $tutorial);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
