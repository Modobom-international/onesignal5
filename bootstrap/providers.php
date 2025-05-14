<?php

return [
    App\Providers\AppServiceProvider::class,
    MongoDB\Laravel\MongoDBServiceProvider::class,
    App\Providers\BroadcastServiceProvider::class,
    Barryvdh\Debugbar\ServiceProvider::class,
    Illuminate\View\ViewServiceProvider::class,
];
