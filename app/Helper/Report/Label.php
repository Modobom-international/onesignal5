<?php

namespace App\Helper\Report;
use App\Helper\DateTime;

class Label
{
    public static function getLabels($startDate, $endDate, $splitType = DateTime::DIFF_TYPE_DAY)
    {
        if (!in_array($splitType, DateTime::$DIFF_TYPE_SUPPORT)) {
            throw new \InvalidArgumentException('Split type is invalid!');
        }

        $labels = [];
        if (DateTime::DIFF_TYPE_DAY == $splitType) {
            $labels = DateTime::dateRange($startDate, $endDate, '+1 day', 'd-m-Y');
        }

        if (DateTime::DIFF_TYPE_WEEK == $splitType) {
            $labels = DateTime::weekRange($startDate, $endDate);
        }

        if (DateTime::DIFF_TYPE_MONTH == $splitType) {
            $labels = DateTime::monthRange($startDate, $endDate, 'm-Y');
        }

        return $labels;
    }

    public static function formatWeekLabels($labels, $format = 'd-m-Y')
    {
        //[32, 33, 34, 35, 36, 37, 38]
        $year = date('Y'); //todo: don't hard code
        foreach ($labels as $index => $label) {
            $dates = self::getWeekDates($year, $label, $format);
            $labels[$index] = $label.' ('.$dates['from'].' >> '.$dates['to'].')';
        }

        return $labels;
    }

    private static function getWeekDates($year, $week, $format = 'd-m-Y')
    {
        $from = date($format, strtotime("{$year}-W{$week}-1")); //Returns the date of monday in week
        $to = date($format, strtotime("{$year}-W{$week}-7"));   //Returns the date of sunday in week

        return [
            'from' => $from,
            'to' => $to
        ];
    }
}
