<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use App\Services\SSHService;

class DeleteDomain implements ShouldQueue
{
    use Queueable;

    private $domain;

    /**
     * Create a new job instance.
     */
    public function __construct($domain)
    {
        $this->domain = $domain;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $getDomain = DB::connection('mongodb')->table('domains')->where('domain', $this->domain)->first();

        $data = [
            'domain' => $getDomain->domain,
            'user_ftp' => $getDomain->ftp_user,
            'db_name' => $getDomain->db_name,
            'db_user' => $getDomain->db_user,
            'server' => $getDomain->server,
            'provider' => $getDomain->provider
        ];

        $sshService = new SSHService($data['server']);
        $result = $sshService->runDeleteSiteScript($data);

        if (is_array($result) and array_key_exists('error', $result)) {
            dump('Lỗi xóa domain : ' . json_encode($result));

            return;
        }

        $result = $cloudFlareService->deleteDomain(
            $domain
        );

        if (is_array($result) and array_key_exists('error', $result)) {
            dump('Lỗi xóa domain : ' . json_encode($result));

            return;
        }

        NotificationDeleteDomain::dispatch($data)->onQueue('notification_system');

        dump('Xóa thành công domain');
    }
}
