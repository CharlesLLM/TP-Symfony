<?php

namespace App\Entity;

use App\Entity\Traits\TimestampableTrait;
use App\Repository\TutorialRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: TutorialRepository::class)]
class Tutorial
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private ?Uuid $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[Gedmo\Blameable(on: 'create')]
    private ?User $createdBy = null;

    #[ORM\ManyToMany(targetEntity: Subject::class, inversedBy: 'chapters')]
    private Collection $subjects;

    #[ORM\OneToMany(mappedBy: 'tutorial', targetEntity: Chapter::class, orphanRemoval: true)]
    private Collection $chapters;

    public function __construct()
    {
        $this->subjects = new ArrayCollection();
        $this->chapters = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): static
    {
        if (null !== $createdBy && !$createdBy instanceof User) {
            return $this;
        }

        $this->createdBy = $createdBy;

        return $this;
    }

    public function getSubjects(): Collection
    {
        return $this->subjects;
    }

    public function addSubject(Subject $subject): static
    {
        if (!$this->subject->contains($subject)) {
            $this->subject->add($subject);
            $subject->setTutorial($this);
        }

        return $this;
    }

    public function removeSubject(Subject $subject): static
    {
        if ($this->subject->removeElement($subject)) {
            if ($subject->getTutorial() === $this) {
                $subject->setTutorial(null);
            }
        }

        return $this;
    }

    public function getChapters(): Collection
    {
        return $this->chapters;
    }

    public function addChapter(Chapter $chapter): static
    {
        if (!$this->chapter->contains($chapter)) {
            $this->chapter->add($chapter);
            $chapter->setTutorial($this);
        }

        return $this;
    }

    public function removeChapter(Chapter $chapter): static
    {
        if ($this->chapter->removeElement($chapter)) {
            if ($chapter->getTutorial() === $this) {
                $chapter->setTutorial(null);
            }
        }

        return $this;
    }
}
