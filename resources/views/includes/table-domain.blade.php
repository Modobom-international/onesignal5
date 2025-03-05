<div id="table-domain">
    <table class="table table-bordered table-hover table-striped">
        <thead>
            <tr>
                <th>{{ __('Tên miền') }}</th>
                <th>{{ __('Máy chủ') }}</th>
                <th>{{ __('Tài khoản') }}</th>
                <th>{{ __('Mật khẩu') }}</th>
                <th>{{ __('Quản lý') }}</th>
                <th>{{ __('Ngày tạo') }}</th>
                <th>{{ __('Hành động') }}</th>
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
                <td>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-total="{{ json_encode($domain) }}" data-bs-target="#modalDetailDomain"><i class="fa fa-info-circle"></i></button>
                    @if($domain->provider == Auth::user()->id)
                    <button class="btn btn-danger" data-bs-toggle="modal" data-domain="{{ $domain->domain }}" data-bs-target="#modalDeleteDomain"><i class="fa fa-trash"></i></button>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-3">
        {{ $domains->links() }}
    </div>
</div>