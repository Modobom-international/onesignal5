<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class StoreUrlLoadWebMix extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'load-web:store-url-mix';
    private $postVniFoodUrl = 'https://vnifood.com/post-sitemap.xml';
    private $recipeVniFoodUrl = 'https://vnifood.com/recipe-sitemap.xml';
    private $courseVniFoodUrl = 'https://vnifood.com/course-sitemap.xml';
    private $cuisineVniFoodUrl = 'https://vnifood.com/cuisine-sitemap.xml';
    private $postBetonamuryoriUrl = 'https://betonamuryori.com/post-sitemap.xml';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Store url load web mix';

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
        $listDomainMix = ['vnifood', 'betonamuryori', 'vnitourist'];
        \DB::table('url_load_web')->whereIn('domain', $listDomainMix)->delete();
        dump('-------------- Deleted all url load web --------------');
        $arrLink['postVniFood'] = $this->getUrlApkafe($this->postVniFoodUrl);
        $arrLink['recipeVniFood'] = $this->getUrlApkafe($this->recipeVniFoodUrl);
        $arrLink['courseVniFood'] = $this->getUrlApkafe($this->courseVniFoodUrl);
        $arrLink['cuisineVniFood'] = $this->getUrlApkafe($this->cuisineVniFoodUrl);
        $arrLink['postBetonamuryori'] = $this->getUrlApkafe($this->postBetonamuryoriUrl);
        $arrData = array_merge(
            $arrLink['postVniFood'],
            $arrLink['recipeVniFood'],
            $arrLink['courseVniFood'],
            $arrLink['cuisineVniFood'],
            $arrLink['postBetonamuryori']
        );

        foreach ($arrData as $record) {
            $parse = parse_url($record);
            $host = $parse['host'];
            $explode = explode('.', $host);
            $domain = $explode[0];
            $data[] = [
                'url' => $record,
                'status' => 1,
                'domain' => $domain
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
        $content = preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $content);

        $xml = simplexml_load_string($content);
        $decode = json_decode(json_encode($xml), true);
        $arrLink = array();

        foreach ($decode['url'] as $key => $value) {
            if ($url == 'https://vnifood.com/cuisine-sitemap.xml') {
                if ($key == 'loc') {
                    $arrLink[] = urldecode($value);
                }
            } else {
                $arrLink[] = urldecode($value['loc']);
            }
        }

        return $arrLink;
    }
}
