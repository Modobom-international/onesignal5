<?php

namespace App\Http\Controllers;

use App\Helper\Common;
use App\Helper\PushSystemGlobal;
use App\Http\Requests\LinkSystemGlobalRequest;
use App\Jobs\SaveRequestGetSystemGlobalSetting;
use App\Jobs\SaveSystemGlobal;
use App\Jobs\SaveUserActivePushSystemGlobal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PushSystemGlobalController extends Controller
{

    public function getSettingsGlobal(Request $request)
    {
        $shareWeb = PushSystemGlobal::getShareWebConfig();
        $linkWeb = PushSystemGlobal::pickLink($shareWeb);

        $arr = [
            'pushweb' => [
                'status' => 'on',
                'type' => 'search',
                'shareweb' => $shareWeb,
                'linkweb' => $linkWeb,
            ],

        ];

        $logData = [
            'ip' => $request->getClientIp(),
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? null,
            'created_at' => Common::getCurrentVNTime(),
            'created_date' => Common::getCurrentVNTime('Y-m-d'),
            'share_web' => $shareWeb,
            'link_web' => $linkWeb,
            'data' => $arr,
        ];

        SaveRequestGetSystemGlobalSetting::dispatch($logData)->onQueue('save_request_get_system_global_setting');

        return response()->json($arr);
    }

    public function saveSystemGlobal(Request $request)
    {
        $params = $request->all();
        $success = false;

        if (!empty($params)) {
            $success = true;
            SaveSystemGlobal::dispatch($params)->onQueue('save_push_system_global');
        }

        return response()->json([
            'success' => $success,
        ]);
    }

    public function listPushSystemGlobal()
    {
        $getDataCountries = \DB::table('push_system_globals')->select('country', DB::raw('count(*) as count'))
            ->groupBy('country')
            ->get();

        $countUser = DB::table('push_system_globals')->get()->count();

        $usersActiveRaw = DB::table('push_system_global_user_active')
            ->where('activated_date', Common::getCurrentVNTime('Y-m-d'))
            ->select(DB::raw('country, count(distinct token) as count'))
            ->get();

        $totalActive = 0;
        $usersActiveCountry = [];
        foreach ($usersActiveRaw as $item) {
            $count = $item->count;
            $usersActiveCountry[$item->country] = $count;
            $totalActive += $count;
        }

        return view('push_system_global.list', compact('getDataCountries', 'countUser', 'totalActive', 'usersActiveCountry'));
    }

    public function listUserActiveGlobalAjax()
    {
        $usersActiveRaw = DB::table('push_system_global_user_active')
            ->where('activated_date', Common::getCurrentVNTime('Y-m-d'))
            ->select(DB::raw('country, count(distinct token) as count'))
            ->groupBy('country')
            ->get();

        $totalActive = 0;
        $usersActiveCountry = [];
        foreach ($usersActiveRaw as $item) {
            $count = $item->count;
            $usersActiveCountry[$item->country] = $count;
            $totalActive += $count;
        }

        return response()->json([
            'total' => $totalActive,
            'usersActiveCountry' => $usersActiveCountry,
        ]);
    }

    public function addLinkSystemGlobal()
    {
        $status = [
            'on' => 'on',
            'off' => 'off',
        ];
        $dataSystem = DB::table('push_systems_global_config_new')->first();
        $strLink1 = null;
        $strLink2 = null;

        if (!empty($dataSystem)) {
            $linkWeb1 = json_decode($dataSystem->link_web_1);
            $linkWeb2 = json_decode($dataSystem->link_web_2);

            $strLink1 = implode("\n", $linkWeb1);
            $strLink2 = implode("\n", $linkWeb2);
        }

        return view('push_system_global.create-push-system', compact('dataSystem', 'strLink1', 'strLink2', 'status'));
    }

    public function saveSystemConfigGlobal(LinkSystemGlobalRequest $request)
    {
        $params = $request->all();
        $itemArrayLink1 = preg_split('/[\r\n]+/', $params['link_web_1'], -1, PREG_SPLIT_NO_EMPTY);
        $itemArrayLink2 = preg_split('/[\r\n]+/', $params['link_web_2'], -1, PREG_SPLIT_NO_EMPTY);
        $dataSystem = DB::table('push_systems_global_config_new')->first();
        $dataPush =
            [
                'status' => $params['status'],
                'type' => $params['type'],
                'share' => $params['share'],
                'link_web_1' => json_encode($itemArrayLink1),
                'link_web_2' => json_encode($itemArrayLink2),
            ];

        if (!is_null($dataSystem)) {
            $dataPush['updated_at'] = Common::getCurrentVNTime();
            DB::table('push_systems_global_config_new')->update($dataPush);
        } else {
            $dataPush['created_at'] = Common::getCurrentVNTime();
            $dataPush['updated_at'] = Common::getCurrentVNTime();
            DB::table('push_systems_global_config_new')->insert($dataPush);
        }

        return redirect()->route('showConfigGlobal');
    }

    public function showConfigGlobal()
    {
        $dataConfig = DB::table('push_systems_global_config_new')->first();
        $linkWeb1 = json_decode($dataConfig->link_web_1);
        $linkWeb2 = json_decode($dataConfig->link_web_2);
        $strLink1 = implode("\n", $linkWeb1);
        $strLink2 = implode("\n", $linkWeb2);

        return view('push_system_global.show-config', compact('dataConfig', 'strLink1', 'strLink2'));
    }

    public function addUserActiveGlobal(Request $request)
    {
        $params = $request->all();
        $params = array_change_key_case($params, CASE_LOWER);
        $success = false;
        if (!empty($params['token']) && !empty($params['country'])) {
            $success = true;
            SaveUserActivePushSystemGlobal::dispatch($params['token'], $params['country'])->onQueue('save_user_active_push_system_global');
        }

        return response()->json([
            'success' => $success,
        ]);
    }
}
