@extends('layouts.app')

@section('title', 'List Domain')

@section('styles')
<link href="{{ asset('css/domain.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        @if(Auth::user()->email == 'vutuan.modobom@gmail.com' or Auth::user()->email == 'tranlinh.modobom@gmail.com')
        <div class="d-flex mt-3 mb-3">
            <a href="{{ route('domain.create') }}" class="btn btn-success">Thêm domain</a>
        </div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Domain</th>
                                <th>Server</th>
                                <th>Tài khoản</th>
                                <th>Mật khẩu</th>
                                <th>Quản lý</th>
                                <th>Ngày tạo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($domains as $domain)
                            <tr>
                                <td>{{ $domain->domain }}</td>
                                <td>{{ \App\Enums\ListServer::SERVER[$domain->server] }}</td>
                                <td>{{ $domain->admin_username }}</td>
                                <td>{{ $domain->admin_password }}</td>
                                <td>{{ $domain->email ?? '' }}</td>
                                <td>{{ $domain->created_at }}</td>
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