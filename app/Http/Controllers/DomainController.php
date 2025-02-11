<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\GoDaddyService;

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

        return response()->json($details);
    }

    public function updateNameservers(Request $request)
    {
        $request->validate([
            'domain'      => 'required|string',
        ]);

        $data = [
            'domain'      => $request->domain,
            'nameservers' => [
                'ben.ns.cloudflare.com',
                'jean.ns.cloudflare.com',
            ],
        ];

        $result = $this->godaddyService->updateNameservers(
            $data['domain'],
            $data['nameservers']
        );

        return response()->json($result);
    }

    public function getListDomain()
    {
        $result = $this->godaddyService->getDomains();

        return response()->json($result);
    }
}
