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
            <div class="row">
                <div class="col-3 form-group mt-3">
                    <label class="form-label badge text-bg-primary" for="domain">Chọn domain</label>
                    <select class="form-control" id="domain">
                        <option value="apkafe.com">apkafe.com</option>
                        <option value="vnitourist.com">vnitourist.com</option>
                        <option value="vnifood.com">vnifood.com</option>
                        <option value="betonamuryori.com">betonamuryori.com</option>
                        <option value="lifecompass365.com">lifecompass365.com</option>
                    </select>
                </div>

                <div class="col-3 form-group mt-3 mb-3">
                    <label class="form-label badge text-bg-primary" for="date">Chọn ngày</label>
                    <input type="date" class="form-control" id="date" value="{{ date('Y-m-d') }}">
                </div>

                <div class="col-3 form-group d-flex align-items-center margin-top-1-7">
                    <button class="btn btn-primary" onclick="">Tìm</button>
                </div>
            </div>

            <div class="form-group mt-3 mb-3">
                <button class="btn btn-success" id="btn-heat-map" data-bs-toggle="modal" data-bs-target="#heatMapModal">Xem heat map</button>
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
                <div class="card" id="basic-info-modal">
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

<div class="modal fade" id="heatMapModal" tabindex="-1" aria-labelledby="heatMapModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" id="set-width">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fw-bold" id="heatMapModalLabel">Heat map</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card" id="card-in-heat-map-modal">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3 form-group mt-3">
                                <label class="form-label badge text-bg-primary" for="domain-heat-map-modal">Chọn domain</label>
                                <select class="form-control" id="domain-heat-map-modal">
                                    <option value="apkafe.com">apkafe.com</option>
                                    <option value="vnitourist.com">vnitourist.com</option>
                                    <option value="vnifood.com">vnifood.com</option>
                                    <option value="betonamuryori.com">betonamuryori.com</option>
                                    <option value="lifecompass365.com">lifecompass365.com</option>
                                </select>
                            </div>

                            <div class="col-3 form-group mt-3">
                                <label class="form-label badge text-bg-primary" for="path-heat-map-modal">Chọn path</label>
                                <select class="form-control" id="path-heat-map-modal">
                                </select>
                            </div>

                            <div class="col-3 form-group mt-3 mb-3">
                                <label class="form-label badge text-bg-primary" for="date-heat-map-modal">Chọn ngày</label>
                                <input type="date" class="form-control" id="date-heat-map-modal" value="{{ date('Y-m-d') }}">
                            </div>

                            <div class="col-3 form-group mt-3">
                                <label class="form-label badge text-bg-primary" for="event-heat-map-modal">Chọn sự kiện</label>
                                <select class="form-control" id="event-heat-map-modal">
                                    <option value="mousemove">Mouse move</option>
                                    <option value="click">Click</option>
                                </select>
                            </div>

                            <div class="col-3 form-group d-flex align-items-center margin-top-1-7">
                                <button class="btn btn-primary" id="choose-heat-map">Chọn</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="loading">
                    @include('components.pre-loader')
                </div>

                <div class="area-heat-map">
                    <iframe id="heatmapiframe" width="800" frameborder="0" scrolling="no"></iframe>
                    <div id="heatmap"></div>
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
<script src="https://cdn.jsdelivr.net/npm/heatmap.js@2.0.5/build/heatmap.min.js"></script>
<script>
    var heatmapInstance = null;
    var isFetching = false;
    var domainGernal = '';

    const iframe = document.getElementById('heatmapiframe');
    const container = document.getElementById('heatmap');
    const heatmapLayer = $('#heatmap');
    const heatmapIframe = $('#heatmapiframe');

    $('#detailModal').on('show.bs.modal', function(e) {
        if (isFetching) return
        isFetching = true;
        var uuid = $(e.relatedTarget).data('uuid');
        $(".loading").show();
        $('#activity-modal').empty();
        $('#basic-info-modal').hide();

        $.ajax({
            url: '{{ route("getDetailTracking") }}',
            type: 'GET',
            data: {
                uuid: uuid
            },
            success: function(response) {
                $(".loading").hide();
                $('#basic-info-modal').show();
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
                    let activity = response.activity[path];

                    let html = '<div class="card mt-3"><div class="card-body"><h5 class="mb-3">' + path + '</h5><hr><ul>';
                    for (let i = 0; i < activity.length; i++) {
                        html += '<li><p>' + activity[i] + '</p></li>';
                    }
                    html += '</ul>';
                    html += '</div></div>';
                    $('#activity-modal').append(html);
                }
            }
        });
    });

    $('#detailModal').on('hidden.bs.modal', function() {
        isFetching = false;
    });

    $('#heatMapModal').on('show.bs.modal', function(e) {
        $('#card-in-heat-map-modal').hide();
        $('.area-heat-map').hide();
        $.ajax({
            url: '{{ route("getLinkForHeatMap") }}',
            type: 'GET',
            success: function(response) {
                for (let i = 0; i < response.length; i++) {
                    $('#path-heat-map-modal').append('<option value="' + response[i] + '">' + response[i] + '</option>');
                }
                $(".loading").hide();
                $('#card-in-heat-map-modal').show();
            }
        });
    });

    $('#choose-heat-map').on('click', function() {
        $(".loading").show();
        $('.area-heat-map').hide();
        var domain = $('#domain-heat-map-modal').val();
        var path = $('#path-heat-map-modal').val();
        var date = $('#date-heat-map-modal').val();
        var event = $('#event-heat-map-modal').val();

        domainGernal = domain;
        $.ajax({
            url: '{{ route("getHeatMap") }}',
            type: 'GET',
            data: {
                domain: domain,
                path: path,
                date: date,
                event: event
            },
            success: function(response) {
                var url = 'https://' + domain + path;
                var data = [];
                $('#heatmapiframe').attr('style', 'height: ' + response.height + 'px ' + '!important');
                $('#heatmap').attr('style', 'height: ' + response.height + 'px ' + '!important');

                for (let i in response.data) {
                    data.push({
                        x: response.data[i].x,
                        y: response.data[i].y,
                        value: response.data[i].value
                    });
                }

                handleIframe(url, data);
            }
        });
    });

    function handleIframe(url, data) {
        iframe.src = url;

        iframe.onload = function() {
            createHeatmap(data);
        };
    }

    function createHeatmap(data) {
        if (heatmapInstance) {
            heatmapLayer.empty();
        }

        heatmapInstance = h337.create({
            container: container,
            radius: 30,
            maxOpacity: 0.2,
            minOpacity: 0,
            blur: 0.2,
            gradient: {
                0.4: "blue",
                0.6: "green",
                0.8: "yellow",
                1.0: "red"
            }
        });

        heatmapInstance.setData({
            max: 10,
            data: data
        });

        $(".loading").hide();
        $('.area-heat-map').show();
    }
</script>
@endsection