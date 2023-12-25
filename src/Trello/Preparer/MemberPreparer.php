<?php

namespace App\Trello\Preparer;

use App\Entity\Trello\Board;
use App\Entity\Trello\Member;
use App\Repository\Trello\MemberRepository;
use Doctrine\Common\Collections\Collection;

class MemberPreparer extends AbstractPreparer
{
    public function __construct(private readonly MemberRepository $memberRepository)
    {
    }

    public function prepareOne(array $apiDatum): Member
    {
        [
            'id' => $id,
            'avatarHash' => $avatarHash,
            'avatarUrl' => $avatarUrl,
        ] = $apiDatum;

        if (!$member = $this->memberRepository->findOneBy(['id' => $id])) {
            $member = new Member();
            $member->setId($id);
        }

        $avatarHash !== $member->getAvatarHash() && $member->setAvatarHash($avatarHash);
        $avatarUrl !== $member->getAvatarUrl() && $member->setAvatarUrl($avatarUrl);

        return $member;
    }

    /**
     * @param Collection $members
     * @param Board $board
     * @return Collection<Member>
     */
    public function addBoard(Collection $members, Board $board): Collection
    {
        /** @var Member $member */
        foreach ($members as $member) {
            $member->addBoard($board);
        }

        return $members;
    }
}
