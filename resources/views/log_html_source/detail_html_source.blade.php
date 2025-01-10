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
        <div class="card-header">HTML Source {{ $dataHtmlSource->id }}</div>
        <div class="card-body">
            <a href="{{ route('listHtmlSource') }}" title="Back">
                <button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i>
                    Back
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
                            <th>URL</th>
                            <td> {{ $dataHtmlSource->url }} </td>
                        </tr>
                        <tr>
                            <th>Country</th>
                            <td> {{ $dataHtmlSource->country }} </td>
                        </tr>
                        <tr>
                            <th>Platform</th>
                            <td> {{ $dataHtmlSource->platform }} </td>
                        </tr>
                        <tr>
                            <th>App</th>
                            <td> {{ $dataHtmlSource->app_id }} </td>
                        </tr>
                        <tr>
                            <th>Source</th>
                            <td> {{ $dataHtmlSource->source }} </td>
                        </tr>
                        <tr>
                            <th>Version</th>
                            <td> {{ $dataHtmlSource->version }} </td>
                        </tr>
                        <tr>
                            <th>Note</th>
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