<?php

namespace App\Entity;

use App\Entity\Trello\Card;
use App\Repository\SprintRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Collection;

#[ORM\Entity(repositoryClass: SprintRepository::class)]
class Sprint extends AbstractEntity
{
    #[ORM\Column(length: 65)]
    private ?string $title = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?DateTimeInterface $endDate = null;

    #[ORM\Column]
    private bool $isSuccessful = false;

    #[ORM\Column(nullable: true)]
    private ?float $storyPoints = null;

    #[ORM\OneToMany(mappedBy: 'sprint', targetEntity: Meeting::class)]
    private ?Collection $meetings = null;

    #[ORM\OneToMany(mappedBy: 'sprint', targetEntity: Card::class)]
    private ?Collection $cards = null;

    #[ORM\OneToMany(mappedBy: 'sprint', targetEntity: SprintUser::class)]
    private ?Collection $sprintUsers = null;

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getEndDate(): ?DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?DateTimeInterface $endDate): void
    {
        $this->endDate = $endDate;
    }

    public function getStartDate(): ?DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(?DateTimeInterface $startDate): void
    {
        $this->startDate = $startDate;
    }

    public function isSuccessful(): bool
    {
        return $this->isSuccessful;
    }

    public function setIsSuccessful(bool $isSuccessful): void
    {
        $this->isSuccessful = $isSuccessful;
    }

    public function getStoryPoints(): ?float
    {
        return $this->storyPoints;
    }

    public function setStoryPoints(?float $storyPoints): void
    {
        $this->storyPoints = $storyPoints;
    }

    public function getMeetings(): ?Collection
    {
        return $this->meetings;
    }

    public function setMeetings(?Collection $meetings): void
    {
        $this->meetings = $meetings;
    }

    public function getCards(): ?Collection
    {
        return $this->cards;
    }

    public function setCards(?Collection $cards): void
    {
        $this->cards = $cards;
    }
}
