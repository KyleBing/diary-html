<?php


class StatisticMonth
{
    var $year;
    var $months;

    public function __construct(int $year, array $months)
    {
        $this->year = $year;
        $this->months = $months;
    }
}


