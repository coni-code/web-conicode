<?php

declare(strict_types=1);

namespace App\Entity\Trello;

use App\Entity\Sprint;
use App\Repository\Trello\CardRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'trello_card')]
#[ORM\Entity(repositoryClass: CardRepository::class)]
class Card extends AbstractTrelloEntity implements TrelloEntity
{
    #[ORM\Column]
    private ?string $name = null;

    #[ORM\Column(type: 'text')]
    private ?string $description = null;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $storyPoints = null;

    #[ORM\Column]
    private ?string $url = null;

    #[ORM\ManyToOne(targetEntity: BoardList::class, inversedBy: 'cards')]
    #[ORM\JoinColumn(name: 'board_list_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private ?BoardList $boardList = null;

    #[ORM\ManyToMany(targetEntity: Member::class, inversedBy: 'cards', orphanRemoval: true)]
    #[ORM\JoinTable(name: 'trello_cards_members')]
    private Collection $members;

    #[ORM\ManyToOne(targetEntity: Sprint::class, inversedBy: 'cards')]
    #[ORM\JoinColumn(name: 'sprint_id', referencedColumnName: 'id')]
    private ?Sprint $sprint = null;

    public function __construct()
    {
        $this->members = new ArrayCollection();
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
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

    public function getBoardList(): ?BoardList
    {
        return $this->boardList;
    }

    public function setBoardList(?BoardList $boardList): void
    {
        $this->boardList = $boardList;
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
            $member->addCard($this);
        }
    }

    public function removeMember(Member $member): void
    {
        if ($this->members->contains($member)) {
            $this->members->removeElement($member);
            $member->removeCard($this);
        }
    }

    public function getSummary(): ?string
    {
        if (!$this->getDescription()) {
            return null;
        }
        preg_match('/### SUMMARY\n(.*)/s', $this->getDescription(), $matches);

        return $matches[1] ?? null;
    }

    public function getStoryPoints(): ?float
    {
        return $this->storyPoints;
    }

    public function setStoryPoints(?float $storyPoints): void
    {
        $this->storyPoints = $storyPoints;
    }

    public function getSprint(): ?Sprint
    {
        return $this->sprint;
    }

    public function setSprint(?Sprint $sprint): void
    {
        $this->sprint = $sprint;
    }
}
