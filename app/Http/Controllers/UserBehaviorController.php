<?php

namespace App\Http\Controllers;

use App\Enums\DomainAllow;
use App\Jobs\StoreUsersTracking;
use Illuminate\Http\Request;
use App\Helper\Common;

class UserBehaviorController extends Controller
{
    public function store(Request $request)
    {
        $origin = $request->header('Origin');
        $ip = request()->ip();
        if (!in_array($origin, DomainAllow::LIST_DOMAIN)) {
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
        StoreUsersTracking::dispatch($validatedData)->onQueue('store_users_tracking');

        return response()->json(['message' => 'User behavior recorded successfully.']);
    }
}
