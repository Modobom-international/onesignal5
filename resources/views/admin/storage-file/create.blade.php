@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous"/>
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

        .toast + .toast {
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
                <div class="card">
                    <div class="card-header">Create New File</div>
                    <div class="card-body"><a href="{{route('listFile')}}" title="Back">
                            <button class="btn btn-warning btn-sm"><i aria-hidden="true" class="fa fa-arrow-left"></i> Back</button>
                        </a> <br> <br>
                        <form method="POST" method="POST" action="{{ route('storeFile')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="id" class="control-label">Version</label>
                                <input  autocomplete="off"  name="version" type="text" id="id" class="form-control">
                                @if ($errors->has('version'))
                                    <span class="text-danger">{{ $errors->first('version') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="id" class="control-label">URL</label>
                                <input  autocomplete="off" name="url" type="file" id="id" class="form-control">
                                @if ($errors->has('url'))
                                    <span class="text-danger">{{ $errors->first('url') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="id" class="control-label">Changelog</label>
                                <input  autocomplete="off" name="changelog" type="text" id="id" class="form-control">
                                @if ($errors->has('changelog'))
                                    <span class="text-danger">{{ $errors->first('changelog') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="id" class="control-label">App</label>
                                <input  autocomplete="off" name="app_id" type="text" id="id" class="form-control">
                                @if ($errors->has('app_id'))
                                    <span class="text-danger">{{ $errors->first('app_id') }}</span>
                                @endif
                            </div>
                            <div class="form-group"><label for="region" class="control-label">Mandatory</label> <select  id="region" name="mandatory" class="form-control">
                                    <option value="" selected="selected">-- Select Mandatory--</option>
                                    <option value="true">True</option>
                                    <option value="false">False</option>
                                </select>
                                @if ($errors->has('mandatory'))
                                    <span class="text-danger">{{ $errors->first('mandatory') }}</span>
                                @endif
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="btn btn-success me-2">{{ __('Save') }}</button>
                                <button type="reset" class="btn btn-outline-secondary">{{ __('Reset') }}</button>
                            </div>
                        </form>
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
