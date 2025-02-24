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
                                <th>Hành động</th>
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
                                <td><button class="btn" data-bs-toggle="modal" data-total="[]" data-bs-target="#modalDetail"><i class="fa fa-info-circle"></i></button></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetailLabel">Thông tin chi tiết</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="area-domain-detail">

                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        var detailDomainModal = new bootstrap.Modal(document.getElementById('upDomainModal'), {
            keyboard: false,
            backdrop: 'static'
        });

        detailDomainModal.addEventListener('show.bs.modal', function(event) {
            var myBookId = $(this).data('id');
            $(".modal-body #bookId").val(myBookId);
        })
    });
</script>
@endsection