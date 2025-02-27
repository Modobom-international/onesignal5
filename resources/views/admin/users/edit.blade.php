@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Edit User</div>
                <div class="card-body">
                    <a href="{{ url('/admin/users') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                    <br />
                    <br />
                    <form method="POST" method="POST" action="{{ route('users.update', $user->id)}}" enctype="multipart/form-data">
                        @method('patch')
                        @csrf
                        <div class="form-group">
                            <label for="id" class="control-label">Name</label>
                            <input autocomplete="off" name="name" value="{{$user->name}}" type="text" id="id" class="form-control">
                            @if ($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="id" class="control-label mt-4">Email</label>
                            <input autocomplete="off" name="email" value="{{$user->email}}" type="text" id="id" class="form-control">
                            @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <h5 for="permissions" class="form-label mt-4">Assign Roles</h5>

                        <table class="table table-striped">
                            <thead>
                                <th scope="col" width="80%"><input type="checkbox" name="all_permission"></th>
                                <th scope="col" width="20%">Name</th>
                            </thead>
                            @foreach($roles as $role)
                            <tr>
                                <td>
                                    <input type="checkbox" name="roles[{{ $role->name }}]" value="{{ $role->name }}" class='permission' {{ in_array($role->name, $userRole)? 'checked': '' }}>
                                </td>
                                <td>{{ $role->name }}</td>
                            </tr>
                            @endforeach
                        </table>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-success me-2">{{ __('Save') }}</button>
                            <button type="reset" class="btn btn-outline-secondary">{{ __('Reset') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection