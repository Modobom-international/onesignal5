@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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

</style>
@endsection

@section('content')
<div id="alert-device-status">
</div>
<div class="container-fluid">
    <div class="row">

        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <p>Service OTP</p>

                    <div id="toast"></div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Service</th>
                                    <th width="200px">Phone</th>
                                    <th width="150px">OTP</th>
                                    <th width="150px">Status</th>
                                    <th>Message</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($otp as $sim)
                                <tr>
                                    <td>{{ $sim->sender_name }}</td>
                                    <td id="phone-with-{{$sim->id }}" >{{ $sim->phone }}
                                        @if($sim->phone != null)
                                            <span class="copy-to-clipboard" onclick="copyToClickPhone('phone-with-{{ $sim->id }}')"><img src="{{ asset('img/copy.png') }}" width="15" height="15">
                                        </span>
                                        @endif
                                    </td>

                                    <td id="otp-with-{{ $sim->id }}">{{ $sim->otp }}
                                        @if($sim->otp != null)
                                        <span class="copy-to-clipboard" onclick="copyToClipboard('otp-with-{{ $sim->id }}')"><img src="{{ asset('img/copy.png') }}" width="15" height="15">
                                        </span>
                                        @endif
                                    </td>

                                    <td><span style="padding: 10px; border-radius: 20px;">{{ \App\Enums\ServiceOTP::TEXT_STATUS[$sim->status] }}</span></td>
                                    <td>{{ $sim->raw_data }}</td>
                                    <td>
                                        <a   id="show-message" onclick="getPhone('{{ $sim->phone }}')"  data-url="{{ route('getMessageSim',  $sim->storage_sim_id) }}">
                                            <button  type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                                Show Message
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="pagination"> {!! $otp->appends(['search' => Request::get('search')])->render() !!} </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
    <div class="modal-dialog" role="document" style="max-width: 1000px">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="max-height: calc(129vh - 210px);
            overflow-y: auto;
            height: 500px;">
                <table id="myTable" class="table table-striped">
                    <thead>
                    <tr>
                        <th>Service</th>
                        <th width="150px">OTP</th>
                        <th>Message</th>
                        <th width="200px">Time</th>
                    </tr>
                    </thead>
                    <tbody id="opt-history">

                    <tr class="striped">
                    </tr>

                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.12.0/toastify.min.js"></script>

<script>
    $(document).ready(function () {

        /* When click show user */
        $('body').on('click', '#show-message', function () {
            var userURL = $(this).data('url');
            $.get(userURL, function (data) {
                $('#myTable').find('tbody').empty();
                $.each(data, function (i,item) {
                    if(item.history_opt != null )
                    {
                        $("#opt-history").append(`<tr class="striped">
                        <td> <span >`+ item.sender_name +`</span></td>
                        <td> <span >`+ item.otp +`</span></td>
                        <td> <span >`+ item.history_opt +`</span></td>
                        <td> <span >`+ item.history_date +`</span></td></tr>`);
                    }
                });

            })

        });

    });

    function copyToClickPhone(element) {
        var $temp = $("<input>");
        var idElement = '#' + element;
        var awbno = document.querySelector(idElement).innerHTML;
        var dataPhone = awbno.slice(0, 10)
        $("body").append($temp);
        $temp.val($(idElement).text()).select();
        document.execCommand("copy");
        Toastify({
            text: 'Sao chép số điện thoại thành công ' + dataPhone,
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
            onClick: function () {
            } // Callback after click
        }).showToast();
    }

    function copyToClipboard(element) {
        var $temp = $("<input>");
        var idElement = '#' + element;
        var awbno = document.querySelector(idElement).innerHTML;
        var dataOPT = awbno.slice(0, 10)
        $("body").append($temp);
        $temp.val($(idElement).text()).select();
        document.execCommand("copy");
        Toastify({
            text: 'Sao chép mã OTP thành công ' + dataOPT,
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
            onClick: function () {
            } // Callback after click
        }).showToast();
        $temp.remove();
    }

    function getPhone(element) {
        var idElement =  element;
        $('#exampleModalLabel').empty();
        $("#exampleModalLabel").append("Message OTP - " + idElement);
    }

</script>
@endsection
