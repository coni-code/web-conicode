<?php

namespace App\Entity\Trello;

use App\Repository\Trello\OrganizationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Table(name: 'trello_organization')]
#[ORM\Entity(repositoryClass: OrganizationRepository::class)]
class Organization extends AbstractTrelloEntity implements TrelloEntity
{
    #[ORM\Column]
    private ?string $name = null;

    #[ORM\Column]
    private ?string $displayName = null;

    #[ORM\Column]
    private ?string $description = null;

    #[ORM\Column]
    private ?string $url = null;

    #[ORM\OneToMany(mappedBy: 'organization', targetEntity: Board::class, cascade: ['remove'])]
    private Collection $boards;

    public function __construct()
    {
        $this->boards = new ArrayCollection();
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDisplayName(): ?string
    {
        return $this->displayName;
    }

    public function setDisplayName(string $displayName): void
    {
        $this->displayName = $displayName;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function getBoards(): Collection
    {
        return $this->boards;
    }

    public function setBoards(Collection $boards): void
    {
        $this->boards = $boards;
    }

    public function addBoard(Board $board): void
    {
        if (!$this->boards->contains($board)) {
            $this->boards->add($board);
            $board->setOrganization($this);
        }
    }

    public function removeBoard(Board $board): void
    {
        if ($this->boards->contains($board)) {
            $this->boards->removeElement($board);
            $board->setOrganization(null);
        }
    }
}
