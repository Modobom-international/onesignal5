@extends('layouts.app')

@section('title', 'Permission')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Permissions</div>
                <div class="card-body">
                    <a href="{{ url('/admin/permissions/create') }}" class="btn btn-success" title="Add New Permission">
                        <i class="fa fa-plus" aria-hidden="true"></i> Add New Permission
                    </a>
                    <a href="{{ url('/admin/roles') }}" class="btn btn-primary" title="Roles">
                        Role
                    </a>
                    <a href="{{ url('/admin/users') }}" class="btn btn-warning" title="Users">
                        Users
                    </a>

                    {!! Html::form('GET', '/admin/permissions')->class('form-inline my-2 my-lg-0 float-right')->attribute('role', 'search')->open() !!}
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Search...">
                        <span class="input-group-append">
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
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($permissions as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td><a href="{{ url('/admin/permissions', $item->id) }}">{{ $item->name }}</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="pagination"> {!! $permissions->appends(['search' => Request::get('search')])->render() !!} </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection