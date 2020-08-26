<?php

namespace App\Services;

use App\Traits\Singleton;

class DateService
{
    use Singleton;

    public function getDatesThisPrevNext($date)
    {
        $weeks = [];
        $dates = [];
        $blocks = [
            'Previous' => "{$date} - 1 week",
            'This' => "{$date} ",
            'Next' => "{$date} + 1 week",
        ];
        $first = null;
        $last = null;
        foreach ($blocks as $label => $dateString) {
            $weeks[$label] = [];
            foreach ($this->getWeekDates(date("Y-m-d", strtotime($dateString))) as $day) {
                if ($first === null) {
                    $first = $day;
                }
                $last = $day;
                $dates[$day] = $label;
                $weeks[$label][] = $day;
            }
        }
        return [$weeks, $dates, $first, $last];

    }

    public function getWeekDates($date)
    {
        list($start, $end) = $this->x_week_range($date);
        $dates = [];
        $date = $start;
        $x = 0;
        do {
            $dates[] = $date;
            $date = date("Y-m-d", strtotime("{$date} + 1 day"));
            $x++;
        } while (strtotime($date) <= strtotime($end) && $x < 20);
        return $dates;

    }

    private function x_week_range($date)
    {
        $ts = strtotime($date);
        $start = (date('w', $ts) == 0) ? $ts : strtotime('last sunday', $ts);
        return array(date('Y-m-d', $start),
            date('Y-m-d', strtotime('next saturday', $start)));
    }
}
