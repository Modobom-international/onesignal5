<?php

namespace App\Helper;

class DateTime
{
    const DIFF_TYPE_DAY = 'day';
    const DIFF_TYPE_WEEK = 'week';
    const DIFF_TYPE_MONTH = 'month';
    const DIFF_TYPE_AT = 'at';
    public static $DIFF_TYPE_SUPPORT = [self::DIFF_TYPE_DAY, self::DIFF_TYPE_WEEK, self::DIFF_TYPE_MONTH, self::DIFF_TYPE_AT];

    /**
     * Convert date string to `dd-mm-yyyy`
     *
     * ex: 2016-09-04 => 04-09-2016
     *
     * @param $date
     *
     * @return string
     */
    public static function toDayFirstStyle($date)
    {
        //prepare
        $parts = explode(' ', $date);
        $date = $parts[0];
        $suffix = null;
        if (isset($parts[1])) {
            $suffix = $parts[1];
        }

        $parts = explode('-', $date);
        if (4 === strlen($parts[2])) {
            return implode(' ', [$date, $suffix]);
        }

        $tmp = $parts[0];
        $parts[0] = $parts[2];
        $parts[2] = $tmp;

        return implode(' ', [implode('-', $parts), $suffix]);
    }

    /**
     * Convert date string to `yyyy-mm-dd`
     *
     * ex: 04-09-2016 => 2016-09-04
     *
     * @param $date
     *
     * @return string
     */
    public static function toYearFirstStyle($date)
    {
        //prepare
        $parts = explode(' ', $date);
        $date = $parts[0];
        $suffix = null;
        if (isset($parts[1])) {
            $suffix = $parts[1];
        }

        $parts = explode('-', $date);
        if (4 === strlen($parts[0])) {
            return implode(' ', [$date, $suffix]);
        }

        $tmp = $parts[0];
        $parts[0] = $parts[2];
        $parts[2] = $tmp;

        return implode(' ', [implode('-', $parts), $suffix]);
    }

    /**
     * @param        $date1
     * @param        $date2
     * @param string $type
     *
     * @return int|mixed|number
     * @throws \Exception
     */
    public static function diff($date1, $date2, $type = self::DIFF_TYPE_DAY)
    {
        if (!in_array($type, self::$DIFF_TYPE_SUPPORT)) {
            throw new \Exception(sprintf('Diff type %s is not supported', $type));
        }

        $date1 = self::toYearFirstStyle($date1);
        $date2 = self::toYearFirstStyle($date2);

        $datetime1 = date_create($date1);
        $datetime2 = date_create($date2);
        /** @var \DateInterval $interval */
        $interval = date_diff($datetime1, $datetime2);

        if (self::DIFF_TYPE_DAY == $type) {
            return $interval->days;
        }

        if (self::DIFF_TYPE_MONTH == $type) {
            return $interval->m;
        }

        if (self::DIFF_TYPE_WEEK == $type) {
            return abs(date('W', strtotime($date1)) - date('W', strtotime($date2)));
        }

        return 0;
    }

    /**
     * Creating date collection between two dates
     *
     * <code>
     * <?php
     * # Example 1
     * date_range("2014-01-01", "2014-01-20", "+1 day", "m/d/Y");
     *
     * # Example 2. you can use even time
     * date_range("01:00:00", "23:00:00", "+1 hour", "H:i:s");
     * </code>
     *
     * @author Ali OYGUR <alioygur@gmail.com>
     *
     * @param string since any date, time or datetime format
     * @param string until any date, time or datetime format
     * @param string step
     * @param string date of output format
     *
     * @return array
     */
    public static function dateRange($first, $last, $step = '+1 day', $outputFormat = 'd-m-Y')
    {
        $first = self::toYearFirstStyle($first);
        $last = self::toYearFirstStyle($last);

        $dates = array();
        $current = strtotime($first);
        $last = strtotime($last);

        while ($current <= $last) {
            $dates[] = date($outputFormat, $current);
            $current = strtotime($step, $current);
        }

        return $dates;
    }

    /**
     * Get week range between two dates
     *
     * @param $first
     * @param $last
     *
     * @return array
     */
    public static function weekRange($first, $last)
    {
        $startWeek = date("W", strtotime($first));
        $endWeek = date("W", strtotime($last));
        $numberOfWeeks = $endWeek - $startWeek;

        $weeks = array();
        $incrementDate = $first;
        $weeks[] = $startWeek;
        $i = 1;

        if ($numberOfWeeks < 0) {
            $startYear = date("Y", strtotime($first));
            $lastWeekOfYear = date("W", strtotime("$startYear-12-28"));
            $numberOfWeeks = ($lastWeekOfYear - $startWeek) + $endWeek;
        }

        while ($i <= $numberOfWeeks) {
            $incrementDate = date("Y-m-d", strtotime($first." +$i week"));
            $weeks[] = date("W", strtotime($incrementDate));

            $i = $i + 1;
        }

        return $weeks;
    }

    /**
     * Get months range between two dates
     *
     * @param string $startDate
     * @param string $endDate
     * @param string $outputFormat
     *
     * @return array
     */
    public static function monthRange($startDate, $endDate, $outputFormat = 'm-Y')
    {
        $startDate = self::toYearFirstStyle($startDate);
        $endDate = self::toYearFirstStyle($endDate);

        $start = (new \DateTime($startDate))->modify('first day of this month');
        $end = (new \DateTime($endDate))->modify('first day of next month');
        $interval = \DateInterval::createFromDateString('1 month');
        $period = new \DatePeriod($start, $interval, $end);
        $months = [];

        foreach ($period as $dt) {
            $months[] = $dt->format($outputFormat);
        }

        return $months;
    }

    /**
     * Get current week of year of date given
     *
     * @param $date
     *
     * @return int
     */
    public static function getCurrentWeek($date)
    {
        return intval(date('W', strtotime(self::toYearFirstStyle($date))));
    }

    /**
     * Get current month of date given
     *
     * @param $date
     *
     * @return int
     */
    public static function getCurrentMonth($date)
    {
        return intval(date('m', strtotime(self::toYearFirstStyle($date))));
    }

    /**
     * Get distance info between two dates
     *
     * @param        $firstDate
     * @param        $secondDate
     * @param bool   $onlyDay
     *
     * @return array
     */
    public static function distance($firstDate, $secondDate, $onlyDay = false)
    {
        if ($onlyDay) {
            $firstDate = explode(' ', $firstDate)[0];
            $secondDate = explode(' ', $secondDate)[0];
        }
        $first = new \DateTime(self::toYearFirstStyle($firstDate));
        $second = new \DateTime(self::toYearFirstStyle($secondDate));

        /** @var \DateInterval $difference */
        $difference = $first->diff($second);

        return json_decode(json_encode($difference), true);
    }

    /**
     * Get UTC time with format given
     *
     * @param string $time
     * @param string $format
     *
     * @return string
     */
    public static function getUTCTime($time = 'now', $format = 'Y-m-d H:i:s')
    {
        return (new \DateTime($time, new \DateTimeZone('UTC')))->format($format);
    }

    /**
     * Get local time with format given
     *
     * @param string $format
     *
     * @return bool|string
     */
    public static function getLocalTime($format = 'Y-m-d H:i:s')
    {
        return date($format);
    }

    /**
     * Add hours to datetime (use system timezone)
     *
     * @param        $datetime
     * @param        $hour
     * @param string $format
     *
     * @return bool|string
     */
    public static function addHourLocalTime($datetime, $hour, $format = 'Y-m-d H:i:s')
    {
        return date($format, strtotime(sprintf('+%s hours', abs($hour)), strtotime($datetime)));
    }

    /**
     * Change timezone for datetime given
     *
     * @param        $datetime
     * @param        $oldTimezone
     * @param string $newTimezone
     * @param string $format
     *
     * @return string
     */
    public static function changeTimezone($datetime, $oldTimezone, $newTimezone = 'UTC', $format = 'Y-m-d H:i:s')
    {
        $object = new \DateTime($datetime, new \DateTimeZone($oldTimezone));
        $object->setTimeZone(new \DateTimeZone($newTimezone));

        return $object->format($format);
    }

    public static function setTimezone($datetime = 'now', $newTimezone = 'UTC', $format = 'Y-m-d H:i:s')
    {
        if ('now' == $datetime) {
            $datetime = date('Y-m-d H:i:s');
        }

        $object = new \DateTime($datetime);
        $object->setTimeZone(new \DateTimeZone($newTimezone));

        return $object->format($format);
    }

    public static function dateSub($datetime = 'now', $days = 1, $format = 'Y-m-d H:i:s')
    {
        if ('now' == $datetime) {
            $datetime = date('Y-m-d H:i:s');
        }

        $newDate = strtotime('-'.$days.' day', strtotime($datetime));

        return date($format, $newDate);
    }
}
