<?php

namespace App\Trello\Preparer;

use App\Entity\Trello\TrelloEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

abstract class AbstractPreparer
{
    /**
     * @param array $apiData
     * @return Collection
     */
    public function prepare(array $apiData): Collection
    {
        $collection = new ArrayCollection();

        foreach ($apiData as $apiDatum) {
            $collection->add($this->prepareOne($apiDatum));
        }

        return $collection;
    }
    abstract public function prepareOne(array $apiDatum): TrelloEntity;
}
