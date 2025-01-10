@extends('layouts.app')

@section('title')
List Wap Url
@endsection

@section('styles')
<style>
    .modal p {
        word-wrap: break-word;
    }

    #set-width {
        max-width: 1200px;
    }

    #element_html {
        position: absolute;
        opacity: .01;
        height: 0;
        overflow: hidden;
    }

    tr.highlighted td {
        background: #d8d8d8;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-10">
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
                            <label>Quốc gia</label>
                            <select class="form-control" id="country-name">
                                <option value="all">Tất cả</option>
                                @foreach($countries as $countryItem)
                                @if($countryItem->country != '')
                                <option @if($country==$countryItem->country) selected @endif value="{{ $countryItem->country }}">{{ $countryItem->country }}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-2 col-md-12">
                            <label>Nền tảng</label>
                            <select class="form-control" id="platform-name">
                                <option value="all">Tất cả</option>
                                @foreach($platforms as $platformItem)
                                @if($platformItem->platform != '')
                                <option @if($platform==$platformItem->platform) selected @endif value="{{ $platformItem->platform  }}">{{ $platformItem->platform }}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-2 col-md-12">
                            <label>Nhà mạng</label>
                            <select class="form-control" id="network-name">
                                <option value="all">Tất cả</option>
                                @foreach($networks as $networkItem)
                                @if($networkItem->network != '')
                                <option @if($network==$networkItem->network) selected @endif value="{{ $networkItem->network  }}">{{ $networkItem->network }}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-2 col-md-12">
                            <button type="button" class="btn btn-primary" style="margin-top: 30px; margin-bottom: 30px;" id="search-report">Tìm kiếm</button>
                        </div>
                    </div>

                    <div>
                        <b>Total: <span style="color: red;">{{$count}}</span></b>
                    </div>
                    <div class="table-responsive">
                        <table class="table" id="item-table">
                            <thead>
                                <tr>
                                    <th>ID User</th>
                                    <th>Quốc gia</th>
                                    <th>Nền tảng</th>
                                    <th>Nhà mạng</th>
                                    <th>OTP</th>
                                    <th>URL</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dataPaginate as $wap)
                                <tr id="row-sim-social-">
                                    <td>{{ $wap->id_user }}</td>
                                    <td>{{ $wap->country ?? "" }}</td>
                                    <td>{{ $wap->platform ?? "" }}</td>
                                    <td>{{ $wap->network ?? "" }}</td>
                                    <td>{{ $wap->otp }}</td>
                                    <td>{{ $wap->url }}</td>
                                    <td class="d-flex" style="gap: 5px">
                                        <a href="javascript:void(0)" id="show-user" data-url="{{ route('showWapUrl', $wap->id) }}" class="btn btn-info">Show</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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
</div>

<div class="modal fade" id="userShowModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" id="set-width">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Show Wap URL</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>ID User:</strong> <span id="id_user"></span></p>
                <p><strong>Quốc gia:</strong> <span id="country"></span></p>
                <p><strong>Nền tảng:</strong> <span id="platform"></span></p>
                <p><strong>Nhà mạng:</strong> <span id="network"></span></p>
                <p><strong>OTP:</strong> <span id="otp"></span></p>
                <p><strong>Url:</strong> <span id="url"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#country-name').select2();
        $('#platform-name').select2();
        $('#network-name').select2();

        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });

        $('body').on('click', '#show-user', function() {
            var userURL = $(this).data('url');
            $.get(userURL, function(data) {
                $('#userShowModal').modal('show');
                $('#id_user').text(data.id_user);
                $('#country').text(data.country);
                $('#platform').text(data.platform);
                $('#network').text(data.network);
                $('#otp').text(data.otp);
                $('#url').text(data.url);
            })
        });

        $(function() {
            $("#datepicker").datepicker({
                dateFormat: "yy-m-dd",
            });
            var date = '<?php echo $row['date']; ?>';
            var country = '<?php echo $row['country']; ?>';
            var platform = '<?php echo $row['platform']; ?>';
            var network = '<?php echo $row['network']; ?>';
            var urlParams = new URLSearchParams(window.location.search);
            var strInPage = '';

            if (country) {
                $("#country-name").val(country);

                if (strInPage == '') {
                    strInPage += '?country=' + country;
                } else {
                    strInPage += '&country=' + country;
                }
            }

            if (platform) {
                $("#platform-name").val(platform);

                if (strInPage == '') {
                    strInPage += '?platform=' + platform;
                } else {
                    strInPage += '&platform=' + platform;
                }
            }

            if (network) {
                $("#network-name").val(network);

                if (strInPage == '') {
                    strInPage += '?network=' + network;
                } else {
                    strInPage += '&network=' + network;
                }
            }

            if (date) {
                $("#datepicker").val(date);

                if (strInPage == '') {
                    strInPage += '?date=' + date;
                } else {
                    strInPage += '&date=' + date;
                }
            }

            $("#search-report").on("click", function() {
                let country = $('#country-name').val();
                let platform = $('#platform-name').val();
                let network = $('#network-name').val();
                let date = $('#datepicker').datepicker({
                    dateFormat: 'yyyy-MM-dd'
                }).val();

                let url = '?date=' + date + '&country=' + country + '&platform=' + platform + '&network=' + network;
                window.location.href = url;
            });
        });
    });
</script>

@endsection
