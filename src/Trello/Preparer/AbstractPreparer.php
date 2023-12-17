<?php

namespace App\Trello\Preparer;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

abstract class AbstractPreparer
{
    public function prepare(array $apiData): Collection
    {
        $collection = new ArrayCollection();

        foreach ($apiData as $apiDatum) {
            $collection->add($this->prepareOne($apiDatum));
        }

        return $collection;
    }
}
