@extends('layouts.app')

@section('title', __('Sửa nhân viên'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <br />
                    <br />
                    <form method="PATCH" action="{{ route('users.update', $user->id)}}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="id" class="form-label">{{ __('Tên') }}</label>
                            <input autocomplete="off" name="name" type="text" id="id" class="form-control" value="{{ $user->name }}">
                            @if ($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>

                        <div class="form-group mt-3">
                            <label for="id" class="form-label">{{ __('Hòm thư') }}</label>
                            <input autocomplete="off" name="email" type="text" id="id" class="form-control" value="{{ $user->email }}">
                            @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>

                        <div class="form-group mt-3">
                            <label for="id" class="form-label">{{ __('Mật khẩu') }}</label>
                            <input autocomplete="off" value="modobom@123" name="password" type="password" id="id" class="form-control" style="background-color: #e9ecef !important;" disabled>
                            @if ($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>

                        <div class="form-group mt-3">
                            <label for="title" class="form-label">{{ __('Chức vụ') }}</label>
                            <select class="form-control" id="title" name="title">
                                @foreach($listTitle as $title => $des)
                                <option value="{{ $title }}" {{ $user->title == $title ? 'selected' : '' }}>{{ $des }}</option>
                                @endforeach
                            </select>

                            @if ($errors->has('title'))
                            <span class="text-danger">{{ $errors->first('title') }}</span>
                            @endif
                        </div>

                        <div class="form-group mt-3">
                            <label for="address" class="form-label">{{ __('Địa chỉ') }}</label>
                            <input autocomplete="off" name="address" type="text" id="address" class="form-control" value="{{ $user->address }}">
                            @if ($errors->has('address'))
                            <span class="text-danger">{{ $errors->first('address') }}</span>
                            @endif
                        </div>

                        <div class="form-group mt-3">
                            <label for="phone_number" class="form-label">{{ __('Số điện thoại') }}</label>
                            <input autocomplete="off" name="phone_number" type="number" id="phone_number" class="form-control" value="{{ $user->phone_number }}">
                            @if ($errors->has('phone_number'))
                            <span class="text-danger">{{ $errors->first('phone_number') }}</span>
                            @endif
                        </div>

                        <div class="form-group mt-3">
                            <label for="roles" class="form-label">{{ __('Đội') }}</label>
                            <select class="form-control" id="roles" name="roles">
                                @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ $user->role == $role_id ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>

                            @if ($errors->has('roles'))
                            <span class="text-danger">{{ $errors->first('roles') }}</span>
                            @endif
                        </div>

                        <div class="mt-4">
                            <a href="{{ url('/admin/users') }}" title="{{ __('Quay lại') }}"><button class="btn btn-warning"><i class="fa fa-arrow-left" aria-hidden="true"></i> {{ __('Quay lại') }}</button></a>
                            <button type="submit" class="btn btn-success me-2">{{ __('Lưu') }}</button>
                            <button type="reset" class="btn btn-outline-secondary">{{ __('Xóa') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection