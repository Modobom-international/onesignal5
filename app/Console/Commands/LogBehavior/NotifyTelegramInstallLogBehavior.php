<?php

namespace App\Console\Commands\LogBehavior;

use App\Jobs\NotifyTelegramInstallApp;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;

class NotifyTelegramInstallLogBehavior extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'log-behavior:notify-telegram-install-log-behavior';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check all install for platform';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $getDB = DB::connection('mongodb')
            ->table('app_install')
            ->get();

        $now = date('Y-m-d');
        $data = [];
        if (strtotime(date('H:i')) == strtotime(date('00:00'))) {
            $getLast60m = '23:00';
        } else {
            $getLast60m = date("H:i", strtotime('-60 minutes', strtotime(date('H:i'))));
        }

        $last60m = $getLast60m . ':00';
        $dateEstimateBefore = $now . ' ' . $last60m;
        $dateEstimateAfter = date('Y-m-d H:i:s');

        foreach ($getDB as $record) {
            if (isset($record->lock)) {
                if ($record->lock == '1') {
                    continue;
                }
            }

            if (strtotime($getLast60m) != strtotime($record->time_queue)) {
                dump('---- Bỏ qua ' . $getLast60m . ' ' . $record->time_queue);
                continue;
            }

            $strReport = '';
            if ($record->last_install != '') {
                $dataEqual = $record->last_install->toDateTime()->format('Y-m-d H:i:s');
                if (strtotime($dateEstimateBefore) > strtotime($dataEqual) or strtotime($dateEstimateAfter) < strtotime($dataEqual)) {
                    $strReport = $record->app . ' - ' . $record->country . ' - ' . $record->platform . ' : ' . $dataEqual . ' ( thời gian cài cuối cùng ) ' . '@' . $record->assigned;
                }
            } else {
                $strReport = $record->app . ' - ' . $record->country . ' - ' . $record->platform . ' : Chưa có lượt cài nào! ' . '@' . $record->assigned;
            }

            if ($strReport != '') {
                $data[] = $strReport;
            }

            $dataUpdate = [
                'time_queue' => date('H:i')
            ];

            DB::connection('mongodb')
                ->table('app_install')
                ->where('id', $record->id)
                ->update($dataUpdate);
        }

        $timeQueue = $dateEstimateBefore . ' - ' . $dateEstimateAfter;
        if (count($data) > 0) {
            dump('----Báo notification');
            NotifyTelegramInstallApp::dispatch($data, $timeQueue)->onQueue('notify_telegram_install_log_behavior');
        } else {
            dump('----Không báo notification');
        }
    }
}
