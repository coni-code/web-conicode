<?php

namespace App\Entity\Trello;

use App\Repository\Trello\BoardRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Table(name: 'trello_board')]
#[UniqueEntity(fields: 'trelloId')]
#[ORM\Entity(repositoryClass: BoardRepository::class)]
class Board extends AbstractTrelloEntity implements TrelloEntity
{
    #[ORM\Column]
    private ?string $name = null;

    #[ORM\ManyToOne(targetEntity: Organization::class, cascade: ['remove'], inversedBy: 'boards')]
    #[ORM\JoinColumn(name: 'organization_id', referencedColumnName: 'id')]
    private ?Organization $organization = null;

    #[ORM\OneToMany(mappedBy: 'board', targetEntity: BoardList::class, cascade: ['remove'])]
    private Collection $boardLists;

    #[ORM\ManyToMany(targetEntity: Member::class, inversedBy: 'boards', cascade: ['remove'])]
    #[ORM\JoinTable(name: 'trello_boards_members')]
    private Collection $members;

    public function __construct()
    {
        $this->boardLists = new ArrayCollection();
        $this->members = new ArrayCollection();
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getOrganization(): ?Organization
    {
        return $this->organization;
    }

    public function setOrganization(?Organization $organization): void
    {
        $this->organization = $organization;
    }

    public function getBoardLists(): Collection
    {
        return $this->boardLists;
    }

    public function setBoardLists(Collection $lists): void
    {
        $this->boardLists = $lists;
    }

    public function addBoardList(BoardList $boardList): void
    {
        if (!$this->boardLists->contains($boardList)) {
            $this->boardLists->add($boardList);
            $boardList->setBoard($this);
        }
    }

    public function removeBoardList(BoardList $boardList): void
    {
        if ($this->boardLists->contains($boardList)) {
            $this->boardLists->removeElement($boardList);
            $boardList->setBoard(null);
        }
    }

    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function setMembers(Collection $members): void
    {
        $this->members = $members;
    }

    public function addMember(Member $member): void
    {
        if (!$this->members->contains($member)) {
            $this->members->add($member);
            $member->addBoard($this);
        }
    }

    public function removeMember(Member $member): void
    {
        if (!$this->members->contains($member)) {
            $this->members->removeElement($member);
            $member->removeBoard($this);
        }
    }
}
