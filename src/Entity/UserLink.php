<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\LinkTypeEnum;
use App\Repository\UserLinkRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserLinkRepository::class)]
class UserLink extends AbstractEntity
{
    #[ORM\Column(type: Types::STRING, enumType: LinkTypeEnum::class)]
    private ?LinkTypeEnum $type = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $url = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $iconPath = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'links')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private ?User $user = null;

    public function getType(): ?LinkTypeEnum
    {
        return $this->type;
    }

    public function setType(LinkTypeEnum $type): void
    {
        $this->type = $type;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function getIconPath(): ?string
    {
        return $this->iconPath;
    }

    public function setIconPath(string $iconPath): void
    {
        $this->iconPath = $iconPath;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): void
    {
        $this->user = $user;
    }
}
