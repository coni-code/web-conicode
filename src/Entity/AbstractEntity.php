<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\MappedSuperclass]
#[Gedmo\SoftDeleteable(fieldName: "deletedAt", timeAware: true, hardDelete: false)]
class AbstractEntity
{
    use SoftDeleteableEntity;
    use BlameableEntity;
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?string $id = null;

    public function getId(): ?string
    {
        return $this->id;
    }
}
