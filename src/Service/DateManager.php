<?php

namespace App\Service;

use DateInterval;
use DateTime;

class DateManager
{
    public static function dateIntervalBetweenNowAnd(DateTime $date): DateInterval
    {
        $now = new DateTime();

        return $date->diff($now);
    }
}
