@extends('layouts.app')

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
                <div class="card-header">Show Config Link Global</div>
                <div class="card-body">
                    <a href="{{route('listPushSystemGlobal')}}" title="Back">
                        <button class="btn btn-warning btn-sm"><i aria-hidden="true" class="fa fa-arrow-left"></i> Back</button>
                    </a>
                    <a href="{{route('addLinkSystemGlobal')}}" title="Back">
                        <button class="btn btn-primary btn-sm"><i aria-hidden="true"></i> Edit Config Link Global</button>
                    </a>
                    <br> <br>
                    <div class="form-group">
                        <label for="id" class="control-label">Status</label>
                        <input readonly autocomplete="off" name="status" value="{{ $dataConfig->status }}" type="text" id="id" class="form-control">
                        @if ($errors->has('status'))
                        <span class="text-danger">{{ $errors->first('status') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="id" class="control-label">Type</label>
                        <input readonly autocomplete="off" name="type" value="{{ $dataConfig->type }}" type="text" id="id" class="form-control">
                        @if ($errors->has('type'))
                        <span class="text-danger">{{ $errors->first('type') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="id" class="control-label">Share Web</label>
                        <input readonly autocomplete="off" name="share" value="{{ $dataConfig->share }}" type="text" id="id" class="form-control">
                        @if ($errors->has('share'))
                        <span class="text-danger">{{ $errors->first('share') }}</span>
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