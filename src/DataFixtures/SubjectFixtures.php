<?php

namespace App\DataFixtures;

use App\Entity\Subject;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class SubjectFixtures extends Fixture
{
    public const string REFERENCE_IDENTIFIER = 'subject_';
    public const int FIXTURE_RANGE = 4;
    public const array DATA = [
        'action' => [
            'name' => 'Action',
        ],
        'adventure' => [
            'name' => 'Aventure',
        ],
        'comedy' => [
            'name' => 'Comédie',
        ],
        'sci-fi' => [
            'name' => 'Science Fiction',
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::DATA as $key => $data) {
            $subject = new Subject();
            $subject
                ->setName($data['name'])
                ->setSlug($key)
            ;

            $manager->persist($subject);
            $this->setReference(self::REFERENCE_IDENTIFIER.$key, $subject);
        }

        $manager->flush();
    }
}
