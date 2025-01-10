@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<style>
    table td {
        word-wrap: break-word;
        overflow-wrap: break-word;
    }

    .copy-to-clipboard {
        margin-left: 10px;
        cursor: pointer;
    }

    /* ======= Toast message ======== */

    #toast {
        position: fixed;
        top: 32px;
        right: 32px;
        z-index: 999999;
    }

    .toast {
        display: flex;
        align-items: center;
        background-color: #fff;
        border-radius: 2px;
        padding: 20px 0;
        min-width: 400px;
        max-width: 450px;
        border-left: 4px solid;
        box-shadow: 0 5px 8px rgba(0, 0, 0, 0.08);
        transition: all linear 0.3s;
    }

    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(calc(100% + 32px));
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes fadeOut {
        to {
            opacity: 0;
        }
    }

    .toast--success {
        border-color: #47d864;
    }

    .toast--success .toast__icon {
        color: #47d864;
    }

    .toast--info {
        border-color: #2f86eb;
    }

    .toast--info .toast__icon {
        color: #2f86eb;
    }

    .toast--warning {
        border-color: #ffc021;
    }

    .toast--warning .toast__icon {
        color: #ffc021;
    }

    .toast--error {
        border-color: #ff623d;
    }

    .toast--error .toast__icon {
        color: #ff623d;
    }

    .toast+.toast {
        margin-top: 24px;
    }

    .toast__icon {
        font-size: 24px;
    }

    .toast__icon,
    .toast__close {
        padding: 0 16px;
    }

    .toast__body {
        flex-grow: 1;
    }

    .toast__title {
        font-size: 16px;
        font-weight: 600;
        color: #333;
    }

    .toast__msg {
        font-size: 14px;
        color: #888;
        margin-top: 6px;
        line-height: 1.5;
    }

    .toast__close {
        font-size: 20px;
        color: rgba(0, 0, 0, 0.3);
        cursor: pointer;
    }
</style>
@endsection

@section('content')
<div id="alert-device-status">
</div>
<div class="container-fluid">
    <div class="row">


        <div class="col-md-10">
            @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <p>Storage File</p>
                    <a href="{{ url('/create-file') }}" class="btn btn-success btn-sm" title="Add New File">
                        <i class="fa fa-plus" aria-hidden="true"></i> Add New
                    </a>
                    <div id="toast"></div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Version</th>
                                    <th>URL</th>
                                    <th>ChangeLog</th>
                                    <th>App</th>
                                    <th>Mandatory</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach( $files as $file)
                                <tr>
                                    <td>{{ $file->version }}</td>
                                    <td>{{ $file->url }}</td>
                                    <td>{{ $file->changelog }}</td>
                                    <td>{{ $file->app_id }}</td>
                                    <td>{{ $file->mandatory }}</td>
                                    <td>
                                        <a href="{{route('showFile',$file->id)}}">
                                            <button type="button" class="btn btn-secondary">{{ __('Show') }}</button>
                                        </a>
                                        <a href="{{route('editFile',$file->id)}}">
                                            <button type="button" class="btn btn-primary">{{ __('Edit') }}</button>
                                        </a>
                                        <a href="{{route('getFileXML',$file->app_id)}}">
                                            <button type="button" class="btn btn-warning">{{ __('ShowXML') }}</button>
                                        </a>
                                        <button type="button" class="btn btn-danger " data-toggle="modal" data-target="#yourModal">{{ __('Delete') }}</button>
                                    </td>
                                </tr>
                                <div class="modal fade" id="yourModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteConfirmLabel">Xác nhận xóa</h5>
                                            </div>
                                            <div class="modal-body">
                                                Bạn có muốn xóa không ?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <a href="{{route('deleteFile',$file->id)}}"> <button type="button" class="btn btn-primary">Delete</button></a>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @endforeach
                            </tbody>
                        </table>
                        <div class="pagination"> {!! $files->appends(['search' => Request::get('search')])->render() !!} </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
@endsection
