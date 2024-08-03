<?php
namespace App\Service;

use DateTimeZone;
use DateTime;

class DateInfoService
{
    /**
     * @param string $timezone
     * @return string
     */
    public function getTimeOffset($timezone): string
    {
        $timezone = new DateTimeZone($timezone);
        $offset = $timezone->getOffset(new DateTime()) / 60;

        return $offset > 0 ? '+' . $offset : $offset;
    }

    /**
     * @param int $year
     * @return int
     */
    public function getDaysInFebruary(int $year): int
    {
        return (new DateTime("{$year}-02-01"))->format('L') ? 29 : 28;
    }
}
