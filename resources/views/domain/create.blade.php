@extends('layouts.app')

@section('title', 'Create Domain')

@section('styles')
<link href="{{ asset('css/domain.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <input class="form-control" type="text" id="domain" placeholder="Nhập domain">
                <button class="btn btn-primary mt-3" onclick="checkDomain()">{{ __('Kiểm tra') }}</button>
            </div>
        </div>

        <div class="card mt-4 position-relative">
            <div class="overlay"></div>
            <div class="card-body">
                <div class="form-group">
                    <div class="mb-3">
                        <label for="server" class="form-label">{{ __('Chọn máy chủ') }}</label>
                        <select class="form-control" id="server">
                            <option value="services.ip_server.wp1">{{ __('Máy chủ WP1') }}</option>
                            <option value="services.ip_server.wp2">{{ __('Máy chủ WP2') }}</option>
                            <option value="services.ip_server.wp3">{{ __('Máy chủ WP3') }}</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <button class="btn btn-success" id="up-domain">{{ __('Tạo tên miền') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-lg fade" id="upDomainModal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="upDomainModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="upDomainModalLabel">{{ __('Tiến hành khởi tạo tên miền') }}</h5>
                <div id="pre-loader" class="ml-4">
                    @include('components.pre-loader')
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="area-log">

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        var upDomainModal = new bootstrap.Modal(document.getElementById('upDomainModal'), {
            keyboard: false,
            backdrop: 'static'
        });

        var stringArray = {
            'process-1': ' 🔄 Bắt đầu tiến hành thêm domain vào Cloudflare....',
            'process-2': ' 🔄 Bắt đầu tiến hành đổi nameserver trên Godaddy....',
            'process-3': ' 🔄 Bắt đầu tiến hành thêm DNS trên Cloudflare....',
            'process-4': ' 🔄 Bắt đầu tiến hành khởi tạo website....',
            'process-5': ' 🔄 Bắt đầu tiến hành tạo logo cho domain....',
            'process-6': ' 🔄 Bắt đầu tiến hành lưu trữ dữ liệu domain....',
        };

        $("#domain").on("input", function() {
            $('.overlay').show();
        });

        $("#domain").focusin(function() {
            $('.overlay').show();
        });

        document.getElementById('upDomainModal').addEventListener('hidden.bs.modal', function() {
            $("#pre-loader").show();
            $('.overlay').show();
        });

        $('#up-domain').on('click', function() {
            var domain = document.getElementById('domain').value;
            var server = document.getElementById('server').value;

            $.ajax({
                url: '/admin/up-domain',
                type: 'GET',
                data: {
                    domain: domain,
                    server: server
                },
                success: function(response) {
                    for (var i in stringArray) {
                        if (i == 'process-1') {
                            $("#area-log").append(`<p id="${i}">${stringArray[i]}</p>`);
                        } else {
                            $("#area-log").append(`<p class="hide" id="${i}">${stringArray[i]}</p>`);
                        }
                    }

                    upDomainModal.show();
                }
            });
        });

        Echo.channel("up-domain").listen("UpDomainDump", (e) => {
            $("#pre-loader").attr("style", "display: none !important");
            const data = e.data;
            let logEntry = $("#" + data.id);
            let split = data.id.split('-');
            let numberIndex = split[1];
            let nextID = parseInt(numberIndex) + 1;
            let nextLogEntry = $("#process-" + nextID);

            if (logEntry.length === 0) {
                $("#area-log").append(`<p id="${data.id}">${data.message}</p>`);
            } else {
                logEntry.html(data.message);
            }

            nextLogEntry.removeClass('hide');
            $("#area-log").scrollTop($("#area-log")[0].scrollHeight);
        });
    });

    function checkDomain() {
        var domain = document.getElementById('domain').value;
        if (domain == '') {
            toastr.error('Domain không được để trống');
            $('.overlay').show();
            return;
        }

        $.ajax({
            url: '/admin/check-domain',
            type: 'GET',
            data: {
                domain: domain
            },
            success: function(response) {
                if (response.status == 0) {
                    toastr.error(response.message);
                    $('.overlay').show();
                } else {
                    toastr.success(response.message);
                    $('.overlay').hide();
                }
            },
            error: function(error) {
                toastr.error(response.message);
                $('.overlay').hide();
            }
        });
    }
</script>
@endsection