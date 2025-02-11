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
                <input class="form-control" type="text" id="domain" value="" placeholder="Nhập domain">
                <button class="btn btn-primary" onclick="checkDomain()">Kiểm tra</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function checkDomain() {
        var domain = document.getElementById('domain').value;
        if (domain == '') {
            alert('Domain không được để trống');
            return;
        }
        
        $.ajax({
            url: '/admin/check-domain',
            type: 'GET',
            data: {
                domain: domain
            },
            success: function(response) {
                alert(response.message);
            },
            error: function(error) {
                console.log(error);
            }
        });
    }
</script>
@endsection