@extends('layouts.app')

@section('title', 'Log behavior')

@section('styles')
<link href="{{ asset('css/log-behavior.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <button onclick="topFunction()" id="back-to-top" title="Go to top"><i class="fa fa-arrow-circle-up"></i></button>
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-lg-2 col-md-12">
                        <label class="form-label">Ngày</label>
                        <input class="form-control" type="text" id="datepicker">
                    </div>
                    <div class="col-lg-2 col-md-12">
                        <label class="form-label">Ứng dụng</label>
                        <select class="form-select" id="app-name">
                            <option value="all">Tất cả</option>
                            @foreach($listArrayApp as $app)
                            <option value="{{ $app }}">{{ $app }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-12">
                        <label class="form-label">Quốc gia</label>
                        <select class="form-select" id="country">
                            <option value="all">Tất cả</option>
                            @foreach($listArrayCountry as $country)
                            <option value="{{ $country }}">{{ $country }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-12">
                        <label class="form-label">Nền tảng</label>
                        <select class="form-select" id="platform">
                            <option value="all">Tất cả</option>
                            @foreach($listArrayPlatform as $platform)
                            <option value="{{ $platform }}">{{ $platform }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-12">
                        <label class="form-label">Mạng</label>
                        <select class="form-select" id="network">
                            <option value="all">Tất cả</option>
                            @foreach($networks as $network)
                            @if($network != '')
                            <option value="{{ $network }}">{{ $network }}</option>
                            @endif
                            @endforeach
                            <option value="other">KHONG_CO_SIM</option>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-12">
                        <label class="form-label">Tổng</label>
                        <select class="form-select" id="install">
                            <option value="all">Tất cả</option>
                            <option value="install">Chỉ cài đặt</option>
                            <option value="country">Chỉ sai quốc gia</option>
                            <option value="network">Chỉ sai nhà mạng</option>
                            <option value="test">Chỉ device test</option>
                            <option value="sub">Chỉ user sub</option>
                            <option value="real">Chỉ thực cài</option>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-12">
                        <button type="button" class="btn btn-primary mt-4 mb-4" id="search-report">Tìm kiếm</button>
                    </div>
                    <div class="col-lg-12 col-md-12 d-flex" id="group-btn-filter">
                        <div>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalListAppCheckInstall">Danh sách lượt cài ứng dụng</button>
                        </div>
                        <div class="ml-3">
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalChangeSelection">Chỉnh sửa lựa chọn</button>
                        </div>
                        <div class="ml-3">
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalReport">Thống kê</button>
                        </div>
                        <?php
                        $pareDate = $filter['date'];
                        $display = true;
                        if (strtotime($today) < strtotime($pareDate)) {
                            $display = false;
                        }
                        ?>
                        @if($display)
                        <div class="ml-3">
                            <button type="button" class="btn btn-success" id="compare-date-btn">So sánh ngày</button>
                        </div>
                        @endif
                        <div class="ml-3">
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalActivity">Lịch sử hoạt động</button>
                        </div>
                    </div>
                </div>
                <div>
                    @if($statusPaginate)
                    {{ $data->links() }}
                    @endif
                    Show in page :
                    <a class="btn" id="show-in-page-100">100</a>
                    <a class="btn" id="show-in-page-150">150</a>
                    <a class="btn" id="show-in-page-200">200</a>
                    <a class="btn" id="show-in-page-250">250</a>
                    <a class="btn" id="show-in-page-all">All</a>
                </div>
                <div class="d-flex mt-2 compare-date">
                    <button class="Btn" id="btn-compare">
                        <span class="text">Compare</span>
                        <span class="svgIcon">
                            <svg fill="white" viewBox="0 0 384 512" height="1em" xmlns="http://www.w3.org/2000/svg">
                                <path d="M280 64h40c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V128C0 92.7 28.7 64 64 64h40 9.6C121 27.5 153.3 0 192 0s71 27.5 78.4 64H280zM64 112c-8.8 0-16 7.2-16 16V448c0 8.8 7.2 16 16 16H320c8.8 0 16-7.2 16-16V128c0-8.8-7.2-16-16-16H304v24c0 13.3-10.7 24-24 24H192 104c-13.3 0-24-10.7-24-24V112H64zm128-8a24 24 0 1 0 0-48 24 24 0 1 0 0 48z"></path>
                            </svg>
                        </span>
                    </button>
                    <div class="col-lg-2 col-md-12 ml-3">
                        <input class="form-control" type="text" id="datepicker-previous" placeholder="Chọn ngày">
                    </div>
                    <div class="mb-10x">
                        <button class="btn" id="btn-turn-off-compare"><img src="{{ asset('/img/remove.png') }}" width="30px"></button>
                    </div>
                    <div id="loader-previous-date" class="loader hide loader-previous"></div>
                </div>
                <div class="d-flex mt-3" id="area-total-all">
                    @if($statusPaginate)
                    <div>
                        <b>Tổng id : <span class="text-danger">{{ $data->total() }} </span></b>
                    </div>
                    @else
                    <div>
                        <b>Tổng id : <span class="text-danger">{{ count($data) }}</span></b>
                    </div>
                    @endif
                    <div class="ml-5">
                        <b>Tổng lượt cài : <span class="text-danger">{{ $totalInstall ?? 0 }}</span></b>
                    </div>
                    <div class="ml-5">
                        <b>Tổng sai quốc gia : <span class="text-danger">{{ $totalWrongCountry ?? 0 }}</span></b>
                    </div>
                    <div class="ml-5">
                        <b>Tổng sai nhà mạng : <span class="text-danger">{{ $totalWrongNetWork ?? 0 }}</span></b>
                    </div>
                    <div class="ml-5">
                        <b>Device test : <span class="text-danger">{{ $totalDeviceTest ?? 0 }}</span></b>
                    </div>
                    <div class="ml-5">
                        <b>Tổng user sub : <span class="text-danger">{{ $totalUserSub ?? 0 }}</span></b>
                    </div>
                    <div class="ml-5">
                        <b>Tổng thực cài : <span class="text-danger">{{ $totalTrueInstall ?? 0 }}</span></b>
                    </div>
                    <div class="ml-4 compare-date">
                        <p><b>--- Ngày :</b> <span id="real-time"></span></p>
                    </div>
                </div>
                <div class="mt-2" id="area-compare-date">
                    <div>
                        <b>Tổng id : <span class="text-danger" id="total-id-previous">0</span></b>
                    </div>
                    <div class="ml-5">
                        <b>Tổng lượt cài : <span class="text-danger" id="total-install-previous">0</span></b>
                    </div>
                    <div class="ml-5">
                        <b>Tổng sai quốc gia : <span class="text-danger" id="wrong-country-previous">0</span></b>
                    </div>
                    <div class="ml-5">
                        <b>Tổng sai nhà mạng : <span class="text-danger" id="wrong-network-previous">0</span></b>
                    </div>
                    <div class="ml-5">
                        <b>Device test : <span class="text-danger" id="device-test-previous">0</span></b>
                    </div>
                    <div class="ml-5">
                        <b>Tổng user sub : <span class="text-danger" id="user-sub-previous">0</span></b>
                    </div>
                    <div class="ml-5">
                        <b>Tổng thực cài : <span class="text-danger" id="true-install-previous">0</span></b>
                    </div>
                    <div class="ml-4 d-none" id="text-date-area-compare-date">
                        <p><b>--- Ngày :</b> <span id="text-date-previous"></span></p>
                    </div>
                </div>
                <div class="show-content">
                    {{ $textShowContent }}
                </div>
                @if($totalForThaoVy)
                <div class="show-content">
                    <p>Tổng nè : {{ $totalForThaoVy }}</p>
                </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Ngày Cài</th>
                                <th scope="col">Ngày</th>
                                <th scope="col" width="10%">Ứng dụng</th>
                                <th scope="col" width="6%">Quốc gia</th>
                                <th scope="col" width="6%">Nền tảng</th>
                                <th scope="col" width="10%">Mạng</th>
                                <th scope="col" class="for-behavior">Hành vi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $record)
                            <tr>
                                <th scope="row">{{ $record->uid ?? '' }}</th>
                                <td>{{ $record->date_install ?? '' }}</td>
                                <td>{{ $record->date ?? '' }}</td>
                                <td>{{ $record->app ?? ''}}</td>
                                <td>{{ $record->country ?? ''}}</td>
                                <td>{{ $record->platform ?? ''}}</td>
                                <td>{{ $record->network ?? 'KHONG_CO_SIM' }}</td>
                                @if(isset($record->behavior))
                                @php
                                $behavior = json_decode($record->behavior, true);
                                if($behavior == null) {
                                $behavior = array();
                                }
                                @endphp
                                <td>
                                    <ul class="list-style-disc">
                                        @foreach($behavior as $key => $value)
                                        <li>{{ $key }} : {{ $value }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                @else
                                <td></td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalListAppCheckInstall" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalListAppCheckInstallLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalChangeSelectionLabel">Danh sách lượt cài ứng dụng</h5>
                <div class="error-message-modal">
                    <p>Ứng dụng đã tồn tại</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <div class="ml-4 text-danger">
                    <h4>Thêm mới</h4>
                </div>
                <div class="row choose-area-modal">
                    <div class="col-lg-3">
                        <label class="form-label">Ứng dụng</label>
                        <select class="form-select" id="app-name-modal">
                            @foreach($listArrayApp as $app)
                            <option value="{{ $app }}">{{ $app }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label class="form-label">Quốc gia</label>
                        <select class="form-select" id="country-modal">
                            @foreach($listArrayCountry as $country)
                            <option value="{{ $country }}">{{ $country }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <label class="form-label">Nền tảng</label>
                        <select class="form-select" id="platform-modal">
                            @foreach($listArrayPlatform as $platform)
                            <option value="{{ $platform }}">{{ $platform }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label class="form-label">Người theo dõi</label>
                        <select class="form-select" id="assigned-modal">
                            @foreach($listAssigned as $assigned)
                            <option value="{{ $assigned }}">{{ $assigned }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-1">
                        <button type="button" class="btn btn-primary" style="margin-top: 30px; margin-bottom: 30px;" onclick="addAppToList()">Thêm</button>
                    </div>
                </div>
                <div class="ml-4 text-danger">
                    <h4>Tìm kiếm</h4>
                </div>
                <div class="row choose-area-modal">
                    <div class="col-lg-3">
                        <label class="form-label">Ứng dụng</label>
                        <select class="form-select" id="app-name-search-modal">
                            <option value="all">Tất cả</option>
                            @foreach($apps as $app)
                            @if($app != '')
                            <option value="{{ $app }}">{{ ucfirst($app) }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label class="form-label">Quốc gia</label>
                        <select class="form-select" id="country-search-modal">
                            <option value="all">Tất cả</option>
                            @foreach($listArrayCountry as $country)
                            <option value="{{ $country }}">{{ $country }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <label class="form-label">Nền tảng</label>
                        <select class="form-select" id="platform-search-modal">
                            <option value="all">Tất cả</option>
                            @foreach($listArrayPlatform as $platform)
                            <option value="{{ $platform }}">{{ $platform }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label class="form-label">Người theo dõi</label>
                        <select class="form-select" id="assigned-search-modal">
                            <option value="all">Tất cả</option>
                            @foreach($listAssigned as $assigned)
                            <option value="{{ $assigned }}">{{ $assigned }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-1">
                        <button type="button" class="btn btn-primary" style="margin-top: 30px; margin-bottom: 30px;" onclick="searchAppInList()">Tìm</button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped" id="table-list-check-install">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Ứng dụng</th>
                                <th scope="col">Quốc gia</th>
                                <th scope="col">Nền tảng</th>
                                <th scope="col">Người theo dõi</th>
                                <th scope="col">Thời gian cài cuối cùng</th>
                                <th scope="col">Hành động</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-modal">
                            @foreach($listAppCheck as $keyCheck => $check)
                            <tr id="{{ $check->id }}">
                                <th scope="row">{{ $keyCheck + 1 }}</th>
                                <td>{{ ucfirst($check->app) }}</td>
                                <td>{{ ucfirst($check->country) }}</td>
                                <td>{{ ucfirst($check->platform) }}</td>
                                <td>{{ $check->assigned }}</td>
                                <td>{{ !is_string($check->last_install) ? $check->last_install->toDateTime()->format('Y-m-d H:i:s') : 'Chưa có lượt cài mới' }}</td>
                                <td class="d-flex align-items-center">
                                    <button data-id="{{ $check->id }}" class="btn btn-danger delete-app-in-list-check"><i class="fa fa-trash"></i></button>
                                    @if(!isset($check->lock))
                                    <button id="lock-{{ $check->id }}" data-id="{{ $check->id }}" title="Unlock" data-lock="1" class="btn btn-warning lock-app-in-list-check"><i class="fa fa-bell-slash"></i></button>
                                    @else
                                    @if($check->lock == 0)
                                    <button id="lock-{{ $check->id }}" data-id="{{ $check->id }}" title="Lock" data-lock="1" class="btn btn-warning lock-app-in-list-check"><i class="fa fa-bell-slash"></i></button>
                                    @else
                                    <button id="lock-{{ $check->id }}" data-id="{{ $check->id }}" title="Unlock" data-lock="0" class="btn btn-success lock-app-in-list-check"><i class="fa fa-bell"></i></button>
                                    @endif
                                    @endif
                                    <div id="loader-{{ $check->id }}" class="loader hide"></div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalChangeSelection" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalChangeSelectionLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex">
                    <h5 class="modal-title" id="modalChangeSelectionLabel">Chỉnh sửa lựa chọn</h5>
                    <button type="button" class="btn ml-3" title="Reset" id="reset-btn"><i class="fa fa-undo"></i></button>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body row">
                <div class="col-4">
                    <h3>Quốc gia</h3>
                    <ul class="ul-in-modal">
                        @foreach($countries as $country)
                        @if($country != null)
                        @if(in_array($country, $listDefaultCountry))
                        <li><input class="check-box-country" type="checkbox" data-id="{{ $country }}" checked disabled> {{ $country }} </li>
                        @else
                        @if(in_array($country, $listArrayCountry))
                        <li><input class="check-box-country" type="checkbox" checked data-id="{{ $country }}"> {{ $country }} </li>
                        @else
                        <li><input class="check-box-country" type="checkbox" data-id="{{ $country }}"> {{ $country }} </li>
                        @endif
                        @endif
                        @endif
                        @endforeach
                    </ul>
                </div>
                <div class="col-4">
                    <h3>Nền tảng</h3>
                    <ul class="ul-in-modal">
                        @foreach($platforms as $platform)
                        @if($platform != null)
                        @if(in_array($platform, $listDefaultPlatform))
                        <li><input class="check-box-platform" type="checkbox" data-id="{{ $platform }}" checked disabled> {{ $platform }} </li>
                        @else
                        @if(in_array($platform, $listArrayPlatform))
                        <li><input class="check-box-platform" type="checkbox" checked data-id="{{ $platform }}"> {{ $platform }} </li>
                        @else
                        <li><input class="check-box-platform" type="checkbox" data-id="{{ $platform }}"> {{ $platform }} </li>
                        @endif
                        @endif
                        @endif
                        @endforeach
                    </ul>
                </div>
                <div class="col-4">
                    <h3>Ứng dụng</h3>
                    <input class="form-control mt-2 mb-2" placeholder="Nhập tên ứng dụng" id="search-in-filter-modal" onkeypress="search()" onkeydown="search()">
                    <ul class="ul-in-modal ul-list-app-in-modal" id="ul-list-app-in-modal">
                        @foreach($apps as $app)
                        @if($app != null)
                        @if(in_array($app, $listArrayApp))
                        <li><input class="check-box-app" type="checkbox" checked data-id="{{ $app }}"> {{ $app }} </li>
                        @else
                        <li><input class="check-box-app" type="checkbox" data-id="{{ $app }}"> {{ $app }} </li>
                        @endif
                        @endif
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-lg-12 pl-3 pb-3">
                <button type="button" class="btn btn-primary" id="save-change-option">Lưu</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalReport" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalReport" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex">
                    <h5 class="modal-title" id="modalReportLabel">Thống kê</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body row">
                <div class="col-12 d-flex row">
                    <div class="col-lg-2 col-md-12">
                        <label class="form-label">Từ ngày</label>
                        <input class="form-select" type="text" id="datepicker-from">
                    </div>
                    <div class="col-lg-2 col-md-12">
                        <label class="form-label">Đến ngày</label>
                        <input class="form-select" type="text" id="datepicker-to">
                    </div>
                    <div class="col-lg-2 col-md-12">
                        <label class="form-label">Quốc gia</label>
                        <select class="form-select" id="country-report">
                            <option value="all">Tất cả</option>
                            @foreach($listArrayCountry as $country)
                            <option value="{{ $country }}">{{ $country }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-12">
                        <label class="form-label">Nền tảng</label>
                        <select class="form-select" id="platform-report">
                            <option value="all">Tất cả</option>
                            @foreach($listArrayPlatform as $platform)
                            <option value="{{ $platform }}">{{ $platform }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-12">
                        <label class="form-label">App</label>
                        <select class="form-select" id="app-name-report">
                            <option value="all">Tất cả</option>
                            @foreach($listArrayApp as $app)
                            <option value="{{ $app }}">{{ $app }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-12">
                        <label class="form-label">Keyword</label>
                        <select class="form-select" id="keyword-report">
                            <option value="all">Tất cả</option>
                            @foreach($keywords as $keyword)
                            <option value="{{ $keyword }}">{{ $keyword }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-12 mt-3">
                        <button type="button" class="btn btn-primary" onclick="getDataChart()">Thống kê</button>
                    </div>
                </div>
                <div class="col-12">
                    <div id="pre-loader">
                        @include('components.pre-loader')
                    </div>
                    <div id="text-total-modal" style="display: none; justify-content: center; margin: 10px 0;">
                        <p class="total-title">Tổng lượt cài : <span id="sum-total"></span></p>
                        <p class="total-title" style="margin-left: 15px">Tổng thành công : <span id="sum-success"></span></p>
                    </div>
                    <div class="chart-container">
                        <canvas id="countChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalActivity" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalActivity" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex">
                    <h5 class="modal-title" id="modalReportLabel">Lịch sử hoạt động</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="input-group">
                    <input type="text" id="uid-activity" class="form-control" placeholder="Nhập id device" aria-label="Nhập id device" aria-describedby="basic-addon2" require>
                    <button class="btn btn-outline-secondary ml-3" type="button" onclick="searchActivity()">Tìm kiếm</button>
                </div>
                <div class="table-responsive mt-3">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Thời gian</th>
                                <th scope="col">Hoạt động</th>
                                <th scope="col">Dữ liệu (nếu có)</th>
                            </tr>
                        </thead>
                        <tbody id="table-activity">
                        </tbody>
                    </table>
                </div>
                <div id="pre-loader-activity">
                    @include('components.pre-loader')
                </div>
                <div id="empty-result">
                    <p class="text-danger ">Không tìm thấy kết quả</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    var backToTop = document.getElementById("back-to-top");
    var chart = 'chart';
    var app = '<?php echo $filter['app']; ?>';
    var country = '<?php echo $filter['country']; ?>';
    var platform = '<?php echo $filter['platform']; ?>';
    var network = '<?php echo $filter['network']; ?>';
    var install = '<?php echo $filter['install']; ?>';
    var date = '<?php echo $filter['date']; ?>';
    var today = '<?php echo $today; ?>';
    var prevToday = '<?php echo $prevToday; ?>';
    var urlParams = new URLSearchParams(window.location.search);
    var strInPage = '';
    var statusNowDate = true;
    if (install) {
        $("#install").val(install);
        if (strInPage == '') {
            strInPage += '?install=' + install;
        } else {
            strInPage += '&install=' + install;
        }
    }
    $.fn.select2.defaults.set("theme", "bootstrap");
</script>
<script src="{{ asset('js/log-behavior.js') }}"></script>
@endsection