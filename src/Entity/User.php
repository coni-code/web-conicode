<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\Dictionary\PositionDictionary;
use App\Entity\Trello\Member;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(stateless: false, normalizationContext: ['groups' => ['read']])]
#[ORM\Entity(repositoryClass: UserRepository::class)]
class User extends AbstractEntity implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var ?string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $surname = null;

    /** @var Collection<PositionDictionary> */
    #[ORM\ManyToMany(targetEntity: PositionDictionary::class, inversedBy: 'users', cascade: ['persist'])]
    #[ORM\JoinTable(name: 'users_positions')]
    private Collection $positions;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: UserLink::class, cascade: ['persist'])]
    private Collection $links;

    /** @var Collection<Meeting> */
    #[ORM\ManyToMany(targetEntity: Meeting::class, inversedBy: 'users', cascade: ['persist'])]
    #[ORM\JoinTable(name: 'users_meetings')]
    private Collection $meetings;

    #[ORM\OneToOne(mappedBy: 'user', targetEntity: Member::class, cascade: ['persist'])]
    private ?Member $member = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: SprintUser::class, cascade: ['persist', 'remove'])]
    private ?Collection $sprintUsers = null;

    #[ORM\Column]
    private ?string $cvFilename = null;

    public function __construct()
    {
        $this->meetings = new ArrayCollection();
        $this->positions = new ArrayCollection();
        $this->links = new ArrayCollection();
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(?string $surname): void
    {
        $this->surname = $surname;
    }

    public function getPositions(): Collection
    {
        return $this->positions;
    }

    public function setPositions(Collection $positions): void
    {
        $this->positions = $positions;
    }

    public function addPosition(PositionDictionary $position): void
    {
        if (!$this->positions->contains($position)) {
            $this->positions->add($position);
            $position->addUser($this);
        }
    }

    public function removePosition(PositionDictionary $position): void
    {
        if ($this->positions->contains($position)) {
            $this->positions->removeElement($position);
            $position->removeUser($this);
        }
    }

    public function getLinks(): Collection
    {
        return $this->links;
    }

    public function setLinks(Collection $links): void
    {
        $this->links = $links;
    }

    public function addLink(UserLink $link): void
    {
        if (!$this->links->contains($link)) {
            $this->links->add($link);
            $link->setUser($this);
        }
    }

    public function removeLink(UserLink $link): void
    {
        if ($this->links->contains($link)) {
            $this->links->removeElement($link);
            $link->setUser(null);
        }
    }

    public function getMember(): ?Member
    {
        return $this->member;
    }

    public function setMember(?Member $member): void
    {
        $this->member = $member;
    }

    public function getMeetings(): Collection
    {
        return $this->meetings;
    }

    public function setMeetings(Collection $meetings): void
    {
        $this->meetings = $meetings;
    }

    public function addMeeting(Meeting $meeting): void
    {
        if (!$this->meetings->contains($meeting)) {
            $this->meetings->add($meeting);
            $meeting->addUser($this);
        }
    }

    public function removeMeeting(Meeting $meeting): void
    {
        if ($this->meetings->contains($meeting)) {
            $this->meetings->removeElement($meeting);
            $meeting->removeUser($this);
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
            $sprintUser->setUser($this);
        }
    }

    public function removeSprintUser(SprintUser $sprintUser): void
    {
        if ($this->sprintUsers->contains($sprintUser)) {
            $this->sprintUsers->removeElement($sprintUser);
            $sprintUser->setUser(null);
        }
    }

    #[Groups('read')]
    public function getDisplayName(): string
    {
        return $this->__toString();
    }

    public function getCvFilename(): ?string
    {
        return $this->cvFilename;
    }

    public function setCvFilename(?string $cvFilename): void
    {
        $this->cvFilename = $cvFilename;
    }

    public function __toString(): string
    {
        if ($this->getName() && $this->getSurname()) {
            return sprintf(
                '%s %s (%s)',
                $this->getName(),
                $this->getSurname(),
                $this->getEmail(),
            );
        }

        return $this->getEmail();
    }
}
