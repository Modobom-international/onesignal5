@extends('layouts.app')

@section('title', 'List Domain')

@section('styles')
<link href="{{ asset('css/domain.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex mt-3 mb-3">
            <a href="{{ route('domain.create') }}" class="btn btn-success">Thêm domain</a>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Domain</th>
                                <th>Ngày tạo</th>
                                <th>Server</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($domains as $domain)
                            <tr>
                                <td>{{ $domain->domain }}</td>
                                <td>{{ $domain->created_at }}</td>
                                <td>{{ $domain->server }}</td>
                                <td><button class="btn btn-success">Chi tiết</button></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection