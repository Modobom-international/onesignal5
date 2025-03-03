<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\DB;

class CrawlGameNews implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $client = new Client();
        
        try {
            foreach ($this->listDomain as $domain) {
                $response = $client->get($domain);
                $html = $response->getBody()->getContents();

                $crawler = new Crawler($html);

                $newsItems = $crawler->filter('.article-item, .post, .news-item');
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

                DB::connection('mongodb')->table('game_news')->insert([
                    'title' => trim($title),
                    'url' => $url,
                    'summary' => trim($summary),
                    'published_at' => $publishedAt,
                ]);
            }
        } catch (\Exception $e) {
            \Log::error("Error crawling {$url}: " . $e->getMessage());
        }
    }
}
