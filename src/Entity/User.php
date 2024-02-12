<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\Trello\Member;
use App\Enum\PositionEnum;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
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
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $surname = null;

    #[ORM\Column(nullable: true, enumType: PositionEnum::class)]
    private array $positions = [];

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $githubLink = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $gitlabLink = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $linkedinLink = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $websiteLink = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $youtubeLink = null;

    /** @var Collection<Meeting> */
    #[ORM\ManyToMany(targetEntity: Meeting::class, inversedBy: 'users', cascade: ['persist'])]
    #[ORM\JoinTable(name: 'users_meetings')]
    private Collection $meetings;

    #[ORM\OneToOne(mappedBy: 'user', targetEntity: Member::class, cascade: ['persist'])]
    private ?Member $member = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: SprintUser::class, cascade: ['persist', 'remove'])]
    private ?Collection $sprintUsers = null;

    public function __construct()
    {
        $this->meetings = new ArrayCollection();
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

    public function getPositions(): array
    {
        return $this->positions;
    }

    public function setPositions(array $positions): void
    {
        $this->positions = $positions;
    }

    public function addPosition(PositionEnum $position): void
    {
        $this->positions[] = $position;
    }

    public function removePosition(array $positions, $position): void
    {
        unset($positions[array_search($position, $positions)]);
    }



    public function getGithubLink(): ?string
    {
        return $this->githubLink;
    }

    public function setGithubLink(?string $githubLink): void
    {
        $this->githubLink = $githubLink;
    }

    public function getGitlabLink(): ?string
    {
        return $this->gitlabLink;
    }

    public function setGitlabLink(?string $gitlabLink): void
    {
        $this->gitlabLink = $gitlabLink;
    }

    public function getLinkedinLink(): ?string
    {
        return $this->linkedinLink;
    }

    public function setLinkedinLink(?string $linkedinLink): void
    {
        $this->linkedinLink = $linkedinLink;
    }

    public function getWebsiteLink(): ?string
    {
        return $this->websiteLink;
    }

    public function setWebsiteLink(?string $websiteLink): void
    {
        $this->websiteLink = $websiteLink;
    }

    public function getYoutubeLink(): ?string
    {
        return $this->youtubeLink;
    }

    public function setYoutubeLink(?string $youtubeLink): void
    {
        $this->youtubeLink = $youtubeLink;
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
