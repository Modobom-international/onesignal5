<?php

namespace App\Jobs;

use App\Events\UpDomainDump;
use App\Services\CloudFlareService;
use App\Services\GoDaddyService;
use App\Services\SSHService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class UpDomain implements ShouldQueue
{
    use Queueable;

    private $domain;
    private $server;

    /**
     * Create a new job instance.
     */
    public function __construct($domain, $server)
    {
        $this->domain = $domain;
        $this->server = $server;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $goDaddyService = new GoDaddyService();
        $cloudFlareService = new CloudFlareService();
        $sshService = new SSHService($this->server);

        $data = [
            'domain'      => $this->domain,
            'server'      => config($this->server),
            'command'     => '.',
            'nameservers' => [
                'ben.ns.cloudflare.com',
                'jean.ns.cloudflare.com',
            ],
        ];

        $result = [];

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
                    'message' => ' ❌ Lỗi không thêm được domain.... \n ⚡ Kết thúc quá trình up domain...',
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
            $data['domain'],
            $data['nameservers']
        );

        if (array_key_exists('error', $result)) {
            broadcast(new UpDomainDump(
                [
                    'message' => ' ❌ Lỗi không thay đổi được nameserver.... \n ⚡ Kết thúc quá trình up domain...',
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
                    'message' => ' ❌ Lỗi không thêm được DNS.... \n ⚡ Kết thúc quá trình up domain...',
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

        $result = $sshService->runCommand(
            $data['command']
        );

        // if (array_key_exists('error', $result)) {
        //     broadcast(new UpDomainDump(
        //         [
        //             'message' => ' ❌ Lỗi không khởi tạo được website.... \n ⚡ Kết thúc quá trình up domain...',
        //             'id'  => 'process-4'
        //         ],
        //     ));

        //     return;
        // } else {
        //     broadcast(new UpDomainDump(
        //         [
        //             'message' => ' ✅ Hoàn tất khởi tạo website!',
        //             'id'  => 'process-4'
        //         ],
        //     ));
        // }
    }
}
