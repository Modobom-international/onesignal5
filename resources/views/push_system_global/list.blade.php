@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.12.0/toastify.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.4.0/font/bootstrap-icons.min.css">

@endsection
<style>
    .modal p {
        word-wrap: break-word;
    }

    #set-width {
        max-width: 1200px;
    }

    .bg-surface-secondary {
        margin-top: 25px;
    }

    .icon-shape {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        vertical-align: middle;
        border-radius: .375rem;
        width: 3rem;
        height: 3rem;
    }

    .card-user {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 1px solid #eceef3;
        border-radius: .75rem;
    }

    .card-body {
        flex: 1 1 auto;
        padding: 1rem 1rem;
    }

    .table-responsive {
        margin-top: 25px;
    }

    #count_total_user {
        background-color: #3bf937;
    }

    .loading {
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.25) !important;
        text-align: center;
        padding: 100px;
        position: fixed !important;
        z-index: 9999 !important;
        color: #bd5858;
        font-size: 18px;
    }
</style>
@section('content')
</div>
<div class="container-fluid">
    <div class="row">

        {{--sidebar--}}


        {{--end sidebar--}}

        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <p>Push System Global</p>
                    <a href="{{route('addLinkSystemGlobal')}}" class="btn btn-success btn-sm" title="Add New File">
                        <i class="fa fa-plus" aria-hidden="true"></i> Add New Link Global
                    </a>
                </div>

                <!-- Banner -->

                <!-- Dashboard -->
                <div class="d-flex flex-column flex-lg-row h-lg-full bg-surface-secondary">
                    <!-- Vertical Navbar -->
                    <!-- Main content -->
                    <div class="h-screen flex-grow-1 overflow-y-lg-auto">
                        <!-- Header -->
                        <!-- Main -->
                        <main class="py-6 bg-surface-secondary">
                            <div class="container-fluid">
                                <!-- Card stats -->
                                <div class="row g-6 mb-6">
                                    <div class="col-xl-3 col-sm-6 col-12">
                                        <div class="card shadow border-0">
                                            <div class="card-body" id="count_total_user">
                                                <div class="row">
                                                    <div class="col">
                                                        <span class="h6 font-semibold text-muted text-sm d-block mb-2">Tổng User </span>
                                                        <span class="h3 font-bold mb-0">{{number_format($countUser)}}</span>
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
                                                        <span id="users_active" class="h3 font-bold mb-0">{{number_format($totalActive)}}</span>
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
                                    <img src="{{asset('img/loading.gif')}}">
                                </div>

                                <div class="table-responsive">
                                    <div id="total_users">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Country</th>
                                                    <th>Number of users</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($getDataCountries as $getCountry)
                                                <tr class="row-user">
                                                    <td> {{$getCountry->country}}</td>
                                                    <td> {{number_format($getCountry->count)}}</td>
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
                                                @foreach($getDataCountries as $getCountry)
                                                <tr class="row-user">
                                                    <td> {{$getCountry->country}}</td>
                                                    <td> {{number_format($getCountry->count)}}</td>
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
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.12.0/toastify.min.js"></script>

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
        // setInterval(loadUsersActive,  10 * 1000) ;

        // change background and list data
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
            url: '{{ route("listUserActiveGlobalAjax") }}',
            type: 'GET',
            success: function(data) {
                $('#users_active').text(new Intl.NumberFormat().format(data.total));

                $('#total_active_users table tbody').empty();
                $.each(data.usersActiveCountry, function(country, count) {
                    $('#total_active_users table tbody').append(`
                            <tr class="row-user">
                                  <td>` + country + `</td>
                                  <td>` + new Intl.NumberFormat().format(count) + `</td>
                            </tr>`);
                });
            }
        });

    }
</script>
@endsection
