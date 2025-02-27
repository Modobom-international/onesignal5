@extends('layouts.app')

@section('title', 'Create User')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Create New User</div>
                <div class="card-body">
                    <a href="{{ url('/admin/users') }}" title="Back"><button class="btn btn-warning"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                    <br />
                    <br />

                    <form method="POST" method="POST" action="{{ route('users.store')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="id" class="control-label">Name</label>
                            <input autocomplete="off" name="name" type="text" id="id" class="form-control">
                            @if ($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="id" class="control-label">Email</label>
                            <input autocomplete="off" name="email" type="text" id="id" class="form-control">
                            @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="id" class="control-label">Password</label>
                            <input autocomplete="off" name="password" type="password" id="id" class="form-control">
                            @if ($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>

                        <h5 for="permissions" class="form-label">Assign Roles</h5>

                        <table class="table table-striped">
                            <thead>
                                <th scope="col" width="80%"><input type="checkbox" name="all_permission"></th>
                                <th scope="col" width="20%">Name</th>
                            </thead>
                            @foreach($roles as $role)
                            <tr>
                                <td>
                                    <input type="checkbox"
                                        name="roles[{{ $role->name }}]"
                                        value="{{ $role->name }}"
                                        class='permission'>
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