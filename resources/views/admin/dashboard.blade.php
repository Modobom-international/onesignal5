@extends('layouts.app')

@section('title', 'Dashboard')

@section('styles')
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="max-w-[1440px]">
        <!-- Today Section -->
        <div class="bg-white mb-8">
            <div class="pt-6 pb-4">
                <div class="pb-6">
                    <h2 class="text-2xl font-semibold text-[#1a1f36] mb-6 border-b pb-2  border-[#e5e7eb]">Queue Metrics
                    </h2>

                    <!-- Metrics Grid -->
                    <div class="grid grid-cols-12 gap-8 ">
                        <!-- HTML Source Queue -->
                        <div class="col-span-4">
                            <div class="flex items-center justify-between mb-1">
                                <div class="flex items-center gap-1">
                                    <h3 class="text-[14px] text-[#1a1f36] font-medium">HTML Source Queue</h3>
                                    <div class="relative inline-block">
                                        <button class="text-[#1a1f36] opacity-40 hover:opacity-60">
                                            <svg class="w-3.5 h-3.5" viewBox="0 0 16 16" fill="currentColor">
                                                <path
                                                    d="M8 10.4l-3.7-3.7c-.2-.2-.3-.4-.3-.7 0-.3.1-.5.3-.7.2-.2.4-.3.7-.3.3 0 .5.1.7.3L8 7.6l2.3-2.3c.2-.2.4-.3.7-.3.3 0 .5.1.7.3.2.2.3.4.3.7 0 .3-.1.5-.3.7L8 10.4z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-baseline">
                                <span class="text-[22px] text-[#1a1f36] font-semibold"
                                    id="html-source-length">{{ $data['create_html_source']['length'] }}</span>
                                <span class="ml-3 text-[13px] text-[#1a1f36] opacity-60">Jobs in queue</span>
                            </div>
                            <div class="text-[13px] text-[#1a1f36] opacity-60">
                                Runtime: <span
                                    id="html-source-runtime">{{ round($data['create_html_source']['runtime']) }}ms</span>
                            </div>
                        </div>

                        <!-- Users Tracking Queue -->
                        <div class="col-span-4">
                            <div class="flex items-center justify-between mb-1">
                                <div class="flex items-center gap-1">
                                    <h3 class="text-[14px] text-[#1a1f36] font-medium">Users Tracking Queue</h3>
                                    <div class="relative inline-block">
                                        <button class="text-[#1a1f36] opacity-40 hover:opacity-60">
                                            <svg class="w-3.5 h-3.5" viewBox="0 0 16 16" fill="currentColor">
                                                <path
                                                    d="M8 10.4l-3.7-3.7c-.2-.2-.3-.4-.3-.7 0-.3.1-.5.3-.7.2-.2.4-.3.7-.3.3 0 .5.1.7.3L8 7.6l2.3-2.3c.2-.2.4-.3.7-.3.3 0 .5.1.7.3.2.2.3.4.3.7 0 .3-.1.5-.3.7L8 10.4z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-baseline">
                                <span class="text-[22px] text-[#1a1f36] font-semibold"
                                    id="users-tracking-length">{{ $data['create_users_tracking']['length'] }}</span>
                                <span class="ml-3 text-[13px] text-[#1a1f36] opacity-60">Jobs in queue</span>
                            </div>
                            <div class="text-[13px] text-[#1a1f36] opacity-60">
                                Runtime: <span
                                    id="users-tracking-runtime">{{ round($data['create_users_tracking']['runtime']) }}ms</span>
                            </div>
                        </div>

                        <!-- Queue Processes -->
                        <div class="col-span-4">
                            <div class="flex items-center justify-between mb-1">
                                <h3 class="text-[14px] text-[#1a1f36] font-medium">Active Processes</h3>
                            </div>
                            <div class="flex items-baseline">
                                <span class="text-[22px] text-[#1a1f36] font-semibold">
                                    {{ $data['create_html_source']['processes'] + $data['create_users_tracking']['processes'] }}
                                </span>
                                <span class="ml-3 text-[13px] text-[#1a1f36] opacity-60">Total processes</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Throughput Graph -->
                <div class="h-[180px] mt-6" id="todayChart"></div>
            </div>
        </div>

        <!-- Queue Overview Section -->
        <div class="bg-white">
            <div class="pt-6 pb-4">
                <div class="flex-1 items-center justify-between mb-6">
                    <h2 class="text-2xl font-semibold text-[#1a1f36] mb-6 border-b pb-2  border-[#e5e7eb]">Queue Overview
                    </h2>
                    <div class="flex items-center gap-3">
                        <div class="flex items-center gap-2 text-[13px]">
                            <span class="text-[#1a1f36] px-3 py-1.5 rounded-md font-medium">Last 24 hours</span>
                        </div>
                    </div>
                </div>

                <!-- Overview Grid -->
                <div class="grid grid-cols-12 gap-6">
                    <!-- HTML Source Throughput -->
                    <div class="col-span-6 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-1">
                                <h3 class="text-[14px] text-[#1a1f36] font-medium">HTML Source Throughput</h3>
                                <button class="text-[#1a1f36] opacity-40 hover:opacity-60">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 14 14" fill="none" stroke="currentColor">
                                        <circle cx="7" cy="7" r="6.5" />
                                        <path d="M7 4.5V7l1.5 1.5" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="h-[120px]" id="paymentsChart"></div>
                    </div>

                    <!-- Users Tracking Throughput -->
                    <div class="col-span-6 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-1">
                                <h3 class="text-[14px] text-[#1a1f36] font-medium">Users Tracking Throughput</h3>
                                <button class="text-[#1a1f36] opacity-40 hover:opacity-60">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 14 14" fill="none" stroke="currentColor">
                                        <circle cx="7" cy="7" r="6.5" />
                                        <path d="M7 4.5V7l1.5 1.5" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="h-[120px]" id="grossVolumeChart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        // Today's chart (Queue Throughput Chart)
        const todayOptions = {
            chart: {
                type: 'area',
                height: 180,
                fontFamily: '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif',
                toolbar: {
                    show: false
                },
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800
                }
            },
            stroke: {
                curve: 'smooth',
                width: 2,
                lineCap: 'round'
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.4,
                    opacityTo: 0.1,
                    stops: [0, 100]
                }
            },
            series: [{
                    name: 'HTML Source Queue',
                    data: @json($dataChart['create_html_source']['values'])
                },
                {
                    name: 'Users Tracking Queue',
                    data: @json($dataChart['create_users_tracking']['values'])
                }
            ],
            grid: {
                show: true,
                borderColor: '#f1f5f9',
                strokeDashArray: 1,
                position: 'back',
                xaxis: {
                    lines: {
                        show: true
                    }
                },
                yaxis: {
                    lines: {
                        show: true
                    }
                },
                padding: {
                    top: 10,
                    right: 0,
                    bottom: 0,
                    left: 10
                }
            },
            legend: {
                show: true,
                position: 'top',
                horizontalAlign: 'right',
                fontSize: '13px',
                fontFamily: '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif',
                markers: {
                    width: 8,
                    height: 8,
                    radius: 12
                }
            },
            colors: ['#635bff', '#36b37e'],
            xaxis: {
                type: 'datetime',
                categories: @json($dataChart['create_html_source']['labels']),
                labels: {
                    style: {
                        colors: '#697386',
                        fontSize: '12px',
                        fontWeight: 400
                    },
                    datetimeFormatter: {
                        year: 'yyyy',
                        month: "MMM 'yy",
                        day: 'dd MMM',
                        hour: 'HH:mm'
                    }
                },
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false
                }
            },
            yaxis: {
                min: 0,
                labels: {
                    style: {
                        colors: '#697386',
                        fontSize: '12px',
                        fontWeight: 400
                    },
                    formatter: value => Math.round(value)
                }
            },
            dataLabels: {
                enabled: false
            },
            tooltip: {
                enabled: true,
                shared: true,
                intersect: false,
                theme: 'light',
                style: {
                    fontSize: '12px',
                    fontFamily: '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif'
                },
                x: {
                    format: 'dd MMM yyyy HH:mm'
                },
                y: {
                    formatter: value => Math.round(value)
                },
                marker: {
                    show: false
                }
            }
        };

        // Overview charts configuration for Queues
        const htmlSourceConfig = {
            chart: {
                type: 'area',
                height: 120,
                sparkline: {
                    enabled: true
                },
                toolbar: {
                    show: false
                }
            },
            stroke: {
                curve: 'smooth',
                width: 2,
                lineCap: 'round'
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.4,
                    opacityTo: 0.1,
                    stops: [0, 100]
                }
            },
            series: [{
                name: 'Throughput',
                data: @json($dataChart['create_html_source']['values'])
            }],
            yaxis: {
                min: 0,
                labels: {
                    formatter: value => Math.round(value)
                }
            },
            colors: ['#635bff'],
            tooltip: {
                enabled: true,
                theme: 'light',
                style: {
                    fontSize: '12px'
                },
                x: {
                    show: false
                },
                y: {
                    title: {
                        formatter: () => 'Throughput:'
                    },
                    formatter: value => Math.round(value)
                }
            }
        };

        const usersTrackingConfig = {
            ...htmlSourceConfig,
            series: [{
                name: 'Throughput',
                data: @json($dataChart['create_users_tracking']['values'])
            }]
        };

        // Initialize charts
        const mainChart = new ApexCharts(document.querySelector("#todayChart"), todayOptions);
        const htmlSourceChart = new ApexCharts(document.querySelector("#paymentsChart"), htmlSourceConfig);
        const usersTrackingChart = new ApexCharts(document.querySelector("#grossVolumeChart"), usersTrackingConfig);

        mainChart.render();
        htmlSourceChart.render();
        usersTrackingChart.render();

        // Real-time updates
        async function updateQueueMetrics() {
            try {
                const response = await fetch('/admin/fetch-horizon-dashboard');
                const data = await response.json();

                // Update metrics display
                document.querySelector('#html-source-length').textContent = data.create_html_source.length;
                document.querySelector('#html-source-runtime').textContent =
                    data.create_html_source.runtime ? Math.round(data.create_html_source.runtime) + 'ms' : '0ms';

                document.querySelector('#users-tracking-length').textContent = data.create_users_tracking.length;
                document.querySelector('#users-tracking-runtime').textContent =
                    data.create_users_tracking.runtime ? Math.round(data.create_users_tracking.runtime) + 'ms' : '0ms';
            } catch (error) {
                console.error('Error fetching queue metrics:', error);
            }
        }

        // Update metrics every 5 seconds
        setInterval(updateQueueMetrics, 5000);
    </script>
@endsection
