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
    </style>
@endsection
@section('content')
    <div id="alert-device-status">
    </div>
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Edit Config Link Global</div>
                    <div class="card-body"><a href="{{route('listPushSystem')}}" title="Back">
                            <button class="btn btn-warning btn-sm"><i aria-hidden="true" class="fa fa-arrow-left"></i> Back</button>
                        </a> <br> <br>
                        <form method="POST" method="POST" action="{{route('saveSystemConfigGlobal')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="status" class="control-label">Status</label>
                                <select required="required" id="status" name="status" value="{{ $dataSystem->status }}" class="form-control">
                                    @foreach($status as $type => $value)
                                        <option value="{{ $type }}" {{$type == $dataSystem->status  ? 'selected' : ''}}>{{ $value }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('status'))
                                    <span class="text-danger">{{ $errors->first('status') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="id" class="control-label">Type</label>
                                <input  autocomplete="off"  name="type" value="{{$dataSystem->type ?? null}}" type="text" id="id" class="form-control">
                                @if ($errors->has('type'))
                                    <span class="text-danger">{{ $errors->first('type') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="id" class="control-label">Share Web</label>
                                <input  autocomplete="off"  name="share" value="{{$dataSystem->share ?? null}}" type="text" id="id" class="form-control">
                                @if ($errors->has('share'))
                                    <span class="text-danger">{{ $errors->first('share') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="link_web_1" class="control-label">Link Web 1</label>
                                <textarea rows="10" id="link_web_1" name="link_web_1"  class="form-control">{{$strLink1 ?? null}}</textarea>
                                @if ($errors->has('link_web_1'))
                                    <span class="text-danger">{{ $errors->first('link_web_1') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="link_web_2" class="control-label">Link Web 2</label>
                                <textarea rows="10" id="link_web_2" name="link_web_2"  class="form-control">{{ $strLink2 ?? null}}</textarea>
                                @if ($errors->has('link_web_2'))
                                    <span class="text-danger">{{ $errors->first('link_web_2') }}</span>
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
