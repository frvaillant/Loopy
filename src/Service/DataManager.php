<?php

namespace App\Service;

use App\Entity\Data;
use Doctrine\Common\Collections\Collection;

class DataManager
{
    /**
     * @param Collection|Data[] $data
     * @return array
     */
    public function prepareDataForGraphic(array $data): array
    {
        $result = [];
        $data = array_reverse($data);
        foreach ($data as $datum) {
            $result['value'][] = $datum->getValue();
            $result['addedAt'][] = $datum->getAddedAt()->format('d/m H\hi');
        }

        return $result;
    }
}
