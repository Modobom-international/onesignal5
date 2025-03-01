<?php

namespace App\Helper;

use App\Events\NotificationSystem;
use App\Helper\Common;
use Illuminate\Support\Facades\DB;

class Domain
{
    public function storeMessage($data)
    {
        $dataInsert = [
            'message' => $data['message'],
            'users_id'  => $data['provider'],
            'created_at' => Common::covertDateTimeToMongoBSONDateGMT7(Common::getCurrentVNTime()),
            'status_read' => 0
        ];

        $idInsert = DB::connection('mongodb')
            ->table('notification_system')
            ->insertGetId($dataInsert);

        broadcast(new NotificationSystem(
            [
                'message' => $data['message'],
                'users_id'  => $data['provider'],
                'status_read' => 0,
                'id' => $idInsert
            ],
        ));
    }
}
