<?php

namespace App\DTO;

class DateInfoFormData
{
    private string $date;

    private string $timezone;

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @param string $date
     * @return void
     */
    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getTimezone(): string
    {
        return $this->timezone;
    }

    /**
     * @param string $timezone
     * @return void
     */
    public function setTimezone(string $timezone): void
    {
        $this->timezone = $timezone;
    }
}
