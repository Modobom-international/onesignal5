<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class StoreUrlLoadWebApkafe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'load-web:store-url-apkafe';
    private $productApkafeUrl = 'https://apkafe.com/product-sitemap.xml';
    private $postApkafeUrl = 'https://apkafe.com/post-sitemap.xml';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Store url load web apkafe';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        \DB::table('url_load_web')->where('domain', 'apkafe')->delete();
        dump('-------------- Deleted all url load web --------------');
        $arrLink['product'] = $this->getUrlApkafe($this->productApkafeUrl);
        $arrLink['post'] = $this->getUrlApkafe($this->postApkafeUrl);
        $arrData = array_merge($arrLink['product'], $arrLink['post']);

        foreach ($arrData as $key => $record) {
            $data[] = [
                'url' => $record,
                'status' => 1,
                'domain' => 'apkafe'
            ];
        }

        \DB::table('url_load_web')->insert($data);
        dump('-------------- Stored all url load web --------------');
    }

    public function getUrlApkafe($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        $content = curl_exec($ch);
        curl_close($ch);

        $xml = simplexml_load_string($content);
        $decode = json_decode(json_encode($xml), true);
        $arrLink = array();

        foreach ($decode['url'] as $key => $value) {
            $arrLink[] = urldecode($value['loc']);
        }

        return $arrLink;
    }
}
