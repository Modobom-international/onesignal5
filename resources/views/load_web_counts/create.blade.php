@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">


            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        Create link post
                    </div>
                    <div class="card-body">
                        @include('adminlte-templates::common.errors')
                        {!! Html::form('POST', route('loadWebCounts.store'))->open() !!}

                        @include('load_web_counts.fields')

                        {{ Html::form()->close() }}
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
