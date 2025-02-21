<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Events\NotificationSystem;
use App\Helper\Common;

class NotificationCheckDomain implements ShouldQueue
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
        $message = 'Domain: ' . $this->data['domain'] . ' đã hoạt động';

        broadcast(new NotificationSystem(
            [
                'message' => $message,
                'users_id'  => $this->data['provider'],
                'status_read' => 0
            ],
        ));

        $dataInsert = [
            'message' => $message,
            'users_id'  => $this->data['provider'],
            'created_at' => Common::covertDateTimeToMongoBSONDateGMT7(Common::getCurrentVNTime()),
            'status_read' => 0
        ];

        DB::connection('mongodb')
            ->table('notification_system')
            ->insert($dataInsert);
    }
}
