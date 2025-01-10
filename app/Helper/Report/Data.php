<?php


namespace App\Helper\Report;

use App\Helper\Common;
use App\Helper\DateTime;
use Carbon\Carbon;

class Data
{
    /**
     * @param $startDate
     * @param $endDate
     * @param $country
     * @param $platform
     * @param $appId
     * @return array
     */
    public static function getDownloadCount($startDate, $endDate, $country, $platform, $appId)
    {
        $selectDate = 'DATE_FORMAT(created_date, "%d-%m-%Y") as day';
        $groupBy = 'created_date';
        $dateCondition = ' AND (created_date between :startDate AND :endDate) ';

        $startDate = DateTime::toYearFirstStyle($startDate);
        $endDate = DateTime::toYearFirstStyle($endDate);
        $bindingData = [
            'startDate' => $startDate,
            'endDate' => $endDate,
        ];

        $countryCondition = null;
        if (!empty($country)) {
            $countryCondition = ' country = :country ';
            $bindingData['country'] = $country;
        }

        $platformCondition = null;
        if (!empty($platform)) {
            $platformCondition = ' AND platform = :platform ';
            $bindingData['platform'] = $platform;
        }

        $appIdCondition = null;
        if (!empty($appId)) {
            $appIdCondition = ' AND app_id = :app_id ';
            $bindingData['app_id'] = $appId;
        }

        //(country, platform, created_date, app_id)

        $sql = 'SELECT '.$selectDate.', count(distinct ip) AS count '.
            'FROM tracking_download_files '.
            'WHERE '.$countryCondition.$platformCondition.$dateCondition.$appIdCondition.
            'GROUP BY '.$groupBy;

        return \DB::select($sql, $bindingData);
    }

    /**
     * Format data summary
     *
     * Ex: - ref: ['1-9-2016', '2-9-2016', '3-9-2016']
     *     - data: [["day" => "16-09-2016","count" => "1"],["day":"17-09-2016","count" => "3"]]
     *     - unit: day
     * => result: [0,0,0,1,3,0,0,0,0,0,0,0,0,0,0,0,0,0]
     *
     * @param $ref
     * @param $data
     * @param $unit
     *
     * @return array
     */
    public static function formatDataSummary($ref, $data, $unit)
    {
        $combined = array_combine(array_column($data, $unit), array_column($data, 'count'));

        $values = [];
        foreach ($ref as $label) {

            //fix for $unit = 'week' -> ok
            if (2 === strlen($label)) {
                $value = isset($combined[intval($label)]) ? $combined[intval($label)] : 0;
            } else {
                $value = isset($combined[$label]) ? $combined[$label] : 0;
            }
            $values[] = $value;
        }

        return $values;
    }

    public static function getOpenAppCount($startDate, $endDate, $country, $appName, $telcoName, $sentStatusId, $sentStatus, $sentResponse)
    {
        //$country,$appName, $telcoName, $sentStatusId, $sentStatus, $sentResponse

        $selectDate = 'DATE_FORMAT(created_date, "%d-%m-%Y") as day';
        $groupBy = 'created_date';
        $dateCondition = ' (created_date between :startDate AND :endDate) ';

        $startDate = DateTime::toYearFirstStyle($startDate);
        $endDate = DateTime::toYearFirstStyle($endDate);
        $bindingData = [
            'startDate' => $startDate,
            'endDate' => $endDate,
        ];

        $countryCondition = null;
        if (!empty($country)) {
            $countryCondition = ' AND country = :country ';
            $bindingData['country'] = $country;
        }

        $appNameCondition = null;
        if (!empty($appName)) {
            $appNameCondition = ' AND app_name = :appName ';
            $bindingData['appName'] = $appName;
        }

        $telcoNameCondition = null;
        if (!empty($telcoName)) {
            $telcoNameCondition = ' AND telco_name = :telcoName ';
            $bindingData['telcoName'] = $telcoName;
        }

        $sentStatusIdCondition = null;
        if (!empty($sentStatusId)) {
            $sentStatusIdCondition = ' AND sent_sms_status_id = :statusId ';
            $bindingData['statusId'] = $sentStatusId;
        }

        $sentStatusCondition = null;
        if (!empty($sentStatus)) {
            $sentStatusCondition = ' AND sent_sms_status = :status ';
            $bindingData['status'] = $sentStatus;
        }

        $sentResponseCondition = null;
        if (!empty($sentResponse)) {
            $sentResponseCondition = ' AND sent_sms_response = :response ';
            $bindingData['response'] = $sentResponse;
        }


        $sql = 'SELECT '.$selectDate.', count(distinct user_id) AS count '.
            'FROM count_open_apps '.
            'WHERE '.$dateCondition.$countryCondition.$appNameCondition.$telcoNameCondition.$sentStatusIdCondition.$sentStatusCondition.$sentResponseCondition.
            'GROUP BY '.$groupBy;

        // dump($sql);
        // dump($bindingData);

        return \DB::select($sql, $bindingData);

    }

    public static function getOpenAppCountries()
    {
        $today = Carbon::now()->format('Y-m-d');
        $prevWeek = Carbon::now()->subDays(14)->format('Y-m-d');

        return \DB::table('count_open_apps')
            ->select(\DB::raw('distinct country as country'))
            ->whereNotNull('country')
            //->whereBetween('downloaded_date', [$prevWeek, $today])
            ->get()->pluck('country');

    }


    public static function getOpenAppIds()
    {
        $today = Carbon::now()->format('Y-m-d');
        $prevWeek = Carbon::now()->subDays(14)->format('Y-m-d');

        return \DB::table('count_open_apps')
            ->select(\DB::raw('distinct app_id as app_id'))
            ->whereNotNull('country')
            //->whereBetween('downloaded_date', [$prevWeek, $today])
            ->get()->pluck('app_id');

    }

    public static function getOpenAppNames()
    {
        $today = Carbon::now()->format('Y-m-d');
        $prevWeek = Carbon::now()->subDays(14)->format('Y-m-d');

        return \DB::table('count_open_apps')
            ->select(\DB::raw('distinct app_name as app_name'))
            ->whereNotNull('country')
            //->whereBetween('downloaded_date', [$prevWeek, $today])
            ->get()->pluck('app_name');
    }

    public static function getOpenAppTelco()
    {
        $today = Carbon::now()->format('Y-m-d');
        $prevWeek = Carbon::now()->subDays(14)->format('Y-m-d');

        return \DB::table('count_open_apps')
            ->select(\DB::raw('distinct telco_name as telco_name'))
            ->whereNotNull('country')
            ->where('telco_name', '!=', '')
            //->whereBetween('downloaded_date', [$prevWeek, $today])
            ->get()->pluck('telco_name');
    }

    public static function getOpenAppSentStatus()
    {
        return \DB::table('count_open_apps')
            ->select(\DB::raw('distinct sent_sms_status_id as sent_sms_status_id'))
            ->whereNotNull('country')
            ->where('sent_sms_status_id', '!=', '')
            ->get()->pluck('sent_sms_status_id');

    }

    public static function getOpenAppSentStatusString()
    {
        return \DB::table('count_open_apps')
            ->select(\DB::raw('distinct sent_sms_status as sent_sms_status'))
            ->whereNotNull('country')
            ->where('sent_sms_status', '!=', '')
            ->get()->pluck('sent_sms_status');

    }

    public static function getOpenAppSentResponse()
    {
        return \DB::table('count_open_apps')
            ->select(\DB::raw('distinct sent_sms_response as sent_sms_response'))
            ->whereNotNull('country')
            ->where('sent_sms_response', '!=', '')
            ->get()->pluck('sent_sms_response');

    }

    public static function getTelcoNamesMapping()
    {
        //todo: mapping country - telco_name
        //select country, GROUP_CONCAT(distinct telco_name) from count_open_apps group by country;
        $data = \DB::table('count_open_apps')
            ->selectRaw('country, GROUP_CONCAT(distinct telco_name) as telco_name')
            ->groupBy('country')->get()->toArray();

        $dataMapping = [];
        foreach ($data as $datum) {
            $dataMapping[$datum->country] = explode(',', $datum->telco_name);
        }

        return $dataMapping;
    }

    public static function getSentSmsStatusMapping()
    {
        //todo: mapping country - sent_sms_status
        //select country, GROUP_CONCAT(distinct telco_name) from count_open_apps group by country;
        $data = \DB::table('count_open_apps')
            ->selectRaw('country, GROUP_CONCAT(distinct sent_sms_status) as sent_sms_status')
            ->groupBy('country')->get()->toArray();

        $dataMapping = [];
        foreach ($data as $datum) {
            $dataMapping[$datum->country] = explode(',', $datum->sent_sms_status);
        }

        return $dataMapping;
    }

}
