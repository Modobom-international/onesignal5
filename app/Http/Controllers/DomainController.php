<?php

namespace App\Http\Controllers;

use App\Helper\Common;
use App\Jobs\DeleteDomain;
use App\Jobs\UpDomain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\GoDaddyService;
use Auth;

class DomainController extends Controller
{
    protected $godaddyService;

    public function __construct()
    {
        if(Auth::check()) {
            $this->godaddyService = new GoDaddyService(Auth::user()->email);
        }
    }

    public function listDomain()
    {
        $domains = DB::connection('mongodb')
            ->table('domains')
            ->get();

        $users = DB::connection('mysql')
            ->table('users')
            ->get();

        foreach ($domains as $domain) {
            foreach ($users as $user) {
                if ($domain->provider == $user->id) {
                    $domain->email = $user->email;
                }
            }
        }

        $domains = Common::paginate($domains);

        return view('domain.index', compact('domains'));
    }

    public function createDomain()
    {
        if (Auth::user()->email == 'tranlinh.modobom@gmail.com' or Auth::user()->email == 'vutuan.modobom@gmail.com') {
            return view('domain.create');
        } else {
            abort(403);
        }
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
        $date = Common::covertDateTimeToMongoBSONDateGMT7(Common::getCurrentVNTime());

        UpDomain::dispatch($domain, $server, $provider, $email, $date)->onQueue('up-domain');

        return response()->json([
            'message' => 'Đang xử lý...',
            'status' => 1
        ]);
    }

    public function searchDomain(Request $request)
    {
        $query = $request->input('query');
        $domains = DB::connection('mongodb')->table('domains')->where('domain', 'LIKE', "%{$query}%")
            ->get();

        $users = DB::connection('mysql')
            ->table('users')
            ->get();

        foreach ($domains as $domain) {
            foreach ($users as $user) {
                if ($domain->provider == $user->id) {
                    $domain->email = $user->email;
                }
            }
        }

        $domains = Common::paginate($domains);

        return response()->json([
            'html' => view('includes.table-domain', compact('domains'))->render()
        ]);
    }

    public function getListDomain()
    {
        $result = $this->godaddyService->getDomains();

        return response()->json($result);
    }

    public function deleteDomain(Request $request)
    {
        $domain = $request->get('domain');

        dd($domain);

        DeleteDomain::dispatch($domain)->onQueue('delete-domain');

        return response()->json([
            'message' => 'Successfully'
        ]);
    }
}
