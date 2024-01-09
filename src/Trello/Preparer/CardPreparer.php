<?php

declare(strict_types=1);

namespace App\Trello\Preparer;

use App\Entity\Trello\Board;
use App\Entity\Trello\Card;
use App\Repository\Trello\BoardListRepository;
use App\Repository\Trello\BoardRepository;
use App\Repository\Trello\CardRepository;
use App\Repository\Trello\MemberRepository;
use App\Repository\Trello\OrganizationRepository;
use Doctrine\Common\Collections\ArrayCollection;

class CardPreparer extends AbstractPreparer
{
    public function __construct(
        private readonly CardRepository $cardRepository,
        private readonly BoardListRepository $boardListRepository,
        private readonly MemberRepository $memberRepository,
    ) {
    }

    /**
     * @param array $apiDatum
     * @return Card
     */
    public function prepareOne(array $apiDatum): Card
    {
        [
            'id' => $id,
            'name' => $name,
            'desc' => $description,
            'url' => $url,
            'idList' => $idList,
            'idMembers' => $idMembers,
        ] = $apiDatum;

        if (!$card = $this->cardRepository->findOneBy(['id' => $id])) {
            $card = new Card;
            $card->setId($id);
        }

        $name !== $card->getName() && $card->setName($name);
        $description !== $card->getDescription() && $card->setDescription($description);
        $url !== $card->getUrl() && $card->setUrl($url);

        if ($boardList = $this->boardListRepository->findOneBy(['id' => $idList])) {
            $card->setBoardList($boardList);
        }

        $members = new ArrayCollection();
        /** @var array $idMembers */
        foreach ($idMembers as $idMember) {
            if ($member = $this->memberRepository->findOneBy(['id' => $idMember])) {
                $members->add($member);
            }
        }

        !$members->isEmpty() && $card->setMembers($members);

        return $card;
    }
}
