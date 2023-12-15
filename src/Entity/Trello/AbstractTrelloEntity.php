<?php

namespace App\Entity\Trello;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\MappedSuperclass]
#[Gedmo\SoftDeleteable(fieldName: "deletedAt", timeAware: true, hardDelete: false)]
class AbstractTrelloEntity
{
    use SoftDeleteableEntity;
    use BlameableEntity;
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?string $id = null;

    #[ORM\Column]
    private string $trelloId;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getTrelloId(): string
    {
        return $this->trelloId;
    }

    public function setTrelloId(string $trelloId): void
    {
        $this->trelloId = $trelloId;
    }
}
