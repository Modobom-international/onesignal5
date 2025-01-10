<?php

namespace App\Jobs;

use App\Helper\LinodeStorageObject;
use App\Helper\Common;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use \DB;

class CheckLinkStatus implements ShouldQueue
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
        if (strtolower($this->linkInfo->type) == 'mediafire') {
            $linkLive = Common::isFileUrlExist($this->linkInfo->link);
        } else {
            $linkLive = LinodeStorageObject::isFileAmazonUrlLive($this->linkInfo->link);
        }

        //dump('=> Checking live status for link ('.strtolower($this->linkInfo->type).'): '.$this->linkInfo->link.'  => Result: '.intval($linkLive));

        if (!$linkLive) {

            if (strtolower($this->linkInfo->type) == 'mediafire') {
                MediafireCheckerNotify::dispatch($this->linkInfo->id, $this->linkInfo->link, $this->linkInfo->name, $this->linkInfo->age)
                    ->onQueue('check_mediafire_links_notify');

            } else {

                $date = Common::getCurrentVNTime("Yxmxd");

                $title = $this->linkInfo->name.' - '.ucfirst($this->linkInfo->platform).' - '.ucfirst($this->linkInfo->country);
                $hashtag = "\n\n#".$date.
                    "\n#".$date."xxx".ucfirst($this->linkInfo->country);
                $hashtag2 = "\n#".$date."xxx".ucfirst($this->linkInfo->country)."xxx".ucfirst($this->linkInfo->platform);

                AutoBuildCheckerNotify::dispatch($this->linkInfo->id, $this->linkInfo->link, $title, $this->linkInfo->age, $hashtag.$hashtag2)->onQueue(LinodeStorageObject::getQueueDefault());
            }

            //update link status to Die
            DB::table('mediafire_links')
                ->where('id', $this->linkInfo->id)
                ->update([
                    'status' => 'die',
                    'is_live' => false,
                    'is_notify' => true,
                ]);

        }
    }
}
