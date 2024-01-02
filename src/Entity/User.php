<?php

namespace App\Entity;

use App\Entity\Trello\Member;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User extends AbstractEntity implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    /** @var Collection<Meeting> */
    #[ORM\ManyToMany(targetEntity: Meeting::class, inversedBy: 'users', cascade: ['persist'])]
    #[ORM\JoinTable(name: 'users_meetings')]
    private Collection $meetings;

    #[ORM\OneToOne(inversedBy: 'user', targetEntity: Member::class, cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'member_id', referencedColumnName: 'id')]
    private ?Member $member = null;

    public function __construct()
    {
        $this->meetings = new ArrayCollection();
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
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

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
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

    public function __toString(): string
    {
        return $this->getEmail();
    }
}
