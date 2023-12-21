<?php

namespace App\Entity\Trello;

use App\Repository\Trello\MemberRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Table(name: 'trello_member')]
#[ORM\Entity(repositoryClass: MemberRepository::class)]
class Member extends AbstractTrelloEntity implements TrelloEntity
{
    #[ORM\Column]
    private ?string $avatarHash = null;

    #[ORM\Column]
    private ?string $avatarUrl = null;

    #[ORM\ManyToMany(targetEntity: Card::class, mappedBy: 'members')]
    #[ORM\InverseJoinColumn(name: 'trello_cards_members', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private Collection $cards;

    #[ORM\ManyToMany(targetEntity: Board::class, mappedBy: 'members')]
    #[ORM\InverseJoinColumn(name: 'trello_boards_members', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private Collection $boards;

    public function __construct()
    {
        $this->cards  = new ArrayCollection();
        $this->boards = new ArrayCollection();
    }

    public function getAvatarHash(): ?string
    {
        return $this->avatarHash;
    }

    public function setAvatarHash(string $avatarHash): void
    {
        $this->avatarHash = $avatarHash;
    }

    public function getAvatarUrl(): ?string
    {
        return $this->avatarUrl;
    }

    public function setAvatarUrl(string $avatarUrl): void
    {
        $this->avatarUrl = $avatarUrl;
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
            $card->addMember($this);
        }
    }

    public function removeCard(Card $card): void
    {
        if ($this->cards->contains($card)) {
            $this->cards->removeElement($card);
            $card->removeMember($this);
        }
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
            $board->addMember($this);
        }
    }

    public function removeBoard(Board $board): void
    {
        if ($this->boards->contains($board)) {
            $this->boards->removeElement($board);
            $board->removeMember($this);
        }
    }

    public function getFilename(): string
    {
        return 'users/' . $this->avatarHash . '.png';
    }
}