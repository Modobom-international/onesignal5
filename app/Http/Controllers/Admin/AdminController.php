<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Laravel\Horizon\Contracts\WorkloadRepository;
use Laravel\Horizon\Contracts\MetricsRepository;

class AdminController extends Controller
{
    public function index()
    {
        $workloads = app(WorkloadRepository::class)->get();
        $runTimeHtmlSource = app(MetricsRepository::class)->runtimeForQueue('create_html_source');
        $runeTimeUsersTracking = app(MetricsRepository::class)->runtimeForQueue('create_users_tracking');
        $snapshotHtmlSource = app(MetricsRepository::class)->snapshotsForQueue('create_html_source');
        $snapshotUsersTracking = app(MetricsRepository::class)->snapshotsForQueue('create_users_tracking');

        $data = [
            'create_html_source' => [
                'length' => 0,
                'processes' => 0,
                'runtime' => $runTimeHtmlSource,
            ],
            'create_users_tracking' => [
                'length' => 0,
                'processes' => 0,
                'runtime' => $runeTimeUsersTracking,
            ]
        ];

        foreach ($workloads as $queue) {
            if ($queue['name'] == 'create_html_source') {
                $data['create_html_source']['length'] = $queue['length'];
                $data['create_html_source']['processes'] = $queue['processes'];
            }

            if ($queue['name'] == 'create_users_tracking') {
                $data['create_users_tracking']['length'] = $queue['length'];
                $data['create_users_tracking']['processes'] = $queue['processes'];
            }
        }

        $dataChart = [
            'create_html_source' => [
                'labels' => [],
                'values' => [],
            ],
            'create_users_tracking' => [
                'labels' => [],
                'values' => [],
            ]
        ];

        foreach ($snapshotHtmlSource as $snapHtml) {
            $dataChart['create_html_source']['labels'][] = $snapHtml->time;
            $dataChart['create_html_source']['values'][] = $snapHtml->throughput;
        }

        foreach ($snapshotUsersTracking as $snapUsers) {
            $dataChart['create_users_tracking']['labels'][] = $snapUsers->time;
            $dataChart['create_users_tracking']['values'][] = $snapUsers->throughput;
        }

        return view('admin.dashboard', compact('data', 'dataChart'));
    }

    public function fetchHorizonDashboard()
    {
        $workloads = app(WorkloadRepository::class)->get();
        $runTimeHtmlSource = app(MetricsRepository::class)->runtimeForQueue('create_html_source');
        $runTimeUsersTracking = app(MetricsRepository::class)->runtimeForQueue('create_users_tracking');

        $data = [
            'create_html_source' => [
                'length' => 0,
                'processes' => 0,
                'runtime' => $runTimeHtmlSource,
            ],
            'create_users_tracking' => [
                'length' => 0,
                'processes' => 0,
                'runtime' => $runTimeUsersTracking,
            ]
        ];

        foreach ($workloads as $queue) {
            if ($queue['name'] == 'create_html_source') {
                $data['create_html_source']['length'] = $queue['length'];
                $data['create_html_source']['processes'] = $queue['processes'];
            }

            if ($queue['name'] == 'create_users_tracking') {
                $data['create_users_tracking']['length'] = $queue['length'];
                $data['create_users_tracking']['processes'] = $queue['processes'];
            }
        }

        return response()->json($data);
    }
}
