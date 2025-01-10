<?php

namespace App\Jobs;

use App\Helper\Common;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class DeleteKeyCacheRedis implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $id;
    private $cacheKey;
    private $url;
    private $version;

    /**
     * Create a new job instance.
     *
     * @param $id
     * @param $cacheKey
     * @param $url
     * @param $version
     */
    public function __construct($id, $cacheKey, $url, $version)
    {
        $this->id = $id;
        $this->cacheKey = $cacheKey;
        $this->url = $url;
        $this->version = $version;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $result1 = \Cache::store('redis')->forget($this->cacheKey);
        $result2 = \Cache::store('redis_clone_1')->forget($this->cacheKey);

        //delete record in table amazon_files_built_key_caches
        $resultDelete = \DB::table('amazon_files_built_key_caches')->where('key', $this->cacheKey)->delete();
        dump('-> Deleted key: '.$this->cacheKey.' in table amazon_files_built_key_caches, affected rows: '.$resultDelete);

        //update is_active, is_live for link
        $versionBuildTable = ($this->version < 4) ? '' : '_v'.$this->version;
        $tableBuild = 'amazon_files_built'.$versionBuildTable;

        \DB::table($tableBuild)
            ->where('full_url', $this->url)
            ->update([
                'is_active' => 0,
                'is_live' => 0,
            ]);

        $msg = Common::getCurrentVNTime().' -> Deleted key: '.$this->cacheKey.', result 1: '.intval($result1).', result 2: '.intval($result2);
        dump($msg);

        //$file  = storage_path('logs/log_delete_cache_key-'.Common::getCurrentVNTime('Y-m-d').'.txt');
        //file_put_contents($file, $msg."\n", FILE_APPEND);

    }
}
