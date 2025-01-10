@extends('layouts.app')

@section('title', 'Roles')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Roles</div>
                <div class="card-body">
                    <a href="{{ url('/admin/roles/create') }}" class="btn btn-success btn-sm" title="Add New Role">
                        <i class="fa fa-plus" aria-hidden="true"></i> Add New Role
                    </a>

                    <a href="{{ url('/admin/users') }}" class="btn btn-warning btn-sm" title="User">
                        Users
                    </a>
                    <a href="{{ url('/admin/permissions') }}" class="btn btn-primary btn-sm" title="Permissions">
                        Permissions
                    </a>

                    {{ Html::form()->method('GET')->action(url('/admin/roles'))->class('form-inline my-2 my-lg-0 float-right')->attribute('role', 'search')->open() }}
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Search...">
                        <span class="input-group-btn">
                            <button class="btn btn-secondary" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                    {{ Html::form()->close() }}

                    <br />
                    <br />

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($roles as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td><a href="{{ url('/admin/roles', $item->id) }}">{{ $item->name }}</a></td>

                                    <td>
                                        <a href="{{ url('/admin/roles/' . $item->id) }}" title="View Role"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
                                        <a href="{{ url('/admin/roles/' . $item->id . '/edit') }}" title="Edit Role"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>
                                        {{ Html::form()->method('DELETE')->action(url('/admin/roles/' . $item->id))->attributes(['style' => 'display:inline'])->open() }}
                                        {{ Html::button()->type('submit')->class('btn btn-danger btn-sm')->attribute('title', 'Delete Role')->attribute('onclick', 'return confirm("Confirm delete?")')->html('<i class="fa fa-trash-o" aria-hidden="true"></i>') }}
                                        {{ Html::form()->close() }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="pagination"> {!! $roles->appends(['search' => Request::get('search')])->render() !!} </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection