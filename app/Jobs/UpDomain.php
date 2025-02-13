<?php

namespace App\Jobs;

use App\Events\UpDomainDump;
use App\Services\CloudFlareService;
use App\Services\SSHService;
use App\Services\GoDaddyService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use DB;

class UpDomain implements ShouldQueue
{
    use Queueable;

    protected $domain;
    protected $server;
    protected $provider;
    protected $email;

    /**
     * Create a new job instance.
     */
    public function __construct($domain, $server, $provider, $email)
    {
        $this->domain = $domain;
        $this->server = $server;
        $this->provider = $provider;
        $this->email = $email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $result = [];
        $data = [
            'domain'      => $this->domain,
            'server'      => config($this->server),
        ];

        $goDaddyService = new GoDaddyService($this->email);
        $cloudFlareService = new CloudFlareService();
        $sshService = new SSHService($data['server']);

        broadcast(new UpDomainDump(
            [
                'message' => ' 🔄 Bắt đầu tiến hành thêm domain vào Cloudflare....',
                'id'  => 'process-1'
            ],
        ));

        $result = $cloudFlareService->addDomainToCloudflare(
            $data['domain']
        );

        if (array_key_exists('error', $result)) {
            broadcast(new UpDomainDump(
                [
                    'message' => ' ❌ Lỗi không thêm được domain.... <br> ⚡ Kết thúc quá trình up domain...',
                    'id'  => 'process-1'
                ],
            ));

            return;
        } else {
            broadcast(new UpDomainDump(
                [
                    'message' => ' ✅ Hoàn tất thêm domain vào Cloudflare!',
                    'id'  => 'process-1'
                ],
            ));
        }

        broadcast(new UpDomainDump(
            [
                'message' => ' 🔄 Bắt đầu tiến hành đổi nameserver trên Godaddy....',
                'id'  => 'process-2'
            ],
        ));

        $result = $goDaddyService->updateNameservers(
            $data['domain']
        );

        if (is_array($result) and array_key_exists('error', $result)) {
            broadcast(new UpDomainDump(
                [
                    'message' => ' ❌ Lỗi không thay đổi được nameserver.... <br> ⚡ Kết thúc quá trình up domain...',
                    'id'  => 'process-2'
                ],
            ));

            return;
        } else {
            broadcast(new UpDomainDump(
                [
                    'message' => ' ✅ Hoàn tất thay đổi nameserver trên Godaddy!',
                    'id'  => 'process-2'
                ],
            ));
        }

        broadcast(new UpDomainDump(
            [
                'message' => ' 🔄 Bắt đầu tiến hành thêm DNS trên Cloudflare....',
                'id'  => 'process-3'
            ],
        ));

        $result = $cloudFlareService->updateDnsARecord(
            $data['domain'],
            $data['server']
        );

        if (array_key_exists('error', $result)) {
            broadcast(new UpDomainDump(
                [
                    'message' => ' ❌ Lỗi không thêm được DNS.... <br> ⚡ Kết thúc quá trình up domain...',
                    'id'  => 'process-3'
                ],
            ));

            return;
        } else {
            broadcast(new UpDomainDump(
                [
                    'message' => ' ✅ Hoàn tất thêm DNS trên Cloudflare!',
                    'id'  => 'process-3'
                ],
            ));
        }

        broadcast(new UpDomainDump(
            [
                'message' => ' 🔄 Bắt đầu tiến hành khởi tạo website....',
                'id'  => 'process-4'
            ],
        ));

        $result = $sshService->runScript(
            $data['domain']
        );

        if (is_array($result) and array_key_exists('error', $result)) {
            broadcast(new UpDomainDump(
                [
                    'message' => ' ❌ Lỗi không khởi tạo được website.... <br> ⚡ Kết thúc quá trình up domain...',
                    'id'  => 'process-4'
                ],
            ));

            return;
        } else {
            broadcast(new UpDomainDump(
                [
                    'message' => ' ✅ Hoàn tất khởi tạo website!',
                    'id'  => 'process-4'
                ],
            ));
        }

        broadcast(new UpDomainDump(
            [
                'message' => ' 🔄 Bắt đầu tiến hành lưu trữ dữ liệu domain....',
                'id'  => 'process-5'
            ],
        ));

        $result = $sshService->getOutputResult(
            $data['domain']
        );

        if (is_array($result) and array_key_exists('error', $result)) {
            broadcast(new UpDomainDump(
                [
                    'message' => ' ❌ Lỗi không lưu trữ được dữ liệu domain.... <br> ⚡ Kết thúc quá trình up domain...',
                    'id'  => 'process-5'
                ],
            ));

            return;
        }

        $dataInsert = [
            'domain' => $this->domain,
            'admin_username' => $result['admin_username'],
            'admin_password' => $result['admin_password'],
            'server' => config($this->server),
            'status' => 1,
            'provider' => $this->provider
        ];

        DB::connection('mongodb')
            ->table('domains')
            ->insert($dataInsert);

        broadcast(new UpDomainDump(
            [
                'message' => ' ✅ Hoàn tất lưu trữ dữ liệu domain! <br> ------- Hoàn tất việc up domain -------',
                'id'  => 'process-4'
            ],
        ));
    }
}
