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

</script>
@endsection