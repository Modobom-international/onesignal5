<?php

namespace App\Console\Commands\TestCommand;

use Illuminate\Console\Command;
use App\Events\NotificationSystem;
use Auth;

class TestLogic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    protected $url;
    protected $signature = 'test:logic';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test command';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        //run hàm này ở thư mục root project : php artisan test:logic

        $data = [
            'message' => 'Viết message ở đây',
            'provider' => 1 //điền id của tài khoản em đăng nhập vào đây
        ];

        broadcast(new NotificationSystem(
            [
                'message' => $data['message'],
                'users_id'  => $data['provider'],
                'status_read' => 0,
                'id' => 1
            ],
        ));
    }
}
