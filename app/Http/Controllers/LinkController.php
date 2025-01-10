<?php

namespace App\Http\Controllers;

use App\Helper\Common;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LinkController extends Controller
{
    public function saveLink(Request $request)
    {
        $params = $request->all();
        $dataInsert = [];
        $dataInsert[] = [
            'link' => $params['link'] ?? null,
            'author' => $params['author'] ?? null,
            'created_at' => Common::getCurrentVNTime(),
            'updated_at' => Common::getCurrentVNTime(),
        ];

        $resultInset = false;

        if (!empty($dataInsert)) {
            $resultInset = DB::table('links')->insert($dataInsert);
        }

        return response()->json([
            'success' => $resultInset,
            'message' => "Data insert success",
            'params' => $params,
        ]);
    }

    public function listLinks()
    {
        $listLinks = DB::table('links')
            ->whereNotNull('link')
            ->select('link', DB::raw('group_concat(author) as author'), DB::raw('count(*) as count'))
            ->groupBy('link')->orderBy('count', 'desc')
            ->paginate(env('PAGINATION_PER_PAGE', 20));

        return view('link.list-links', ['listLinks' => $listLinks]);
    }
}
