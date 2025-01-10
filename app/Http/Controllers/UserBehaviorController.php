<?php

namespace App\Http\Controllers;

use App\Enums\DomainAllow;
use Illuminate\Http\Request;
use DB;

class UserBehaviorController extends Controller
{
    public function store(Request $request)
    {
        $origin = $request->header('Origin');
        if (!in_array($origin, DomainAllow::LIST_DOMAIN)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validatedData = $request->validate([
            'eventName' => 'required|string',
            'eventData' => 'required|array',
            'user.userAgent' => 'required|string',
            'user.platform' => 'required|string',
            'user.language' => 'required|string',
            'user.cookiesEnabled' => 'required|boolean',
            'user.screenWidth' => 'required|integer',
            'user.screenHeight' => 'required|integer',
            'user.timezone' => 'required|string',
            'timestamp' => 'required|date_format:Y-m-d\TH:i:s.v\Z',
            'domain' => 'required',
        ]);

        DB::connection('mongodb')->table('users_tracking')->insert([
            'event_name' => $validatedData['eventName'],
            'event_data' => $validatedData['eventData'],
            'user_agent' => $validatedData['user']['userAgent'],
            'platform' => $validatedData['user']['platform'],
            'language' => $validatedData['user']['language'],
            'cookies_enabled' => $validatedData['user']['cookiesEnabled'],
            'screen_width' => $validatedData['user']['screenWidth'],
            'screen_height' => $validatedData['user']['screenHeight'],
            'timezone' => $validatedData['user']['timezone'],
            'timestamp' => $validatedData['timestamp'],
            'domain' => $validatedData['domain'],
        ]);

        return response()->json(['message' => 'User behavior recorded successfully.']);
    }
}
