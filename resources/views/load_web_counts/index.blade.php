@extends('layouts.app')

@section('title')
Load Web Count
@endsection

@section('styles')
<style>
    .table form {
        margin-top: 5px;
    }

    .link-status-live {
        color: green;
    }

    .link-status-die {
        color: red;
    }

    .btn-pos {
        position: relative;
        z-index: 1;
        left: -36px;
    }

    .input-group-append {
        margin-left: -37px;
    }

    .table form {
        margin-top: 7px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    Links store - Total: <b></b>
                </div>
                <div class="card-body">
                    @include('flash::message')
                    <a class="btn btn-primary pull-left" style="margin-bottom: 5px; margin-right: 20px;" href="{{ route('loadWebCounts.create') }}">Add New</a>
                    <div class="pull-left">
                    </div>

                    {!! Html::form('GET', route('loadWebCounts.index'))->class('form-inline my-2 my-lg-0 float-right')->attribute('role', 'search')->id('search_form')->open() !!}
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search..." id="search_input" name="search" style="width: 200px;" value="{{request('search')}}">
                        <button class="btn btn-outline-secondary border-0 btn-pos btn-clear-input" type="button">
                            <i class="fa fa-times"></i>
                        </button>
                        <div class="input-group-append">
                            <button class="btn btn-secondary" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>

                    {{ Html::form()->close() }}

                    @include('load_web_counts.table')

                    {{ $loadWebCounts->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $('.btn-clear-input').on('click', function() {
        $('#search_input').val('');

        $('#search_form').submit();
    });
</script>
@endsection