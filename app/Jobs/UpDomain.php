<?php

namespace App\Jobs;

use App\Events\UpDomainDump;
use App\Services\CloudFlareService;
use App\Services\GoDaddyService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class UpDomain implements ShouldQueue
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
        $goDaddyService = new GoDaddyService();
        $cloudFlareService = new CloudFlareService();

        $data = [
            'domain'      => $this->domain,
            'nameservers' => [
                'ben.ns.cloudflare.com',
                'jean.ns.cloudflare.com',
            ],
        ];

        $result = $goDaddyService->updateNameservers(
            $data['domain'],
            $data['nameservers']
        );

        if (array_key_exists('error', $result)) {
            $message = 'Lỗi không thay đổi được nameserver....';

            broadcast(new UpDomainDump($message));

            $message = 'Kết thúc quá trình up domain...';

            broadcast(new UpDomainDump($message));

            return;
        } else {
            $message = 'Hoàn tất thay đổi nameserver trên Godaddy!';

            broadcast(new UpDomainDump($message));
        }
    }
}
