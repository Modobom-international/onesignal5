<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DomainController extends Controller
{
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
}
