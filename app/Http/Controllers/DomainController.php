<?php

namespace App\Http\Controllers;

use App\Jobs\UpDomain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\GoDaddyService;
use Auth;

class DomainController extends Controller
{
    protected $godaddyService;

    public function __construct(GoDaddyService $godaddyService)
    {
        $this->godaddyService = $godaddyService;
    }

    public function listDomain()
    {
        $domains = DB::connection('mongodb')
            ->table('domain')
            ->get();

        return view('domain.index', compact('domains'));
    }

    public function createDomain()
    {
        return view('domain.create');
    }

    public function checkDomain(Request $request)
    {
        $domain = $request->get('domain');
        $details = $this->godaddyService->getDomainDetails($domain);
        $response = [
            'message' => 'Domain có thể up!',
            'status' => 1,
            'data' => $details
        ];

        if (array_key_exists('error', $details)) {
            $response['message'] = 'Lỗi hệ thống!';
            $response['status'] = 0;
        }

        if (array_key_exists('code', $details)) {
            if ($details['code'] == 'NOT_FOUND') {
                $response['message'] = 'Domain không thuộc quản lý của tài khoản trên Godaddy';
                $response['status'] = 0;
            } else {
                $response['message'] = 'Lỗi khác!';
                $response['status'] = 0;
            }
        } else {
            if (array_key_exists('nameServers', $details)) {
                foreach ($details['nameServers'] as $nameServers) {
                    if ($nameServers == 'ben.ns.cloudflare.com' or $nameServers == 'jean.ns.cloudflare.com') {
                        $response['message'] = 'Domain đã được up!';
                        $response['status'] = 0;
                    }
                }
            }
        }

        return response()->json($response);
    }

    public function upDomain(Request $request)
    {
        $domain = $request->get('domain');
        $server = $request->get('server');
        $provider = Auth::user()->id;
        $email = Auth::user()->email;

        dd($email);

        UpDomain::dispatch($domain, $server, $provider, $email);

        return response()->json([
            'message' => 'Đang xử lý...',
            'status' => 1
        ]);
    }

    public function getListDomain()
    {
        $result = $this->godaddyService->getDomains();

        return response()->json($result);
    }
}
