@extends('layouts.app')

@section('title')
Show Config
@endsection

@section('styles')
<style>
    table td {
        word-wrap: break-word;
        overflow-wrap: break-word;
    }

    .copy-to-clipboard {
        margin-left: 10px;
        cursor: pointer;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">
            <div class="card">
                <div class="card-header">Menu</div>
                <div class="card-body">
                    <ul class="nav flex-column" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" href="/push-system">Push System</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-10">
            @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
            @endif
            <div class="card">
                <div class="card-header">Show Config</div>
                <div class="card-body">
                    <a href="{{ route('listPushSystem') }}" title="Back">
                        <button class="btn btn-warning btn-sm"><i aria-hidden="true" class="fa fa-arrow-left"></i> Back</button>
                    </a>
                    <a href="{{ route('PushSystemConfigLinksPush') }}" title="Back">
                        <button class="btn btn-primary btn-sm"><i aria-hidden="true"></i> Edit Config</button>
                    </a>
                    <br> <br>

                    <div class="form-group">
                        <label for="id" class="control-label">Share Web</label>
                        <input readonly autocomplete="off" name="share_web" value="{{$dataConfig->share_web}}" type="text" id="id" class="form-control">
                        @if ($errors->has('share_web'))
                        <span class="text-danger">{{ $errors->first('share_web') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="link_web_1" class="control-label">Link Web 1</label>
                        <textarea readonly rows="10" id="link_web_1" name="link_web_1" class="form-control"> {{ ($strLink1) }}</textarea>
                        @if ($errors->has('link_web_1'))
                        <span class="text-danger">{{ $errors->first('link_web_1') }}</span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="link_web_2" class="control-label">Link Web 2</label>
                        <textarea readonly rows="10" id="link_web_2" name="link_web_2" class="form-control">{{ ($strLink2) }}</textarea>
                        @if ($errors->has('link_web_2'))
                        <span class="text-danger">{{ $errors->first('link_web_2') }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
