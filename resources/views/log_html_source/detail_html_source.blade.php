@extends('layouts.app')

@section('title')
Detail HTML Source
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fastselect/0.7.3/fastselect.min.css">
<style>
    table li {
        padding: 10px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">{{ __('Chi tiết nguồn HTML') }} {{ $dataHtmlSource->id }}</div>
        <div class="card-body">
            <a href="{{ route('html.source.list') }}" title="Back">
                <button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i>
                    {{ __('Quay lại') }}
                </button>
            </a>

            <br />

            <div class="table-responsive">
                <table class="table">
                    <tbody>
                        <tr>
                            <th style="width: 160px;">ID</th>
                            <td>{{ $dataHtmlSource->id }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('Đường dẫn') }}</th>
                            <td> {{ $dataHtmlSource->url }} </td>
                        </tr>
                        <tr>
                            <th>{{ __('Quốc gia') }}</th>
                            <td> {{ $dataHtmlSource->country }} </td>
                        </tr>
                        <tr>
                            <th>{{ __('Nền tảng') }}</th>
                            <td> {{ $dataHtmlSource->platform }} </td>
                        </tr>
                        <tr>
                            <th>{{ __('Ứng dụng') }}</th>
                            <td> {{ $dataHtmlSource->app_id }} </td>
                        </tr>
                        <tr>
                            <th>{{ __('Nguồn') }}</th>
                            <td> {{ $dataHtmlSource->source }} </td>
                        </tr>
                        <tr>
                            <th>{{ __('Phiên bản') }}</th>
                            <td> {{ $dataHtmlSource->version }} </td>
                        </tr>
                        <tr>
                            <th>{{ __('Ghi chú') }}</th>
                            <td> {{ $dataHtmlSource->note }} </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/fastselect/0.7.3/fastselect.standalone.min.js"></script>
@endsection