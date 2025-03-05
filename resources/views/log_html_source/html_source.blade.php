@extends('layouts.app')

@section('title', 'Log HTML Source')

@section('styles')
<link href="{{ asset('css/html-source.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <p>HTML Source</p>
        </div>

        <div class="card-body">
            <div class="row mb-3">
                <div class="col-lg-2 col-md-12">
                    <label>Ngày</label>
                    <input class="form-control" type="text" id="datepicker">
                </div>

                <div class="col-lg-2 col-md-12">
                    <label>Ứng dụng</label>
                    <select class="form-control" id="app-name">
                        <option value="all">Tất cả</option>
                        @foreach($apps as $appItem)
                        @if($appItem->app_id != '')
                        <option @if($app==$appItem->app_id) selected @endif value="{{ $appItem->app_id }}">{{ $appItem->app_id }}</option>
                        @endif
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-2 col-md-12">
                    <label>Quốc gia</label>
                    <select class="form-control" id="country-name">
                        <option value="all">Tất cả</option>
                        @foreach($countries as $countryItem)
                        @if($countryItem->country != '')
                        <option @if($country==$countryItem->country) selected @endif value="{{ $countryItem->country  }}">{{ $countryItem->country  }}</option>
                        @endif
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-2 col-md-12">
                    <label> Thiết bị</label>
                    <input value="{{ $device }}" class="form-control" type="text" id="text-device">
                </div>

                <div class="col-lg-2 col-md-12">
                    <label>Từ khóa source</label>
                    <input value="{{ $textSource }}" class="form-control" type="text" id="text-source">
                </div>

                <div class="col-lg-2 col-md-12">
                    <button type="button" class="btn btn-primary" style="margin-top: 30px; margin-bottom: 30px;" id="search-report">{{ __('Tìm kiếm') }}</button>
                </div>
            </div>

            <div>
                <b>{{ __('Tổng') }} : <span style="color: red;">{{ $count }}</span></b>
            </div>
            <div class="table-responsive">
                <table class="table table-responsive" id="item-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>{{ __('Đường dẫn') }}</th>
                            <th>{{ __('Quốc gia') }}</th>
                            <th>{{ __('Nền tảng') }}</th>
                            <th>{{ __('Thiết bị') }}</th>
                            <th>{{ __('Nguồn') }}</th>
                            <th>{{ __('ID ứng dụng') }}</th>
                            <th>{{ __('Phiên bản') }}</th>
                            <th>{{ __('Ngày tạo') }}</th>
                            <th>{{ __('Ghi chú') }}</th>
                            <th>{{ __('Hành động') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dataPaginate as $source)
                        <tr id="row-sim-social-">
                            <td>{{ $source->id }}</td>
                            <td>{{ Str::limit($source->url, 100) }}</td>
                            <td>{{ $source->country ?? "" }}</td>
                            <td>{{ $source->platform ?? "" }}</td>
                            <td>{{ $source->device_id ?? "" }}</td>
                            <td id="source-with-{{ $source->id }}"><button data-type="email" id="element_html" class="email">{{ $source->source }}</button>
                                {{ Str::limit($source->source, 100) }}
                                @if($source->source != null)
                                <span data-type="copy" class="msgRow copy-to-clipboard"><img src="{{ asset('img/copy.png') }}" width="15" height="15">
                                </span>
                                @endif
                            </td>
                            <td>{{ $source->app_id }}</td>
                            <td>{{ $source->version }}</td>
                            <td>{{ $source->created_at }}</td>
                            <td>{{ $source->note }}</td>
                            <td class="d-flex" style="gap: 5px">
                                <a href="javascript:void(0)" id="show-user" data-url="{{ route('showHtmlSource', $source->id) }}" class="btn btn-info">{{ __('Chi tiết') }}</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div style="margin-bottom: 20px;">
                    @if(isset($input))
                    {{ $dataPaginate->appends($input)->links() }}
                    @else
                    {{ $dataPaginate->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="userShowModal" tabindex="-1" aria-labelledby="userShowModalLabel" aria-hidden="true">
    <div class="modal-dialog" id="set-width">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userShowModalLabel">{{ __('Chi tiết nguồn HTML') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>ID :</strong> <span id="user-id"></span></p>
                <p><strong>{{ __('Đường dẫn') }} :</strong> <span id="url"></span></p>
                <p><strong>{{ __('Quốc gia') }} :</strong> <span id="country"></span></p>
                <p><strong>{{ __('Nền tảng') }} :</strong> <span id="platform"></span></p>
                <p><strong>{{ __('Thiết bị') }} :</strong> <span id="device"></span></p>
                <p><strong>{{ __('Nguồn') }} :</strong> <span id="source"></span></p>
                <p><strong>{{ __('Ứng dụng') }} :</strong> <span id="app_id"></span></p>
                <p><strong>{{ __('Phiên bản') }} :</strong> <span id="version"></span></p>
                <p><strong>{{ __('Ngày tạo') }} :</strong> <span id="created_at"></span></p>
                <p><strong>{{ __('Ghi chú') }} :</strong> <span id="note"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Đóng') }}</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        var urlParams = new URLSearchParams(window.location.search);
        var getDate = urlParams.get('date');

        $('#country-name').select2();
        $('#app-name').select2();

        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });

        document.querySelectorAll('span[data-type="copy"]')
            .forEach(function(button) {
                button.addEventListener('click', function() {
                    $('#item-table tr').removeClass('highlighted');
                    $(this).closest('tr').addClass('highlighted');
                    let email = this.parentNode.parentNode
                        .querySelector('button[data-type="email"]')
                        .innerText;
                    let tmp = document.createElement('textarea');
                    tmp.value = email;
                    tmp.setAttribute('readonly', '');
                    tmp.style.position = 'absolute';
                    tmp.style.left = '-9999px';
                    document.body.appendChild(tmp);
                    tmp.select();
                    document.execCommand('copy');
                    toastr.success("Sao chép mã HTML thành công");
                    document.body.removeChild(tmp);
                });
            });

        $('body').on('click', '#show-user', function() {
            var userURL = $(this).data('url');
            $.get(userURL, function(data) {
                $('#userShowModal').modal('show');
                $('#user-id').text(data.id);
                $('#url').text(data.url);
                $('#country').text(data.country);
                $('#platform').text(data.platform);
                $('#device').text(data.device_id);
                $('#source').text(data.source);
                $('#app_id').text(data.app_id);
                $('#version').text(data.version);
                $('#created_at').text(data.created_at);
                $('#note').text(data.note);
            })
        });

        $(function() {
            $("#datepicker").datepicker({
                dateFormat: "yy-m-dd",
            });

            var app = '<?php echo $row['app']; ?>';
            var date = '<?php echo $row['date']; ?>';
            var textSource = '<?php echo $row['textSource']; ?>';
            var device = '<?php echo $row['device']; ?>';
            var country = '<?php echo $row['country']; ?>';
            var urlParams = new URLSearchParams(window.location.search);
            var strInPage = '';

            if (app) {
                $("#app-name").val(app);

                if (strInPage == '') {
                    strInPage += '?app=' + app;
                } else {
                    strInPage += '&app=' + app;
                }
            }

            if (country) {
                $("#country-name").val(country);

                if (strInPage == '') {
                    strInPage += '?country=' + country;
                } else {
                    strInPage += '&country=' + country;
                }
            }

            if (date) {
                if (getDate != null) {
                    $('#datepicker').datepicker('setDate', getDate);
                } else {
                    $("#datepicker").val(date);
                }

                if (strInPage == '') {
                    strInPage += '?date=' + date;
                } else {
                    strInPage += '&date=' + date;
                }
            }

            if (textSource) {
                $("#text-source").val(textSource);

                if (strInPage == '') {
                    strInPage += '?textSource=' + textSource;
                } else {
                    strInPage += '&textSource=' + textSource;
                }
            }

            if (device) {
                $("#text-device").val(device);

                if (strInPage == '') {
                    strInPage += '?device=' + device;
                } else {
                    strInPage += '&device=' + device;
                }
            }

            $("#search-report").on("click", function() {
                let app = $('#app-name').val();
                let date = $('#datepicker').datepicker({
                    dateFormat: 'yyyy-MM-dd'
                }).val();
                let device = $('#text-device').val();
                let textSource = $('#text-source').val();
                let country = $('#country-name').val();
                let url = '?date=' + date + '&app=' + app + '&textSource=' + textSource + '&device=' + device + '&country=' + country;

                window.location.href = url;
            });
        });
    });
</script>
@endsection