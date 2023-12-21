<?php

namespace App\Entity\Trello;

use App\Repository\Trello\BoardListRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Table(name: 'trello_list')]
#[ORM\Entity(repositoryClass: BoardListRepository::class)]
class BoardList extends AbstractTrelloEntity implements TrelloEntity
{
    #[ORM\Column]
    private ?string $name = null;

    #[ORM\ManyToOne(targetEntity: Board::class, inversedBy: 'boardLists')]
    #[ORM\JoinColumn(name: 'board_id', referencedColumnName: 'id')]
    private ?Board $board = null;

    #[ORM\OneToMany(mappedBy: 'boardList', targetEntity: Card::class, orphanRemoval: true)]
    private Collection $cards;

    #[ORM\Column(type: 'boolean', options: ['default' => true])]
    private bool $visible = true;

    public function __construct()
    {
        $this->cards = new ArrayCollection();
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getBoard(): ?Board
    {
        return $this->board;
    }

    public function setBoard(?Board $board): void
    {
        $this->board = $board;
    }

    public function getCards(): Collection
    {
        return $this->cards;
    }

    public function setCards(Collection $cards): void
    {
        $this->cards = $cards;
    }

    public function addCard(Card $card): void
    {
        if (!$this->cards->contains($card)) {
            $this->cards->add($card);
            $card->setBoardList($this);
        }
    }

    public function removeCard(Card $card): void
    {
        if ($this->cards->contains($card)) {
            $this->cards->removeElement($card);
            $card->setBoardList(null);
        }
    }

    public function isVisible(): bool
    {
        return $this->visible;
    }

    public function setVisible(bool $visible): void
    {
        $this->visible = $visible;
    }

    public function __toString(): string
    {
        return $this->getTrelloId();
    }
}
