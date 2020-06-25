<?php

namespace App\Service;

use App\Entity\Data;
use Doctrine\Common\Collections\Collection;

class DataManager
{
    const PERIODE = ['Matin', 'Midi', 'Soir'];

    /**
     * @param Collection|Data[] $data
     * @return array
     */
    public function prepareDataForGraphic(array $data): array
    {
        $result = [];
        $data = array_reverse($data);
        $num = 0;
        foreach ($data as $datum) {
            $result['value'][] = $datum->getValue();
            $result['addedAt'][] = $datum->getAddedAt()->format('d/m') . ' ' . self::PERIODE[$num];
            $num++;
            if ($num === 3) {
                $num = 0;
            }
        }

        return $result;
    }
}
