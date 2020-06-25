<?php

namespace App\Service;

class NumberManager
{
    public static function addPointToPhoneNumber(?string $phone)
    {
        $phone = '0' . $phone;
        $result = '';
        for ($i = 0; $i < 10; $i++) {
            if ($i === 2 || $i == 4 || $i == 6 || $i == 8) {
                $result .= '.';
            }
            $result .= $phone[$i];
        }
        return $result;
    }
}
