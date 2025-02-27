@extends('layouts.app')

@section('title', 'Create Permission')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Create Permission</div>
                <div class="card-body">
                    <a href="{{ url('/admin/permissions') }}" title="Back"><button class="btn btn-warning"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                    <br />
                    <br />
                    <form method="POST" action="{{ route('permissions.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label>Permission Name</label>
                            <select name="name" class="form-control" id="device-name">
                                <option selected>Choose permission</option>
                                <option value="check-log-count-data">Check Log and Count report</option>
                                <option value="manager-file">Manager file</option>
                                <option value="manager-push-system">Manager PushSystem</option>
                            </select>
                            @if ($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <input value="web" type="hidden" class="form-control" name="guard_name" placeholder="Guard Name" readonly required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save permission</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection