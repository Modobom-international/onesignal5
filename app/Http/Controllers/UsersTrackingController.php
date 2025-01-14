<?php

namespace App\Http\Controllers;

use App\Enums\UsersTracking;
use App\Jobs\StoreUsersTracking;
use Illuminate\Http\Request;
use App\Helper\Common;
use UAParser\Parser;
use DB;

class UsersTrackingController extends Controller
{
    public function store(Request $request)
    {
        $origin = $request->header('Origin');
        $ip = request()->ip();
        if (!in_array($origin, UsersTracking::LIST_DOMAIN)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validatedData = $request->validate([
            'eventName' => 'required|string',
            'eventData' => 'required',
            'user.userAgent' => 'required|string',
            'user.platform' => 'required|string',
            'user.language' => 'required|string',
            'user.cookiesEnabled' => 'required|boolean',
            'user.screenWidth' => 'required|integer',
            'user.screenHeight' => 'required|integer',
            'user.timezone' => 'required|string',
            'timestamp' => 'required',
            'domain' => 'required',
            'uuid' => 'required',
            'path' => 'required',
        ]);

        $validatedData['user']['ip'] = $ip;
        $validatedData['timestamp'] = Common::covertDateTimeToMongoBSONDateGMT7($validatedData['timestamp']);
        StoreUsersTracking::dispatch($validatedData)->onQueue('create_users_tracking');

        return response()->json(['message' => 'User behavior recorded successfully.']);
    }

    public function viewUsersTracking(Request $request)
    {
        $domain = $request->get('domain');
        $date = $request->get('date');

        if (!isset($domain)) {
            $domain = UsersTracking::DEFAULT_DOMAIN;
        }

        if (!isset($date)) {
            $date = Common::getCurrentVNTime('Y-m-d');
        }

        $query = DB::connection('mongodb')
            ->table('users_tracking')
            ->where('domain', $domain)
            ->where('timestamp', '>=', Common::covertDateTimeToMongoBSONDateGMT7($date . ' 00:00:00'))
            ->where('timestamp', '<=', Common::covertDateTimeToMongoBSONDateGMT7($date . ' 23:59:59'))
            ->orderBy('timestamp', 'desc')
            ->get();

        $data = Common::paginate($query->groupBy('uuid'));


        return view('users_tracking.index', compact('data'));
    }

    public function getDetailTracking(Request $request)
    {
        $uuid = $request->get('uuid');
        $getTracking = DB::connection('mongodb')
            ->table('users_tracking')
            ->where('uuid', $uuid)
            ->orderBy('timestamp', 'asc')
            ->get();

        $userAgent = $getTracking[0]->user_agent;
        $parser = Parser::create();
        $result = $parser->parse($userAgent);

        $data = [
            'browser' => $result->ua->family,
            'os' => $result->os->family,
            'device' => $result->device->family
        ];

        foreach ($getTracking as $tracking) {
            $event_data = [];
            $data['heat_map'] = [];
            $data['is_internal_link'] = false;
            $data['is_lasso_button'] = false;
            $data['ip'] = $tracking->ip;

            if ($tracking->event_name == 'scroll') {
                $event_data[] = 'Cuộn khoảng ' . $tracking->event_data['scrollTop'] . 'px';
            }

            if ($tracking->event_name == 'beforeunload') {
                $event_data[] = 'Thời gian vào page : ' . date('Y-m-d H:i:s', $tracking->event_data['start'] / 1000);
                $event_data[] = 'Thời gian ra khỏi page : ' . date('Y-m-d H:i:s', $tracking->event_data['end'] / 1000);
                $event_data[] = 'Thời gian onpage : ' . date('H:i:s', $tracking->event_data['totalOnSite'] / 1000);

                $data['heat_map'][$tracking->path] = $tracking->event_data['heatmapData'];
            }

            if ($tracking->event_name == 'click') {
                $event_data[] = 'Click vào ' . $tracking->event_data['target'];
            }

            if ($tracking->event_name == 'internal_link_click') {
                $event_data[] = 'Click vào ' . $tracking->event_data['target'];
                $data['is_internal_link'] = true;
            }

            if ($tracking->event_name == 'lasso_button_click') {
                $event_data[] = 'Click vào ' . $tracking->event_data['target'];
                $data['is_lasso_button'] = true;
            }

            if ($tracking->event_name == 'keydown') {
                $event_data[] = 'Ấn nút ' . $tracking->event_data['target'] . ' với giá trị ' . $tracking->event_data['value'];
                $data['is_lasso_button'] = true;
            }

            if ($tracking->event_name == 'input') {
                $event_data[] = 'Nhập ' . $tracking->event_data['target'] . ' với giá trị ' . $tracking->event_data['value'];
                $data['is_lasso_button'] = true;
            }

            if ($tracking->event_name == 'mousemove') {
                $event_data[] = 'Di chuột đến vị trí x là ' . $tracking->event_data['x'] . ' và y là ' . $tracking->event_data['y'];
                $data['is_lasso_button'] = true;
            }

            $data['activity'][$tracking->path] = $event_data;
        }

        return response()->json($data);
    }
}
