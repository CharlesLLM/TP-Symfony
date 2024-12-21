<?php

namespace App\DataFixtures;

use App\Entity\Chapter;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

final class ChapterFixtures extends Fixture implements DependentFixtureInterface
{
    public const string REFERENCE_IDENTIFIER = 'chapter_';
    public const int FIXTURE_RANGE = 30;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        foreach (range(0, self::FIXTURE_RANGE - 1) as $i) {
            $chapter = new Chapter();
            $chapter
                ->setTitle($faker->unique()->word())
                ->setSummary($faker->text(500))
                ->setVideoUrl('https://www.youtube.com/watch?v=dQw4w9WgXcQ')
                ->setTutorial($this->getReference(TutorialFixtures::REFERENCE_IDENTIFIER.$faker->numberBetween(1, TutorialFixtures::FIXTURE_RANGE)))
            ;

            ++$i;
            $manager->persist($chapter);
            $this->setReference(self::REFERENCE_IDENTIFIER.$i, $chapter);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            TutorialFixtures::class,
        ];
    }
}
