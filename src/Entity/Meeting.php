<?php

namespace App\Entity;

use App\Enum\MeetingStatusEnum;
use App\Repository\MeetingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MeetingRepository::class)]
class Meeting
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(
        type: Types::STRING,
        enumType: MeetingStatusEnum::class,
        options: ["default"=>MeetingStatusEnum::STATUS_PENDING]
    )]
    private MeetingStatusEnum $status = MeetingStatusEnum::STATUS_PENDING;

    /** @var Collection<User> */
    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'meetings', cascade: ['persist'])]
    private Collection $users;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Vote::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private Collection $votes;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->votes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getStatus(): MeetingStatusEnum
    {
        return $this->status;
    }

    public function setStatus(MeetingStatusEnum $status): void
    {
        $this->status = $status;
    }

    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function setUsers(Collection $users): void
    {
        $this->users = $users;
    }

    public function addUser(User $user): void
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addMeeting($this);
        }
    }

    public function removeUser(User $user): void
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $user->removeMeeting($this);
        }
    }

    public function getVotes(): Collection
    {
        return $this->votes;
    }

    public function setVotes(Collection $votes): void
    {
        $this->votes = $votes;
    }

    public function addVote(Vote $vote): void
    {
        if (!$this->votes->contains($vote)) {
            $this->votes->add($vote);
            $vote->setMeeting($this);
        }
    }

    public function removeVote(Vote $vote): void
    {
        if ($this->votes->contains($vote)) {
            $this->votes->removeElement($vote);
            $vote->setMeeting(null);
        }
    }
}
