@extends('layouts.app')

@section('title', 'Permission')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Permission</div>
                <div class="card-body">
                    <a href="{{ url('/admin/permissions') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                    <a href="{{ url('/admin/permissions/' . $permission->id . '/edit') }}" title="Edit Permission"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                    {{ Html::form()->method('DELETE')->action(url('/admin/permissions/' . $permission->id))->attributes(['style' => 'display:inline'])->open() }}
                    {{ Html::button()->type('submit')->class('btn btn-danger btn-sm')->attribute('title', 'Delete Permission')->attribute('onclick', 'return confirm("Confirm delete?")')->html('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete') }}
                    {{ Html::form()->close() }}
                    <br />
                    <br />

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID.</th>
                                    <th>Name</th>
                                    <th>Label</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $permission->id }}</td>
                                    <td> {{ $permission->name }} </td>
                                    <td> {{ $permission->label }} </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection