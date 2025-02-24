<div id="table-domain">
    <table class="table table-bordered table-hover table-striped">
        <thead>
            <tr>
                <th>Domain</th>
                <th>Server</th>
                <th>Tài khoản</th>
                <th>Mật khẩu</th>
                <th>Quản lý</th>
                <th>Ngày tạo</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($domains as $domain)
            <tr>
                <td>{{ $domain->domain }}</td>
                <td>{{ \App\Enums\ListServer::SERVER[$domain->server] }}</td>
                <td>{{ $domain->admin_username }}</td>
                <td>{{ $domain->admin_password }}</td>
                <td>{{ $domain->email ?? '' }}</td>
                <td>{{ $domain->created_at }}</td>
                <td><button class="btn btn-primary" data-bs-toggle="modal" data-total="{{ json_encode($domain) }}" data-bs-target="#modalDetailDomain"><i class="fa fa-info-circle"></i></button></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-3">
        {{ $domains->links() }}
    </div>
</div>