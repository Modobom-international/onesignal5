@extends('layouts.app')

@section('title')
Users tracking
@endsection

@section('styles')
<link href="{{ asset('css/users-tracking.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <label class="form-label badge text-bg-primary" for="domain">Chọn domain</label>
                <select class="form-control" id="domain">
                    <option value="apkafe.com">apkafe.com</option>
                    <option value="vnitourist.com">vnitourist.com</option>
                    <option value="vnifood.com">vnifood.com</option>
                    <option value="betonamuryori.com">betonamuryori.com</option>
                    <option value="lifecompass365.com">lifecompass365.com</option>
                </select>
            </div>

            <div class="form-group mt-3 mb-3">
                <button class="btn btn-primary" onclick="">Chọn</button>
            </div>

            <hr>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Thời gian cuối cùng</th>
                            <th scope="col">Địa chỉ IP</th>
                            <th scope="col">Thiết bị</th>
                            <th scope="col">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $uuid => $record)
                        <tr>
                            <th scope="row">{{ $uuid }}</th>
                            <td>{{ $record[0]->timestamp }}</td>
                            <td>{{ $record[0]->ip }}</td>
                            <?php if ($record[0]->screen_width <= 576) { ?>
                                <td>Mobile</td>
                            <?php } else if ($record[0]->screen_width > 577 and $record[0]->screen_width <= 1024) { ?>
                                <td>Tablet</td>
                            <?php } else { ?>
                                <td>Laptop, PC or TV</td>
                            <?php } ?>
                            <td>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-uuid="{{ $uuid }}" data-bs-target="#detailModal">Chi tiết</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div>
                {{ $data->links() }}
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" id="set-width">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fw-bold" id="detailModalLabel">Detail <span id="uuid-modal"></span></h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <h5 class="fw-bold">Thông tin cơ bản</h5>
                        <div class="form-group">
                            <p>Địa chỉ IP : <span id="ip-modal"></span></p>
                            <p>Trình duyệt : <span id="browser-modal"></span></p>
                            <p>Hệ thống : <span id="os-modal"></span></p>
                            <p>Thiết bị : <span id="device-modal"></span></p>
                            <p>Click vào internal link : <span id="internal-modal"></span></p>
                            <p>Click vào lasso button : <span id="lasso-modal"></span></p>
                        </div>
                    </div>
                </div>

                <div class="loading">
                    @include('components.pre-loader')
                </div>

                <div id="activity-modal">

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $('#detailModal').on('show.bs.modal', function(e) {
        var uuid = $(e.relatedTarget).data('uuid');
        $(".loading").show();

        $.ajax({
            url: '/admin/get-detail-tracking',
            type: 'GET',
            data: {
                uuid: uuid
            },
            success: function(response) {
                $(".loading").hide();
                $('#activity-modal').empty();
                $('#uuid-modal').text(uuid);
                $('#ip-modal').text(response.ip);
                $('#browser-modal').text(response.browser);
                $('#os-modal').text(response.os);
                $('#device-modal').text(response.device);
                if (response.is_lasso_button == 1) {
                    $('#lasso-modal').text('Có');
                } else {
                    $('#lasso-modal').text('Không');
                }

                if (response.is_internal_link == 1) {
                    $('#internal-modal').text('Có');
                } else {
                    $('#internal-modal').text('Không');
                }

                for (let path in response.activity) {
                    let heat_map = '';
                    let activity = response.activity[path];
                    let get_heat_map = response.heat_map[path];
                    if (get_heat_map == undefined) {
                        heat_map = 'Không có dữ liệu';
                    } else if (get_heat_map.length == 0) {
                        heat_map = 'Không có dữ liệu';
                    } else {
                        for (let i = 0; i < get_heat_map.length; i++) {
                            heat_map += get_heat_map[i] + ', ';
                        }
                    }

                    let html = '<div class="card mt-3"><div class="card-body"><h5 class="mb-3">' + path + '</h5><hr><ul>';
                    for (let i = 0; i < activity.length; i++) {
                        html += '<li><p>' + activity[i] + '</p></li>';
                    }
                    html += '</ul>';
                    html += '<div><p>Heat map - ' + heat_map + '</p></div>';
                    html += '</div></div>';
                    $('#activity-modal').append(html);
                }
            }
        });
    });
</script>
@endsection