<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Enum\MeetingStatusEnum;
use App\Repository\MeetingRepository;
use App\Service\ApiFilter\MeetingFilter;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(stateless: false, normalizationContext: ['groups' => ['read']])]
#[ApiFilter(MeetingFilter::class)]
#[ORM\Entity(repositoryClass: MeetingRepository::class)]
class Meeting
{
    #[Groups('read')]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups('read')]
    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[Groups('read')]
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?DateTimeInterface $startDate = null;

    #[Groups('read')]
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?DateTimeInterface $endDate = null;

    #[Groups('read')]
    #[ORM\Column(type: Types::STRING, enumType: MeetingStatusEnum::class, options: [
        'default' => MeetingStatusEnum::STATUS_PENDING,
    ])]
    private MeetingStatusEnum $status = MeetingStatusEnum::STATUS_PENDING;

    /** @var Collection<User> */
    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'meetings', cascade: ['persist'])]
    private Collection $users;

    #[ORM\ManyToOne(targetEntity: Sprint::class, inversedBy: 'meetings')]
    #[ORM\JoinColumn(name: 'sprint_id', referencedColumnName: 'id')]
    private ?Sprint $sprint = null;

    public function __construct()
    {
        $this->users = new ArrayCollection();
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

    public function getStartDate(): ?DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(DateTimeInterface $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(DateTimeInterface $endDate): static
    {
        $this->endDate = $endDate;

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
}
