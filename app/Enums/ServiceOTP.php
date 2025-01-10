<?php

namespace App\Enums;

final class ServiceOTP
{
    const STATUS_WAITING = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_TIME_OUT = 2;
    const STATUS_OTHER = 3;

    const TEXT_STATUS = [
        'Đang chờ', 'Đã gửi xác thực', 'Hết thời gian', 'Tác vụ khác'
    ];

    const TEXT_COLOR = [
        0 => [
            'background-color' => 'yellow',
            'color' => 'black'
        ],
        1 => [
            'background-color' => 'green',
            'color' => 'black'
        ],
        2 => [
            'background-color' => 'red',
            'color' => 'white'
        ],
        3 => [
            'background-color' => 'yellow',
            'color' => 'black'
        ],
    ];
}
