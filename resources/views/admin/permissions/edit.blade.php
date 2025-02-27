@extends('layouts.app')

@section('title', 'Permission Edit')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Edit Permission</div>
                <div class="card-body">
                    <a href="{{ url('/admin/permissions') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                    <br />
                    <br />

                    <form method="POST" action="{{ route('permissions.update', $permission['id']) }}" enctype="multipart/form-data">
                        @method('patch')
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input value="{{ $permission->name }}"
                                type="text"
                                class="form-control"
                                name="name"
                                placeholder="Name" required>
                            @if ($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        @if ($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                        <div class="mb-3">
                            <label for="name" class="form-label">Guard Name</label>
                            <input value="web"
                                type="text"
                                class="form-control"
                                name="guard_name"
                                placeholder="Guard Name" readonly required>
                        </div>

                        <button type="submit" class="btn btn-primary">Save user</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection