<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trello\Card;
use App\Repository\SprintRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SprintRepository::class)]
class Sprint extends AbstractEntity
{
    #[ORM\Column(length: 65)]
    private ?string $title = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\Column]
    private bool $isSuccessful = false;

    #[ORM\Column(nullable: true)]
    private ?float $storyPoints = null;

    #[ORM\OneToMany(mappedBy: 'sprint', targetEntity: Meeting::class)]
    private Collection $meetings;

    #[ORM\OneToMany(mappedBy: 'sprint', targetEntity: Card::class)]
    private Collection $cards;

    #[ORM\OneToMany(mappedBy: 'sprint', targetEntity: SprintUser::class, cascade: ['persist', 'remove'])]
    private Collection $sprintUsers;

    public function __construct()
    {
        $this->meetings = new ArrayCollection();
        $this->cards = new ArrayCollection();
        $this->sprintUsers = new ArrayCollection();
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): void
    {
        $this->endDate = $endDate;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTimeInterface $startDate): void
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

    public function addMeeting(Meeting $meeting): void
    {
        if (!$this->meetings->contains($meeting)) {
            $this->meetings->add($meeting);
            $meeting->setSprint($this);
        }
    }

    public function removeMeeting(Meeting $meeting): void
    {
        if ($this->meetings->contains($meeting)) {
            $this->meetings->removeElement($meeting);
            $meeting->setSprint(null);
        }
    }

    public function getCards(): ?Collection
    {
        return $this->cards;
    }

    public function setCards(?Collection $cards): void
    {
        $this->cards = $cards;
    }

    public function addCard(Card $card): void
    {
        if (!$this->cards->contains($card)) {
            $this->cards->add($card);
            $card->setSprint($this);
        }
    }

    public function removeCard(Card $card): void
    {
        if ($this->cards->contains($card)) {
            $this->cards->removeElement($card);
            $card->setSprint(null);
        }
    }

    public function getSprintUsers(): ?Collection
    {
        return $this->sprintUsers;
    }

    public function setSprintUsers(?Collection $sprintUsers): void
    {
        $this->sprintUsers = $sprintUsers;
    }

    public function addSprintUser(SprintUser $sprintUser): void
    {
        if (!$this->sprintUsers->contains($sprintUser)) {
            $this->sprintUsers->add($sprintUser);
            $sprintUser->setSprint($this);
        }
    }

    public function removeSprintUser(SprintUser $sprintUser): void
    {
        if ($this->sprintUsers->contains($sprintUser)) {
            $this->sprintUsers->removeElement($sprintUser);
            $sprintUser->setSprint(null);
        }
    }
}
