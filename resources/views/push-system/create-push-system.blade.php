@extends('layouts.app')

@section('title')
Create push system
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

    .text-danger {
        color: red;
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
                            <a class="nav-link" href="{{ route('push.system.list') }}">Push System</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Edit Config</div>
                <div class="card-body"><a href="{{ route('push.system.list') }}" title="Back">
                        <button class="btn btn-warning btn-sm"><i aria-hidden="true" class="fa fa-arrow-left"></i> Back</button>
                    </a> <br> <br>
                    <form method="POST" method="POST" action="{{ route('saveSystemConfigGlobal') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="id" class="control-label">Share Web</label>
                            <input autocomplete="off" name="share_web" value="{{ $dataSystem->share_web ?? null }}" type="number" id="id" class="form-control">
                            @if ($errors->has('share_web'))
                            <span class="text-danger">{{ $errors->first('share_web') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="link_web_1" class="control-label">Link Web 1</label>
                            <textarea rows="20" id="link_web_1" name="link_web_1" class="form-control">{{ $strLink1 ?? null }}</textarea>
                            @if ($errors->has('link_web_1'))
                            <span class="text-danger">{{ $errors->first('link_web_1') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="link_web_2" class="control-label">Link Web 2</label>
                            <textarea rows="20" id="link_web_2" name="link_web_2" class="form-control">{{ $strLink2 ?? null }}</textarea>
                            @if ($errors->has('link_web_2'))
                            <span class="text-danger">{{ $errors->first('link_web_2') }}</span>
                            @endif
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-success me-2">{{ __('Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
