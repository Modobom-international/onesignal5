@extends('layouts.app')

@section('title', 'Dashboard')

@section('styles')
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1 row">
        <div class="col-xl-3 metrics-item ml-3">
            <div class="white_card card_height_100 mb_30">
                <div class="white_card_header">
                    <div class="box_header m-0">
                        <div class="main-title">
                            <h3 class="m-0">Số liệu hàng đợi Html Source</h3>
                        </div>
                    </div>
                </div>
                <div class="white_card_body">
                    <div id="chartHtml">
                    </div>
                    <div class="monthly_plan_wraper">
                        <div class="single_plan d-flex align-items-center justify-content-between">
                            <div class="plan_left d-flex align-items-center">
                                <div class="thumb">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M4.25 2A2.25 2.25 0 002 4.25v2.5A2.25 2.25 0 004.25 9h2.5A2.25 2.25 0 009 6.75v-2.5A2.25 2.25 0 006.75 2h-2.5zm0 9A2.25 2.25 0 002 13.25v2.5A2.25 2.25 0 004.25 18h2.5A2.25 2.25 0 009 15.75v-2.5A2.25 2.25 0 006.75 11h-2.5zm9-9A2.25 2.25 0 0011 4.25v2.5A2.25 2.25 0 0013.25 9h2.5A2.25 2.25 0 0018 6.75v-2.5A2.25 2.25 0 0015.75 2h-2.5zm0 9A2.25 2.25 0 0011 13.25v2.5A2.25 2.25 0 0013.25 18h2.5A2.25 2.25 0 0018 15.75v-2.5A2.25 2.25 0 0015.75 11h-2.5z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h5>Hàng đợi</h5>
                                    <span>Tổng</span>
                                </div>
                            </div>
                            <span class="brouser_btn"
                                id="html-source-length">{{ $data['create_html_source']['length'] }}</span>
                        </div>
                        <div class="single_plan d-flex align-items-center justify-content-between">
                            <div class="plan_left d-flex align-items-center">
                                <div class="thumb">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M2 10a8 8 0 1116 0 8 8 0 01-16 0zm5-2.25A.75.75 0 017.75 7h.5a.75.75 0 01.75.75v4.5a.75.75 0 01-.75.75h-.5a.75.75 0 01-.75-.75v-4.5zm4 0a.75.75 0 01.75-.75h.5a.75.75 0 01.75.75v4.5a.75.75 0 01-.75.75h-.5a.75.75 0 01-.75-.75v-4.5z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h5>Thời gian chạy (ms)</h5>
                                    <span>Trung bình</span>
                                </div>
                            </div>
                            <span class="brouser_btn"
                                id="html-source-runtime">{{ number_format($data['create_html_source']['runtime'], 0) }}</span>
                        </div>

                        <div class="single_plan d-flex align-items-center justify-content-between">
                            <div class="plan_left d-flex align-items-center">
                                <div class="thumb">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                                        <path
                                            d="M128 96c26.5 0 48-21.5 48-48S154.5 0 128 0 80 21.5 80 48s21.5 48 48 48zm384 0c26.5 0 48-21.5 48-48S538.5 0 512 0s-48 21.5-48 48 21.5 48 48 48zm125.7 372.1l-44-110-41.1 46.4-2 18.2 27.7 69.2c5 12.5 17 20.1 29.7 20.1 4 0 8-.7 11.9-2.3 16.4-6.6 24.4-25.2 17.8-41.6zm-34.2-209.8L585 178.1c-4.6-20-18.6-36.8-37.5-44.9-18.5-8-39-6.7-56.1 3.3-22.7 13.4-39.7 34.5-48.1 59.4L432 229.8 416 240v-96c0-8.8-7.2-16-16-16H240c-8.8 0-16 7.2-16 16v96l-16.1-10.2-11.3-33.9c-8.3-25-25.4-46-48.1-59.4-17.2-10-37.6-11.3-56.1-3.3-18.9 8.1-32.9 24.9-37.5 44.9l-18.4 80.2c-4.6 20 .7 41.2 14.4 56.7l67.2 75.9 10.1 92.6C130 499.8 143.8 512 160 512c1.2 0 2.3-.1 3.5-.2 17.6-1.9 30.2-17.7 28.3-35.3l-10.1-92.8c-1.5-13-6.9-25.1-15.6-35l-43.3-49 17.6-70.3 6.8 20.4c4.1 12.5 11.9 23.4 24.5 32.6l51.1 32.5c4.6 2.9 12.1 4.6 17.2 5h160c5.1-.4 12.6-2.1 17.2-5l51.1-32.5c12.6-9.2 20.4-20 24.5-32.6l6.8-20.4 17.6 70.3-43.3 49c-8.7 9.9-14.1 22-15.6 35l-10.1 92.8c-1.9 17.6 10.8 33.4 28.3 35.3 1.2 .1 2.3 .2 3.5 .2 16.1 0 30-12.1 31.8-28.5l10.1-92.6 67.2-75.9c13.6-15.5 19-36.7 14.4-56.7zM46.3 358.1l-44 110c-6.6 16.4 1.4 35 17.8 41.6 16.8 6.6 35.1-1.7 41.6-17.8l27.7-69.2-2-18.2-41.1-46.4z" />
                                    </svg>
                                </div>
                                <div>
                                    <h5>Số tiến trình xử lý</h5>
                                    <span>Mặc định</span>
                                </div>
                            </div>
                            <span class="brouser_btn"
                                id="html-source-processes">{{ $data['create_html_source']['processes'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 metrics-item ml-3">
            <div class="white_card card_height_100 mb_30">
                <div class="white_card_header">
                    <div class="box_header m-0">
                        <div class="main-title">
                            <h3 class="m-0">Số liệu hàng đợi Users Tracking</h3>
                        </div>
                    </div>
                </div>
                <div class="white_card_body">
                    <div id="chartUsers">
                    </div>
                    <div class="monthly_plan_wraper">
                        <div class="single_plan d-flex align-items-center justify-content-between">
                            <div class="plan_left d-flex align-items-center">
                                <div class="thumb">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M4.25 2A2.25 2.25 0 002 4.25v2.5A2.25 2.25 0 004.25 9h2.5A2.25 2.25 0 009 6.75v-2.5A2.25 2.25 0 006.75 2h-2.5zm0 9A2.25 2.25 0 002 13.25v2.5A2.25 2.25 0 004.25 18h2.5A2.25 2.25 0 009 15.75v-2.5A2.25 2.25 0 006.75 11h-2.5zm9-9A2.25 2.25 0 0011 4.25v2.5A2.25 2.25 0 0013.25 9h2.5A2.25 2.25 0 0018 6.75v-2.5A2.25 2.25 0 0015.75 2h-2.5zm0 9A2.25 2.25 0 0011 13.25v2.5A2.25 2.25 0 0013.25 18h2.5A2.25 2.25 0 0018 15.75v-2.5A2.25 2.25 0 0015.75 11h-2.5z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h5>Hàng đợi</h5>
                                    <span>Tổng</span>
                                </div>
                            </div>
                            <span class="brouser_btn"
                                id="users-tracking-length">{{ $data['create_users_tracking']['length'] }}</span>
                        </div>
                        <div class="single_plan d-flex align-items-center justify-content-between">
                            <div class="plan_left d-flex align-items-center">
                                <div class="thumb">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M2 10a8 8 0 1116 0 8 8 0 01-16 0zm5-2.25A.75.75 0 017.75 7h.5a.75.75 0 01.75.75v4.5a.75.75 0 01-.75.75h-.5a.75.75 0 01-.75-.75v-4.5zm4 0a.75.75 0 01.75-.75h.5a.75.75 0 01.75.75v4.5a.75.75 0 01-.75.75h-.5a.75.75 0 01-.75-.75v-4.5z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h5>Thời gian chạy (ms)</h5>
                                    <span>Trung bình</span>
                                </div>
                            </div>
                            <span class="brouser_btn"
                                id="users-tracking-runtime">{{ number_format($data['create_users_tracking']['runtime'], 0) }}</span>
                        </div>

                        <div class="single_plan d-flex align-items-center justify-content-between">
                            <div class="plan_left d-flex align-items-center">
                                <div class="thumb">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                                        <path
                                            d="M128 96c26.5 0 48-21.5 48-48S154.5 0 128 0 80 21.5 80 48s21.5 48 48 48zm384 0c26.5 0 48-21.5 48-48S538.5 0 512 0s-48 21.5-48 48 21.5 48 48 48zm125.7 372.1l-44-110-41.1 46.4-2 18.2 27.7 69.2c5 12.5 17 20.1 29.7 20.1 4 0 8-.7 11.9-2.3 16.4-6.6 24.4-25.2 17.8-41.6zm-34.2-209.8L585 178.1c-4.6-20-18.6-36.8-37.5-44.9-18.5-8-39-6.7-56.1 3.3-22.7 13.4-39.7 34.5-48.1 59.4L432 229.8 416 240v-96c0-8.8-7.2-16-16-16H240c-8.8 0-16 7.2-16 16v96l-16.1-10.2-11.3-33.9c-8.3-25-25.4-46-48.1-59.4-17.2-10-37.6-11.3-56.1-3.3-18.9 8.1-32.9 24.9-37.5 44.9l-18.4 80.2c-4.6 20 .7 41.2 14.4 56.7l67.2 75.9 10.1 92.6C130 499.8 143.8 512 160 512c1.2 0 2.3-.1 3.5-.2 17.6-1.9 30.2-17.7 28.3-35.3l-10.1-92.8c-1.5-13-6.9-25.1-15.6-35l-43.3-49 17.6-70.3 6.8 20.4c4.1 12.5 11.9 23.4 24.5 32.6l51.1 32.5c4.6 2.9 12.1 4.6 17.2 5h160c5.1-.4 12.6-2.1 17.2-5l51.1-32.5c12.6-9.2 20.4-20 24.5-32.6l6.8-20.4 17.6 70.3-43.3 49c-8.7 9.9-14.1 22-15.6 35l-10.1 92.8c-1.9 17.6 10.8 33.4 28.3 35.3 1.2 .1 2.3 .2 3.5 .2 16.1 0 30-12.1 31.8-28.5l10.1-92.6 67.2-75.9c13.6-15.5 19-36.7 14.4-56.7zM46.3 358.1l-44 110c-6.6 16.4 1.4 35 17.8 41.6 16.8 6.6 35.1-1.7 41.6-17.8l27.7-69.2-2-18.2-41.1-46.4z" />
                                    </svg>
                                </div>
                                <div>
                                    <h5>Số tiến trình xử lý</h5>
                                    <span>Mặc định</span>
                                </div>
                            </div>
                            <span class="brouser_btn"
                                id="users-tracking-processes">{{ $data['create_users_tracking']['processes'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        const chartDataHtmlSource = <?php echo json_encode($dataChart['create_html_source']); ?>;
        const chartDataUsersTracking = <?php echo json_encode($dataChart['create_users_tracking']); ?>;

        var optionsHtml = {
            chart: {
                type: 'line',
                height: 250,
                background: 'transparent',
                toolbar: {
                    show: false
                },
                zoom: {
                    enabled: false
                }
            },
            series: [{
                name: 'html_source',
                data: chartDataHtmlSource.values
            }],
            xaxis: {
                labels: {
                    show: false
                },
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false
                }
            },
            yaxis: {
                labels: {
                    show: false
                },
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false
                }
            },
            dataLabels: {
                enabled: false
            },
            legend: {
                show: false
            },
            tooltip: {
                enabled: false
            },
            grid: {
                show: false
            },
        }

        var optionsUsers = {
            chart: {
                type: 'line',
                height: 250,
                background: 'transparent',
                toolbar: {
                    show: false
                },
                zoom: {
                    enabled: false
                }
            },
            series: [{
                name: 'html_source',
                data: chartDataUsersTracking.values
            }],
            xaxis: {
                labels: {
                    show: false
                },
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false
                }
            },
            yaxis: {
                labels: {
                    show: false
                },
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false
                }
            },
            dataLabels: {
                enabled: false
            },
            legend: {
                show: false
            },
            tooltip: {
                enabled: false
            },
            grid: {
                show: false
            },
        }

        const chartHtml = new ApexCharts(document.querySelector("#chartHtml"), optionsHtml);
        const chartUsers = new ApexCharts(document.querySelector("#chartUsers"), optionsUsers);

        chartHtml.render();
        chartUsers.render();

        function getRuneTime() {
            $.ajax({
                url: '/admin/fetch-horizon-dashboard',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('#html-source-length').text(response.create_html_source.length);
                    $('#html-source-runtime').text(Math.floor(response.create_html_source.runtime));
                    $('#html-source-processes').text(response.create_html_source.processes);

                    $('#users-tracking-length').text(response.create_users_tracking.length);
                    $('#users-tracking-runtime').text(Math.floor(response.create_users_tracking.runtime));
                    $('#users-tracking-processes').text(response.create_users_tracking.processes);
                }
            });
        }

        setInterval(getRuneTime, 60000);
    </script>
@endsection
