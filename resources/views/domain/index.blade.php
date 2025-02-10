@extends('layouts.app')

@section('title', 'List Domain')

@section('styles')
<link href="{{ asset('css/domain.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <a href="{{ route('domain.create') }}" class="btn btn-success">Create Domain</a>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Domain</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($domains as $domain)
                            <tr>
                                <td>{{ $domain->domain }}</td>
                                <td>{{ $domain->created_at }}</td>
                                <td>{{ $domain->updated_at }}</td>
                                <td>
                                    <a href="{{ route('domain.show', $domain->id) }}" class="btn btn-primary">Show</a>
                                    <form action="{{ route('domain.destroy', $domain->id) }}" method="post" style="display: inline;">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection