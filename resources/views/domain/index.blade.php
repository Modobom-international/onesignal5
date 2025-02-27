@extends('layouts.app')

@section('title', 'List Domain')

@section('styles')
<link href="{{ asset('css/domain.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="row">
    <div class="card">
        <div class="card-body">
            <div class="col-12">
                @if(Auth::user()->email == 'vutuan.modobom@gmail.com' or Auth::user()->email == 'tranlinh.modobom@gmail.com')
                <div class="d-flex mt-3 mb-3 justify-between">
                    <div>
                        <a href="{{ route('domain.create') }}" class="btn btn-success">Thêm domain</a>
                    </div>

                    <div>
                        <input id="search-domain" class="form-control" placeholder="Nhập tên domain...">
                    </div>
                </div>
                @endif

                @include('includes.table-domain')
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDetailDomain" tabindex="-1" aria-labelledby="modalDetailDomainLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetailDomainLabel">Thông tin chi tiết</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 10px 30px;">
                <ul class="area-domain-detail">
                    <li>
                        <p class="fw-bold">Domain : <span id="domain-modal" class="ml-2 fw-normal"></span></p>
                    </li>
                    <li>
                        <p class="fw-bold">Username admin : <span id="admin_username-modal" class="ml-2 fw-normal"></span></p>
                    </li>
                    <li>
                        <p class="fw-bold">Password admin : <span id="admin_password-modal" class="ml-2 fw-normal"></span></p>
                    </li>
                    <li>
                        <p class="fw-bold">Ngày tạo : <span id="created_at-modal" class="ml-2 fw-normal"></span></p>
                    </li>
                    <li>
                        <p class="fw-bold">DB name : <span id="db_name-modal" class="ml-2 fw-normal"></span></p>
                    </li>
                    <li>
                        <p class="fw-bold">DB username : <span id="db_user-modal" class="ml-2 fw-normal"></span></p>
                    </li>
                    <li>
                        <p class="fw-bold">DB password : <span id="db_password-modal" class="ml-2 fw-normal"></span></p>
                    </li>
                    <li>
                        <p class="fw-bold">Email : <span id="email-modal" class="ml-2 fw-normal"></span></p>
                    </li>
                    <li>
                        <p class="fw-bold">Người dùng FTP : <span id="ftp_user-modal" class="ml-2 fw-normal"></span></p>
                    </li>
                    <li>
                        <p class="fw-bold">Người quản lý : <span id="provider-modal" class="ml-2 fw-normal"></span></p>
                    </li>
                    <li>
                        <p class="fw-bold">Thư mục domain : <span id="public_html-modal" class="ml-2 fw-normal"></span></p>
                    </li>
                    <li>
                        <p class="fw-bold">Server : <span id="server-modal" class="ml-2 fw-normal"></span></p>
                    </li>
                    <li>
                        <p class="fw-bold">Trạng thái : <span id="status-modal" class="ml-2 fw-normal"></span></p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        var typingTimer;
        var doneTypingInterval = 500;

        $('#modalDetailDomain').off('show.bs.modal').on('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var data = JSON.parse(button.getAttribute('data-total'));

            for (var i in data) {
                var id = '#' + i + '-modal';
                $(id).text(data[i]);
            }
        });

        $('#search-domain').on('keyup', function() {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(performSearch, doneTypingInterval);
        });

        function performSearch() {
            var query = $('#search-domain').val();

            $.ajax({
                url: "{{ route('domain.search') }}",
                type: "GET",
                data: {
                    query: query
                },
                success: function(response) {
                    $('#table-domain').html(response.html);
                }
            });
        }

        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];

            $.ajax({
                url: "{{ route('domain.search') }}",
                type: "GET",
                data: {
                    query: $('#search-domain').val(),
                    page: page
                },
                success: function(response) {
                    $('#table-domain').html(response.html);
                }
            });
        });
    });
</script>
@endsection