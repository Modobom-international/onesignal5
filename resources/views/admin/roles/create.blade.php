@extends('layouts.app')

@section('title', 'Create Role')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Create New Role</div>
                <div class="card-body">
                    <a href="{{ url('/admin/roles') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                    <br />
                    <br />
                    <form method="POST" action="{{ route('roles.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label>Role Name</label>
                            <select name="name" class="form-control" id="device-name">
                                <option selected>Choose role</option>
                                <option value="user-ads">User Ads</option>
                                <option value="super-admin">Super Admin</option>
                                <option value="manager-file">Manager file</option>
                                <option value="manager-push-system">Manager PushSystem</option>

                            </select>
                            @if ($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <input value="web"
                            type="hidden"
                            class="form-control"
                            name="guard_name"
                            placeholder="Name" required>
                        <div class=" mt-4 d-flex">
                            <h5 for="permissions" class="form-label" style="width: 60%">Assign Permissions</h5>
                            <div class="input-group">
                                <input type="text" id="myInput" onkeyup="myFunction()" class="form-control" name="search" placeholder="Search...">
                                <span class="input-group-append">
                                </span>
                            </div>
                        </div>
                        <div style="width:100%; height:500px; overflow:auto;">
                            <table id="myTable" class="table mt-4">
                                <tr class="header">
                                    <th scope="col" width="80%"><input type="checkbox" name="all_permission">Check all</th>
                                    <th style="width:60%;">Name</th>
                                </tr>

                                @foreach($permissions as $permission)
                                <tr>
                                    <td>
                                        <input type="checkbox"
                                            name="permission[{{ $permission->name }}]"
                                            value="{{ $permission->name }}"
                                            class='permission'>
                                    </td>
                                    <td>{{ $permission->name }}</td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                        <button type="submit" class="btn btn-primary mt-4">Save Role</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('[name="all_permission"]').on('click', function() {

            if ($(this).is(':checked')) {
                $.each($('.permission'), function() {
                    $(this).prop('checked', true);
                });
            } else {
                $.each($('.permission'), function() {
                    $(this).prop('checked', false);
                });
            }
        });
    });

    function myFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>
@endsection