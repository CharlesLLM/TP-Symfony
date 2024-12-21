<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Enum\CommentStatusEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

final class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public const string REFERENCE_IDENTIFIER = 'comment_';
    public const int FIXTURE_RANGE = 100;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        foreach (range(0, self::FIXTURE_RANGE - 1) as $i) {
            $comment = new Comment();
            $comment
                ->setContent($faker->text(500))
                ->setStatus(CommentStatusEnum::random())
                ->setAuthor($this->getReference(UserFixtures::REFERENCE_IDENTIFIER.$faker->numberBetween(1, UserFixtures::FIXTURE_RANGE)))
                ->setChapter($this->getReference(ChapterFixtures::REFERENCE_IDENTIFIER.$faker->numberBetween(1, ChapterFixtures::FIXTURE_RANGE)))
            ;

            if ($i > 3) {
                $comment->setParent($this->getReference(self::REFERENCE_IDENTIFIER.$faker->numberBetween(1, $i)));
            }

            ++$i;
            $manager->persist($comment);
            $this->setReference(self::REFERENCE_IDENTIFIER.$i, $comment);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            ChapterFixtures::class,
        ];
    }
}
