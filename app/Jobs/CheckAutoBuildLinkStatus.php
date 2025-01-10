<?php

namespace App\Jobs;

use App\Helper\LinodeStorageObject;
use App\Helper\Common;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CheckAutoBuildLinkStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $linkInfo;

    /**
     * Create a new job instance.
     *
     * @param $linkInfo
     */
    public function __construct($linkInfo)
    {
        $this->linkInfo = $linkInfo;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $linkLive = LinodeStorageObject::isFileAmazonUrlLive($this->linkInfo->link);
        //dump('=> Checking live status for link: '.$this->linkInfo->link.'  => Result: ' . intval($linkLive));

        if (!$linkLive) {
            //todo: add CheckerNotify
            //dump('=> Link '.$this->linkInfo->link.' die!!!');

            $date = Common::getCurrentVNTime("Yxmxd");

            $title = $this->linkInfo->title.' - '.ucfirst($this->linkInfo->platform).' - '. ucfirst($this->linkInfo->country);
            $hashtag = "\n\n#".$date.
                "\n#".$date."xxx".ucfirst($this->linkInfo->country);
            $hashtag2 = "\n#".$date."xxx".ucfirst($this->linkInfo->country)."xxx".ucfirst($this->linkInfo->platform);

            AutoBuildCheckerNotify::dispatch($this->linkInfo->id, $this->linkInfo->link, $title, $this->linkInfo->age, $hashtag.$hashtag2)->onQueue(LinodeStorageObject::getQueueDefault());

            //update link status to Die
            \DB::table('autobuild_links')
                ->where('id', $this->linkInfo->id)
                ->update([
                    'is_live' => false,
                    'is_notify' => true,
                ]);

        }


    }
}
