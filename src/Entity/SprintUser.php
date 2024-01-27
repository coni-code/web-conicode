<?php

namespace App\Entity;

use App\Repository\SprintUserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SprintUserRepository::class)]
class SprintUser extends AbstractEntity
{
    #[ORM\Column]
    private ?float $availabilityInHours = null;

    #[ORM\ManyToOne(targetEntity: Sprint::class, inversedBy: 'sprintUsers')]
    #[ORM\JoinColumn(name: 'sprint_id', referencedColumnName: 'id')]
    private ?Sprint $sprint = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'sprintUsers')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private ?User $user = null;

    public function getAvailabilityInHours(): ?float
    {
        return $this->availabilityInHours;
    }

    public function setAvailabilityInHours(?float $availabilityInHours): void
    {
        $this->availabilityInHours = $availabilityInHours;
    }

    public function getSprint(): ?Sprint
    {
        return $this->sprint;
    }

    public function setSprint(?Sprint $sprint): void
    {
        $this->sprint = $sprint;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): void
    {
        $this->user = $user;
    }
}
