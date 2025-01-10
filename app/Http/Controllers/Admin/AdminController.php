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
        $runTimeLogBehavior = app(MetricsRepository::class)->runtimeForQueue('create_log_behavior');
        $runTimeHtmlSource = app(MetricsRepository::class)->runtimeForQueue('create_html_source');
        $snapshotLogBehavior = app(MetricsRepository::class)->snapshotsForQueue('create_log_behavior');
        $snapshotHtmlSource = app(MetricsRepository::class)->snapshotsForQueue('create_html_source');

        $data = [
            'create_log_behavior' => [
                'length' => 0,
                'processes' => 0,
                'runtime' => $runTimeLogBehavior,
            ],
            'create_html_source' => [
                'length' => 0,
                'processes' => 0,
                'runtime' => $runTimeHtmlSource,
            ]
        ];

        foreach ($workloads as $queue) {
            if ($queue['name'] == 'create_log_behavior') {
                $data['create_log_behavior']['length'] = $queue['length'];
                $data['create_log_behavior']['processes'] = $queue['processes'];
            }

            if ($queue['name'] == 'create_html_source') {
                $data['create_html_source']['length'] = $queue['length'];
                $data['create_html_source']['processes'] = $queue['processes'];
            }
        }

        $dataChart = [
            'create_log_behavior' => [
                'labels' => [],
                'values' => [],
            ],
            'create_html_source' => [
                'labels' => [],
                'values' => [],
            ]
        ];

        foreach ($snapshotLogBehavior as $snapLog) {
            $dataChart['create_log_behavior']['labels'][] = $snapLog->time;
            $dataChart['create_log_behavior']['values'][] = $snapLog->throughput;
        }

        foreach ($snapshotHtmlSource as $snapHtml) {
            $dataChart['create_html_source']['labels'][] = $snapHtml->time;
            $dataChart['create_html_source']['values'][] = $snapHtml->throughput;
        }

        return view('admin.dashboard', compact('data', 'dataChart'));
    }

    public function fetchHorizonDashboard()
    {
        $workloads = app(WorkloadRepository::class)->get();
        $runTimeLogBehavior = app(MetricsRepository::class)->runtimeForQueue('create_log_behavior');
        $runTimeHtmlSource = app(MetricsRepository::class)->runtimeForQueue('create_html_source');

        $data = [
            'create_log_behavior' => [
                'length' => 0,
                'processes' => 0,
                'runtime' => $runTimeLogBehavior,
            ],
            'create_html_source' => [
                'length' => 0,
                'processes' => 0,
                'runtime' => $runTimeHtmlSource,
            ]
        ];

        foreach ($workloads as $queue) {
            if ($queue['name'] == 'create_log_behavior') {
                $data['create_log_behavior']['length'] = $queue['length'];
                $data['create_log_behavior']['processes'] = $queue['processes'];
            }

            if ($queue['name'] == 'create_html_source') {
                $data['create_html_source']['length'] = $queue['length'];
                $data['create_html_source']['processes'] = $queue['processes'];
            }
        }

        return response()->json($data);
    }
}
