<?php

namespace App\Console\Commands;

use App\Enums\ListServer;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportDomainFromCSV extends Command
{
    protected $client;
    protected $apiKey;
    protected $apiSecret;
    protected $apiUrl;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-domain-from-csv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import domain from CSV file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $listIP = ListServer::LIST_SERVER;
        $count = 1;

        $listKey = [
            'tuan' => [
                'apiKey' => config('services.godaddy_tuan.api_key'),
                'apiSecret' => config('services.godaddy_tuan.api_secret'),
                'apiUrl' => config('services.godaddy_tuan.api_url')
            ],
            'linh' => [
                'apiKey' => config('services.godaddy_tuan.api_key'),
                'apiSecret' => config('services.godaddy_tuan.api_secret'),
                'apiUrl' => config('services.godaddy_tuan.api_url')
            ]
        ];

        foreach ($listIP as $server) {
            if (($handle = fopen(public_path('import-domain/' . $server . '.csv'), 'r')) !== false) {
                while (($row = fgetcsv($handle)) !== false) {
                    if ($count <= 2) {
                        $count++;
                        continue;
                    }

                    if (empty($row[2]) or empty($row[3]) or empty($row[5]) or empty($row[6]) or empty($row[7])) {
                        $count++;
                        continue;
                    }

                    $this->apiKey = $listKey['tuan']['apiKey'];
                    $this->apiSecret = $listKey['tuan']['apiSecret'];
                    $this->apiUrl = $listKey['tuan']['apiUrl'];
                    $domain = $row[2];
                    $explodePublicHtml = explode(' ', $row[7]);
                    $result = $this->getDetailDomain($domain);

                    dump('---------- Bắt đầu với domain : ' . $domain);

                    if ($result['code'] == 'NOT_FOUND') {
                        $this->apiKey = $listKey['linh']['apiKey'];
                        $this->apiSecret = $listKey['linh']['apiSecret'];
                        $this->apiUrl = $listKey['linh']['apiUrl'];

                        dump('Domain này không phải của Tuấn');
                        dump('Tiếp tục kiểm tra với Linh');

                        $result = $this->getDetailDomain($domain);

                        if ($result['code'] == 'NOT_FOUND') {
                            $count++;

                            dump('Domain này không phải của Linh');
                            dump('Skip domain');
                            continue;
                        } else {
                            $getUser = DB::table('users')->where('email', 'tranlinh.modobom@gmail.com')->first();
                            $provider = $getUser->id;
                        }
                    } else {
                        $getUser = DB::table('users')->where('email', 'vutuan.modobom@gmail.com')->first();
                        $provider = $getUser->id;
                    }

                    $data = [
                        'domain' => $domain,
                        'admin_username' => 'admin',
                        'admin_password' => $row[3],
                        'db_name' => $row[6],
                        'db_user' => $result['db_user'],
                        'db_password' => $result['db_password'],
                        'public_html' => trim($explodePublicHtml[1]),
                        'ftp_user' => $row[5],
                        'server' => $server,
                        'status' => 0,
                        'provider' => $provider,
                        'created_at' => Common::covertDateTimeToMongoBSONDateGMT7(Common::getCurrentVNTime())
                    ];

                    DB::connection('mongodb')
                        ->table('domains')
                        ->insert($data);

                    dump('Domain import thành công');

                    $count++;
                }

                fclose($handle);
            }
        }
    }

    public function getDetailDomain($domain)
    {
        $this->client = new Client([
            'base_uri' => $this->apiUrl,
            'headers' => [
                'Authorization' => 'sso-key ' . $this->apiKey . ':' . $this->apiSecret,
                'Accept' => 'application/json',
            ],
        ]);

        try {
            $response = $this->client->get("/v1/domains/{$domain}");

            return json_decode($response->getBody(), true);
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

    public function handleException(Exception $e)
    {
        if ($e->hasResponse()) {
            $response = json_decode($e->getResponse()->getBody()->getContents(), true);
            if (isset($response['code']) && $response['code'] === 'NOT_FOUND') {
                return ['code' => 'NOT_FOUND', 'message' => "Domain không tồn tại hoặc không thuộc quyền sở hữu."];
            }
            return $response;
        }

        return ['error' => 'Something went wrong'];
    }
}
