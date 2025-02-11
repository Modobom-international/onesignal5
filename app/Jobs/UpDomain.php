<?php

namespace App\Jobs;

use App\Events\UpDomainDump;
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
        // $data = [
        //     'domain'      => $this->domain,
        //     'nameservers' => [
        //         'ben.ns.cloudflare.com',
        //         'jean.ns.cloudflare.com',
        //     ],
        // ];

        // $this->godaddyService->updateNameservers(
        //     $data['domain'],
        //     $data['nameservers']
        // );

        broadcast(new UpDomainDump('Xử lý bước 1'));

        broadcast(new UpDomainDump('Xử lý bước 2'));

        broadcast(new UpDomainDump('Xử lý bước 3'));

        broadcast(new UpDomainDump('Xử lý bước 4'));

        broadcast(new UpDomainDump('Xử lý bước 5'));

        broadcast(new UpDomainDump('Xử lý bước 6'));
    }
}
