<?php

namespace App\Jobs;

use App\Helper\Domain;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class NotificationDeleteDomain implements ShouldQueue
{
    use Queueable;

    protected $data;

    /**
     * Create a new job instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $send = [
            'message' => 'Domain: ' . $this->data['domain'] . ' đã được xóa',
            'provider' => $this->data['provider']
        ];

        $notiSystem = new Domain();
        $notiSystem->storeMessage($send);
    }
}
