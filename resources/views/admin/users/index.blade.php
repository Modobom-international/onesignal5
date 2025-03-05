@extends('layouts.app')

@section('title', __('Danh sách nhân viên'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{ url('/admin/users/create') }}" class="btn btn-success" title="Add New User">
                        <i class="fa fa-plus" aria-hidden="true"></i> {{ __('Thêm người dùng') }}
                    </a>
                    <a href="{{ url('/admin/roles') }}" class="btn btn-warning" title="Role">
                        {{ __('Đội') }}
                    </a>
                    <a href="{{ url('/admin/permissions') }}" class="btn btn-primary" title="Permission">
                        {{ __('Quyền') }}
                    </a>

                    {!! Html::form('GET', '/admin/users')->class('form-inline my-2 my-lg-0 float-right')->attribute('role', 'search')->open() !!}
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
                                    <th>{{ __('Tên') }}</th>
                                    <th>{{ __('Chức vụ') }}</th>
                                    <th>{{ __('Hòm thư') }}</th>
                                    <th>{{ __('Đội') }}</th>
                                    <th>{{ __('Số điện thoại') }}</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->title ?? '' }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ isset($user->role) ? $user->role->name : '' }}</td>
                                    <td>{{ $user->phone_number }}</td>
                                    <td>
                                        <a href="" title="View User"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
                                        <a href="{{ url('/admin/users/' . $user->id . '/edit') }}" title="Edit User"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="pagination"> {{ $users->links() }} </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection