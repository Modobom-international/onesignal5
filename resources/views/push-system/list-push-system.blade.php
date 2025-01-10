@extends('layouts.app')

@section('title')
List Push System
@endsection

@section('styles')
<link href="{{ asset('css/push-system.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <p>Push System</p>
            <a href="{{ route('addConfigSystemLink') }}" class="btn btn-primary btn-sm" title="Config links push">
                <i class="fa fa-gear" aria-hidden="true"></i> Config links push
            </a>
        </div>

        <div class="d-flex flex-column flex-lg-row h-lg-full bg-surface-secondary">
            <div class="h-screen flex-grow-1 overflow-y-lg-auto">
                <main class="py-6 bg-surface-secondary">
                    <div class="container-fluid">
                        <div class="row g-6 mb-6">
                            <div class="col-xl-3 col-sm-6 col-12">
                                <div class="card shadow border-0">
                                    <div class="card-body" id="count_total_user">
                                        <div class="row">
                                            <div class="col">
                                                <span class="h6 font-semibold text-muted text-sm d-block mb-2">Tổng User </span>
                                                <span class="h3 font-bold mb-0">{{ number_format($countUser) }}</span>
                                            </div>
                                            <div class="col-auto">
                                                <div class="icon icon-shape bg-primary text-white text-lg rounded-circle">
                                                    <i class="bi bi-people"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6 col-12">
                                <div class="card shadow border-0">
                                    <div class="card-body" id="count_total_user_active">
                                        <div class="row">
                                            <div class="col">
                                                <span class="h6 font-semibold text-muted text-sm d-block mb-2">Tổng User hoạt động trong ngày</span>
                                                <span id="users_active" class="h3 font-bold mb-0">{{ number_format($totalActive) }}</span>
                                            </div>
                                            <div class="col-auto">
                                                <div class="icon icon-shape bg-primary text-white text-lg rounded-circle">
                                                    <i class="bi bi-people"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="loading">
                            @include('components.pre-loader')
                        </div>

                        <div cl1ass="table-responsive">
                            <div id="total_users">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Country</th>
                                            <th>Number of users</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($activeByCountry as $country => $total)
                                        <tr class="row-user">
                                            <td> {{ $country }}</td>
                                            <td> {{ number_format($total) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div id="total_active_users" style="display: none;">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Country</th>
                                            <th>Number of users</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($activeByCountry as $country => $total)
                                        <tr class="row-user">
                                            <td> {{ $country }}</td>
                                            <td> {{ number_format($total) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#total_active_users').hide();
        $(".loading").hide();

        $(document).ajaxStart(function() {
            $(".loading").show();
        });

        $(document).ajaxStop(function() {
            $(".loading").hide();
        });

        $(document).ajaxError(function() {
            $(".loading").hide();
        });
        setInterval(loadUsersActive, 30000);
        $("#count_total_user").click(function() {
            $("#count_total_user").css("background-color", "#3bf937");
            $("#count_total_user_active").css("background-color", "white");
            location.reload();
        });

        $("#count_total_user_active").click(function() {
            $("#count_total_user_active").css("background-color", "#3bf937");
            $("#count_total_user").css("background-color", "white");
            $('#user-table tbody').empty();
            $('#total_users').hide();
            $('#total_active_users').show();
            loadUsersActive();
            setInterval(loadUsersActive, 30000);
        });

    });

    function loadUsersActive() {
        $.ajax({
            url: '{{ route("listUserActiveAjax") }}',
            type: 'GET',
            success: function(data) {
                $('#users_active').text(new Intl.NumberFormat().format(data.total));
                $('#total_active_users table tbody').empty();
                $.each(data.usersActiveCountry, function(key, record) {
                    var split = record.key.split("_");
                    var country = split[6];
                    $('#total_active_users table tbody').append(`
                            <tr class="row-user">
                                  <td>` + country + `</td>
                                  <td>` + new Intl.NumberFormat().format(record.total) + `</td>
                            </tr>`);
                });
            }
        });
    }
</script>
@endsection