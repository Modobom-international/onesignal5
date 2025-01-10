@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    Edit link posix_ctermid
                </div>
                <div class="card-body">
                    @include('adminlte-templates::common.errors')
                    {!! Html::form('POST', route('loadWebCounts.update', $loadWebCount->id))->attribute('method', 'PATCH')->open() !!}

                    @include('load_web_counts.fields')

                    {{ Html::form()->close() }}
                </div>
            </div>

        </div>
    </div>
</div>

@endsection