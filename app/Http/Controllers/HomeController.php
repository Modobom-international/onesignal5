<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function welcome()
    {
        return view('welcome');
    }

    public function apkLoadWeb()
    {
        $cacheKeyLoadWeb = 'cache_apk_load_web';
        $data = \Cache::store('redis')->remember($cacheKeyLoadWeb, 60 * 5, function () {
            return DB::table('apk_load_web')->first();
        });

        $mainUrlResult = $backUrlResult = $apkafeUrlResult = config('app.url_load_web_default');
        if (!empty($data->back_url)) {
            $dataBackUrl = json_decode($data->back_url);
            if (!empty($dataBackUrl)) {
                $rand = rand(0, count($dataBackUrl) - 1);
                $backUrlResult = $dataBackUrl[$rand];
            }
        }

        if (!empty($data->main_url)) {
            $dataMainUrl = json_decode($data->main_url);
            if (!empty($dataMainUrl)) {
                $rand = rand(0, count($dataMainUrl) - 1);
                $mainUrlResult = $dataMainUrl[$rand];
            }
        }

        $linkPostResult = '';

        if (!empty($data->apkafe_url)) {
            $dataApkafeUrl = json_decode($data->apkafe_url);
            if (!empty($dataApkafeUrl)) {
                if ($data->random_apkafe == 1) {
                    $rand = rand(0, count($dataApkafeUrl) - 1);
                    $apkafeUrlResult = $dataApkafeUrl[$rand];
                } else {
                    $apkafeUrlResult = $dataApkafeUrl[0];
                }
            }
        }

        $result = [
            'main_url' => $mainUrlResult,
            'back_url' => $backUrlResult,
            'link_post' => $linkPostResult,
            'status' => $data->status == 1 ? true : false,
            'hidesearch' => $data->hide_search == 1 ? true : false,
            'hide_url' => $data->hide_url,
            'organic_vni' => $data->organic_vni,
            'organic_apkafe' => $data->organic_apkafe,
            'random_apkafe' => $data->random_apkafe == 1 ? true : false,
            'apkafe_url' => $apkafeUrlResult,
            'push_url' => $data->push_url,
            'max_post' => $data->max_post,
            'time_on' => (int) $data->time_on,
            'status_time_on' => $data->status_time_on == 1 ? true : false,
        ];

        return \response()->json($result);
    }

    public function apkLoadWebCount()
    {
        $cacheKeyLoadWeb = 'cache_apk_load_web';
        $data = \Cache::store('redis')->remember($cacheKeyLoadWeb, 60 * 5, function () {
            return DB::table('apk_load_web')->first();
        });

        if (!empty($data)) {
            $listCheckPost = [];
            $runAlgorithm = false;
            $dateNow = date('Y-m-d');
            $checkCount = DB::table('count_max_post')->whereIn('key_word', json_decode($data->link_post))->whereDate('date', $dateNow)->whereNull('game')->get();

            if (count($checkCount) == 0) {
                $runAlgorithm = true;
            }

            if (count($checkCount) != count(json_decode($data->link_post))) {
                $runAlgorithm = true;
            }

            foreach ($checkCount as $check) {
                if ($check->count < $data->max_post) {
                    $runAlgorithm = true;
                }
            }

            if ($runAlgorithm) {
                $linkPostResult = $this->randomLinkPostCount($data, $listCheckPost);
                if ($linkPostResult == null) {
                    $linkPostResult = '';
                }
            } else {
                $linkPostResult = '';
            }

            $result = [
                'link_post' => $linkPostResult,
                'max_post' => $data->max_post
            ];
        } else {
            $result = [
                'link_post' => '',
                'max_post' => ''
            ];
        }

        return \response()->json($result);
    }

    public function randomLinkPostCount($data, $listCheckPost)
    {
        $dataLinkPost = json_decode($data->link_post);

        if (!empty($dataLinkPost)) {
            $rand = rand(0, count($dataLinkPost) - 1);
            $linkPostResult = $dataLinkPost[$rand];
        }

        if (count($listCheckPost) == count($dataLinkPost)) {
            $linkPostResult = '';
            return $linkPostResult;
        }

        $dt = Carbon::now();
        $dateNow = $dt->toDateString();
        $keyword = DB::table('count_max_post')->where('key_word', $linkPostResult)->whereDate('date', $dateNow)->whereNull('game')->first();

        if ($keyword == null) {
            $dataCount = [
                'key_word' => $linkPostResult,
                'date' => $dateNow,
                'count' => 1
            ];
            DB::table('count_max_post')->insert($dataCount);

            return $linkPostResult;
        } else {
            $maxPost = $data->max_post;
            if ($keyword->count >= $maxPost) {
                if (in_array($linkPostResult, $listCheckPost)) {
                    return $this->randomLinkPostCount($data, $listCheckPost);
                } else {
                    $listCheckPost[] = $keyword->key_word;
                    return $this->randomLinkPostCount($data, $listCheckPost);
                }
            } else {
                $countPlus = (int) $keyword->count + 1;
                DB::table('count_max_post')->where('key_word', $linkPostResult)->whereDate('date', $dateNow)->whereNull('game')->update(['count' => $countPlus]);

                return $linkPostResult;
            }
        }
    }

    public function apkLoadWebCountDiff(Request $request)
    {
        if (empty($request->get('game'))) {
            $result = [
                'link_post' => '',
                'max_post' => '',
                'link_return' => '',
                'message' => 'Parameter game is required',
            ];

            return \response()->json($result);
        }

        $game = $request->get('game');
        $dateNow = date('Y-m-d');
        $data = DB::table('load_web_counts')->where('game', $game)->first();
        if (empty($data)) {
            $result = [
                'link_post' => '',
                'max_post' => '',
                'link_return' => '',
                'message' => 'Game Not Found'
            ];

            return \response()->json($result);
        }

        $key = 'cache_' . $game . '_' . $dateNow;
        $getCount = \Cache::store('redis')->get($key);
        if (empty($getCount)) {
            $dataLinkPost = explode("\r\n", $data->link_post);

            if (!empty($dataLinkPost)) {
                $rand = rand(0, count($dataLinkPost) - 1);
                $linkPostResult = $dataLinkPost[$rand];
            }

            $result = [
                'link_post' => $linkPostResult,
                'max_post' => $data->max_post,
                'link_return' => $data->link_return,
                'message' => '200'
            ];

            $dataStoreCache = [];
            foreach ($dataLinkPost as $value) {
                if ($value == $linkPostResult) {
                    $dataStoreCache[$value] = 1;
                } else {
                    $dataStoreCache[$value] = 0;
                }
            }

            \Cache::store('redis')->set($key, $dataStoreCache);
        } else {
            $dataRandom = [];
            foreach ($getCount as $key_word => $count) {
                if ($count < $data->max_post) {
                    $dataRandom[] = $key_word;
                }
            }

            if (empty($dataRandom)) {
                $result = [
                    'link_post' => '',
                    'max_post' => $data->max_post,
                    'link_return' => $data->link_return,
                    'message' => 'Fully count!',
                ];
            } else {
                $rand = rand(0, count($dataRandom) - 1);
                $linkPostResult = $dataRandom[$rand];

                $result = [
                    'link_post' => $linkPostResult,
                    'max_post' => $data->max_post,
                    'link_return' => $data->link_return,
                    'message' => '200'
                ];

                foreach ($getCount as $key_word => $count) {
                    if ($linkPostResult == $key_word) {
                        $getCount[$key_word] = ($count + 1);
                    }
                }

                \Cache::store('redis')->set($key, $getCount);
            }
        }

        return \response()->json($result);
    }
}
