<?php

declare(strict_types=1);

namespace App\Entity\Dictionary;

use App\Entity\AbstractEntity;
use App\Entity\User;
use App\Repository\PositionDictionaryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PositionDictionaryRepository::class)]
class PositionDictionary extends AbstractEntity
{
    #[ORM\Column(type: Types::STRING, length: 24)]
    private ?string $name = null;

    /** @var Collection<User> */
    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'positions', cascade: ['persist'])]
    private Collection $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
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
            $user->addPosition($this);
        }
    }

    public function removeUser(User $user): void
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $user->removePosition($this);
        }
    }

    public function __toString(): string
    {
        return $this->getName();
    }
}
