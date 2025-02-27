@extends('layouts.app')

@section('title', 'Role')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Role</div>
                <div class="card-body">
                    <a href="{{ url('/admin/roles') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                    <br />
                    <br />
                    <div class=" mt-4 d-flex">
                        <h5 for="permissions" class="form-label" style="width: 60%">Assign Permissions : {{$role->name}}</h5>
                        <div class="input-group">
                            <input type="text" id="myInput" onkeyup="myFunction()" class="form-control" name="search" placeholder="Search...">
                            <span class="input-group-append">
                            </span>
                        </div>
                    </div>
                    <table id="myTable" class="table mt-4">
                        <th scope="col" width="20%">Permission</th>
                        <th scope="col" width="1%">Guard</th>

                        @foreach($rolePermissions as $permission)
                        <tr>
                            <td>{{ $permission->name }}</td>
                            <td>{{ $permission->guard_name }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#tableID').DataTable({
            searching: true
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