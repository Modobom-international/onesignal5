<?php

namespace App\Console\Commands\TestCommand;

use App\Enums\Domains;
use Illuminate\Console\Command;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\DB;

class TestOther extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    protected $signature = 'test:other';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test other command';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $client = new Client();
        $listUrl = Domains::LIST_URL_CRAWL_GAME_NEWS;

        try {
            foreach ($listUrl as $url) {
                $response = $client->get($url, [
                    'headers' => [
                        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36',
                        'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8',
                    ],
                ]);
                $html = $response->getBody()->getContents();
                $crawler = new Crawler($html);

                // $newsItems = $crawler->filter('.article-item, .post, .news-item');
                // foreach ($newsItems as $item) {
                //     $itemCrawler = new Crawler($item);

                //     $title = $itemCrawler->filter('h2, .title, .post-title')->text('');
                //     if (empty($title)) continue;

                //     $url = $itemCrawler->filter('a')->attr('href') ?? '';
                //     if (empty($url)) continue;
                //     $url = 'https://gamerant.com' . $url;

                //     $summary = $itemCrawler->filter('.excerpt, .summary, .description')->text('') ?? '';

                //     $publishedAt = $itemCrawler->filter('time')->attr('datetime');
                // }


                dd($crawler);

                // DB::connection('mongodb')->table('game_news')->insert([
                //     'title' => trim($title),
                //     'url' => $url,
                //     'summary' => trim($summary),
                //     'published_at' => $publishedAt,
                // ]);
            }
        } catch (\Exception $e) {
            \Log::error("Error crawling {$url}: " . $e->getMessage());
        }
    }
}
