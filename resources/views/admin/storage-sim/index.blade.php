@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.12.0/toastify.min.css">
<style>
    table td {
        word-wrap: break-word;
        overflow-wrap: break-word;
    }

    .copy-to-clipboard {
        margin-left: 10px;
        cursor: pointer;
    }

    .modal-dialog {
        max-width: 1000px;
    }

    .modal-body {
        max-height: 500px;
        overflow: auto;
    }

    .question {
        display: inline-block;
        margin: 10px;
    }
</style>
@endsection

@section('content')
</div>
<div class="container-fluid">
    <div class="row">

        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <p>Storage sim</p>
                </div>

                <div class="card-body">
                    <div id="checkboxes">
                        <a href="#" class="btn btn-danger question" data-toggle="modal" data-target="#deleteAllConfirm">Xóa toàn bộ</a>

                        <fieldset class="question">
                            <input id="check_is_online" type="checkbox" name="coupon_question" value="online" onchange="checkListSim()" checked />
                            <span class="item-text">Online</span>
                        </fieldset>
                        <fieldset class="question">
                            <input id="check_is_offline" type="checkbox" name="coupon_question" value="offline" onchange="checkListSim()" />
                            <span class="item-text">Offline</span>
                        </fieldset>
                    </div>
                    <div class="table-responsive">
                        <table class="table" id="item-table">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" name="" id="select_all_ids"></th>
                                    <th>Số điện thoại</th>
                                    <th>Trạng thái</th>
                                    <th>Nhà mạng</th>
                                    <th>Ngày hoạt động gần nhất</th>
                                    <th>Ngày kết thúc</th>
                                    <th>Số tiền</th>
                                    <th>Số lần sử dụng</th>
                                    <th>Thông báo</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($storageSim as $sim)
                                @if($sim->is_online == 1)
                                <tr id="row-sim-social-{{ $sim->id }}">
                                    <td><input type="checkbox" name="ids" class="checkbox_ids" id="" value="{{$sim->id}}"></td>
                                    <td id="phone-with-{{$sim->id }}">{{ $sim->phone }}
                                        @if($sim->phone != null)
                                        <span class="copy-to-clipboard" onclick="copyToClickPhone('phone-with-{{ $sim->id }}')"><i class="fa fa-copy" style="font-size:20px"></i>
                                        </span>
                                        @endif
                                    </td>
                                    <td class="px-3.5 py-2.5 first:pl-5 last:pr-5 status">
                                        <span class="btn btn-{{$sim->is_online == 1 ? 'success' : 'danger' }}">
                                            {{$sim->is_online == 1 ? "Online " : "Offline"}}
                                        </span>
                                    </td>
                                    <td>{{ $sim->network }}</td>

                                    @if($sim->last_online_date != null)
                                    <td>{{ date('d-m-Y H:i:s', (int) $sim->last_online_date / 1000) }}</td>
                                    @else
                                    <td>{{ $sim->last_online_date }}</td>
                                    @endif

                                    @if($sim->end_date != null)
                                    <td>{{ date('d-m-Y', (int) $sim->end_date / 1000) }}</td>
                                    @else
                                    <td>{{ $sim->end_date }}</td>
                                    @endif

                                    <td>{{ $sim->amount }}</td>
                                    <td>{{ $sim->time_to_use }}</td>
                                    <td>{{ $sim->note }}</td>
                                    <td>
                                        <button onclick="handleHistory($(this))" class="btn btn-success btn-sm" title="History" data-phone="{{ $sim->phone }}" data-id="{{ $sim->id }}" data-toggle="modal" data-target="#historySim">Lịch sử</button>
                                        <button onclick="handleDelete($(this))" class="btn btn-danger btn-sm" title="Delete" data-phone="{{ $sim->phone }}" data-id="{{ $sim->id }}" data-toggle="modal" data-target="#deleteConfirm">Xóa</button>

                                    </td>

                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                        <div class="pagination"> {!! $storageSim->appends(['search' => Request::get('search')])->render() !!} </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- history -->
<div class="modal fade" id="historySim" tabindex="-1" aria-labelledby="historySimLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="historySimLabel">History of <span id="phone-in-modal"></span></h5>
                <span>
                    <input type="date" class="form-control" id="filter-date-modal">
                </span>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>History</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-in-modal">

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="hidden-modal-input">
            </div>
        </div>
    </div>
</div>
<!-- delete sim -->
<div class="modal fade" id="deleteConfirm" tabindex="-1" aria-labelledby="deleteConfirmLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmLabel">Xác nhận xóa</h5>
            </div>
            <div class="modal-body">
                Bạn có muốn xóa không ?
            </div>
            <input type="hidden" id="hidden-modal-input">
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="handleDeleteUserSocial()">Xóa</button>
            </div>
        </div>
    </div>
</div>
<!-- delete all sim -->
<div class="modal fade" id="deleteAllConfirm" tabindex="-1" aria-labelledby="deleteConfirmLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmLabel">Xác nhận xóa</h5>
            </div>
            <div class="modal-body">
                Bạn có muốn xóa toàn bộ không ?
            </div>
            <input type="hidden" id="hidden-modal-input">
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" id="deleteAllSim">Xóa</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.12.0/toastify.min.js"></script>
<script>
    //copy phone
    function copyToClickPhone(element) {
        var $temp = $("<input>");
        var idElement = '#' + element;
        var awbno = document.querySelector(idElement).innerHTML;
        var dataPhone = awbno.slice(0, 10)
        $("body").append($temp);
        $temp.val($(idElement).text()).select();
        document.execCommand("copy");
        Toastify({
            text: 'Sao chép số điện thành công  ' + dataPhone,
            duration: 3000,
            //destination: "https://github.com/apvarun/toastify-js",
            //newWindow: true,
            close: true,
            gravity: "top", // `top` or `bottom`
            position: "right", // `left`, `center` or `right`
            stopOnFocus: true, // Prevents dismissing of toast on hover
            style: {
                background: "green",
            },
            onClick: function() {} // Callback after click
        }).showToast();
    }

    $(document).ready(function() {
        $('#filter-date-modal').on('change', function() {
            let id = $('#hidden-modal-input').val();
            let date = $('#filter-date-modal').val();
            let url = '/admin/get-history-sim';

            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    id: id,
                    date: date
                }
            }).done(function(result) {
                $('#tbody-in-modal').empty();

                for (let i = 0; i < result.length; i++) {
                    let strAppend = '<tr><td>' + result[i].history + '</td><td>' + result[i].history_date + '</td></tr>';
                    $('#tbody-in-modal').append(strAppend);
                }
            });
        });
    });
    //lịch sử sim
    function handleHistory(btn) {
        let id = btn.attr('data-id');
        $('#hidden-modal-input').val(id);
        let phone = btn.attr('data-phone');
        let url = '/admin/get-history-sim';

        $.ajax({
            url: url,
            type: 'GET',
            data: {
                id: id
            }
        }).done(function(result) {
            $('#phone-in-modal').html(phone);
            $('#tbody-in-modal').empty();

            for (let i = 0; i < result.length; i++) {
                let strAppend = '<tr><td>' + result[i].history + '</td><td>' + result[i].history_date + '</td></tr>';
                $('#tbody-in-modal').append(strAppend);
            }
        });
    }

    //xóa sim
    function handleDelete(btn) {
        let id = btn.attr('data-id');
        $('#hidden-modal-input').val(id);
    }

    function handleDeleteUserSocial() {
        let id = $('#hidden-modal-input').val();
        let url = '/admin/delete-storage-sim/' + id;
        $.ajax({
            url: url,
            type: 'GET'
        }).done(function(result) {
            if (result.status == 'success') {
                let idRow = '#row-sim-social-' + id;
                $(idRow).remove();
            }
            toast({
                title: "Thành công!",
                message: "Bạn đã xoá thành công.",
                type: "success",
                duration: 5000
            });
        });
    }

    //delete all sim
    $(document).ready(function() {
        $('#select_all_ids').click(function() {
            $('.checkbox_ids').prop('checked', $(this).prop('checked'));
        });

        $('#deleteAllSim').click(function(e) {
            e.preventDefault();
            var all_ids = [];
            $('input:checkbox[name=ids]:checked').each(function() {
                all_ids.push($(this).val());
            });

            $.ajax({
                url: "{{route('delete.all')}}",
                type: "DELETE",
                data: {
                    ids: all_ids,
                    _token: '{{csrf_token()}}'
                },
                success: function(response) {
                    $.each(all_ids, function(key, val) {
                        $('#row-sim-social-' + val).remove();
                        $("#select_all_ids").prop("checked", !$("#select_all_ids").prop("checked"));
                    });
                    toast({
                        title: "Thành công!",
                        message: "Bạn đã xoá thành công.",
                        type: "success",
                        duration: 5000
                    });
                }
            })
        })

    })


    //list sim by checkbox


    function checkListSim() {
        var is_online = $("#check_is_online").is(':checked');
        var is_offline = $("#check_is_offline").is(':checked');

        if (is_online == true && is_offline == false) {
            var status = 1;

        } else if (is_online == false && is_offline == true) {
            var status = 2;

        } else if (is_online == true && is_offline == true) {
            var status = 3;
        } else if (is_online == false && is_offline == false) {
            var status = 4;
        }
        $.ajax({
            url: '{{ route("list.storage.check.sim") }}',
            data: {
                status: status
            },

            type: 'GET',
            success: function(data) {
                $('#item-table').find('tbody').empty();
                $.each(data.data, function(key, item) {
                    var phone = item.phone ?? "";
                    var is_online_status_color = item.is_online == 1 ? "success " : "danger";
                    var is_online_status = item.is_online == 1 ? "Online " : "Offline";
                    var network = item.network ?? "";
                    var amount = item.amount ?? "";
                    var time_to_use = item.time_to_use ?? "";
                    var note = item.note ?? "";
                    var last_date = formatDate("d-m-Y H:i:s", Number(item.last_online_date)); //
                    var end_date = formatDate("d/m/Y", Number(item.end_date)); //


                    $('tbody').append(`<tr id="row-sim-social-` + item.id + `">
                  <td><input type="checkbox" name="ids" class="checkbox_ids" id="" value="` + item.id + `"></td>
                  <td id="phone-with-` + item.id + `" >` + phone + `
                          <span class="copy-to-clipboard" onclick="copyToClickPhone('phone-with-` + item.id + `')"><i class="fa fa-copy" style="font-size:20px"></i></span>
                  </td>

                  <td class="px-3.5 py-2.5 first:pl-5 last:pr-5 status">
                        <span  class="btn btn-` + is_online_status_color + `">
                            ` + is_online_status + `
                        </span>
                  </td>
                  <td>` + network + `</td>
                  <td>` + last_date + `</td>
                  <td>` + end_date + `</td>
                  <td>` + amount + `</td>
                  <td>` + time_to_use + `</td>
                  <td>` + note + `</td>
                  <td><button onclick="handleHistory($(this))" title="History" data-phone="` + phone + `" type="button" value="` + item.id + ` "
                  class="btn btn-success btn-sm" data-toggle="modal" data-target="#historySim">Lịch sử</button>
                  <button onclick="handleDelete($(this))" title="History" data-phone="` + phone + `" type="button" data-id="` + item.id + `
                   "class="btn btn-danger btn-sm" data-toggle="modal"  data-target="#deleteConfirm">Xóa</button>
                  </td>
              </tr>`)
                });
            }
        });
    }

    function formatDate(format, timeMili) {
        const date = new Date(timeMili);
        switch (format) {
            case "d-m-Y H:i:s":
                return date.getDate() + "-" + (date.getMonth() + 1) + "-" + date.getFullYear() + " " + date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds();
            case "d-m-Y":
                return date.getDate() + "-" + (date.getMonth() + 1) + "-" + date.getFullYear();
        }
        return date.getDate() + "-" + (date.getMonth() + 1) + "-" + date.getFullYear();
    }


    //toast
</script>
@endsection
