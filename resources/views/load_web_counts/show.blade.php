@extends('layouts.app')

@section('title', 'Load web counts')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    Link store info
                </div>
                <div class="card-body">
                    <a href="{{ route('loadWebCounts.index') }}" title="Back">
                        <button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i>
                            Back
                        </button>
                    </a>
                    <a href="{{ route('loadWebCounts.edit', ['id' => $loadWebCount->id] ) }}" title="Edit link post">
                        <button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit
                        </button>
                    </a>
                    {{ Html::form()->method('DELETE')->action(route('loadWebCounts.destroy', ['id' => $loadWebCount->id]))->attributes(['style' => 'display:inline'])->open() }}
                    {{ Html::button()->type('submit')->class('btn btn-danger btn-sm')->attribute('title', 'Delete link')->attribute('onclick', 'return confirm("Are you sure?")')->html('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete') }}
                    {{ Html::form()->close() }}
                    <br />
                    <br />

                    @include('load_web_counts.show_fields')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection