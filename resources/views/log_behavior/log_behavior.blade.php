@extends('layouts.app')

@section('title', 'Log behavior')

@section('content')

@endsection

@section('scripts')
<script>
    var backToTop = document.getElementById("back-to-top");
    var chart = 'chart';
    var app = '<?php echo $filter['app']; ?>';
    var country = '<?php echo $filter['country']; ?>';
    var platform = '<?php echo $filter['platform']; ?>';
    var network = '<?php echo $filter['network']; ?>';
    var install = '<?php echo $filter['install']; ?>';
    var date = '<?php echo $filter['date']; ?>';
    var today = '<?php echo $today; ?>';
    var prevToday = '<?php echo $prevToday; ?>';
    var urlParams = new URLSearchParams(window.location.search);
    var strInPage = '';
    var statusNowDate = true;
    if (install) {
        $("#install").val(install);
        if (strInPage == '') {
            strInPage += '?install=' + install;
        } else {
            strInPage += '&install=' + install;
        }
    }
</script>
<script src="{{ asset('js/log-behavior.js') }}"></script>
@endsection