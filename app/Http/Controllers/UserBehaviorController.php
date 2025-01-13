<?php

namespace App\Http\Controllers;

use App\Enums\DomainAllow;
use App\Jobs\StoreUsersTracking;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
            'user.ip' => 'required',
            'timestamp' => 'required|date_format:Y-m-d\TH:i:s.v\Z',
            'domain' => 'required',
            'uuid' => 'required',
        ]);

        StoreUsersTracking::dispatch($validatedData)->onQueue('store_users_tracking');

        return response()->json(['message' => 'User behavior recorded successfully.']);
    }
}
