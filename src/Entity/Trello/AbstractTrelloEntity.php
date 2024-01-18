<?php

declare(strict_types=1);

namespace App\Entity\Trello;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\MappedSuperclass]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: true, hardDelete: false)]
abstract class AbstractTrelloEntity
{
    use SoftDeleteableEntity;
    use BlameableEntity;
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\Column]
    private ?string $id = null;

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getId(): ?string
    {
        return $this->id;
    }
}
