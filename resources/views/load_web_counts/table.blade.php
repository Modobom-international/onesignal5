<div class="table-responsive">
    <table class="table table-striped table-hover" id="loadWebCounts-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Game</th>
                <th>Max post</th>
                <th>Link post</th>
                <th>Link return</th>
                <th>Updated At</th>
                <th>Picked At</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($loadWebCounts as $link)
            <tr>
                <td>{{ $link->id }}</td>
                <td>{{ $link->game }}</td>
                <td>{{ $link->max_post }}</td>
                <td>{{ $link->link_post }}</td>
                <td>{{ $link->link_return }}</td>
                <td>{{ $link->created_at }}</td>
                <td>{{ $link->updated_at }}</td>
                <td>
                    <div class='btn-group'>
                        <a href="{{ route('loadWebCounts.show', [$link->id]) }}" class='btn btn-default btn-xs'>
                            <button class="btn btn-info btn-sm">
                                <i class="fa fa-eye"
                                    aria-hidden="true"></i>
                            </button>
                        </a>
                        <a href="{{ route('loadWebCounts.edit', [$link->id]) }}" class='btn btn-default btn-xs'>
                            <button class="btn btn-primary btn-sm">
                                <i class="fa fa-pencil-square-o"
                                    aria-hidden="true"></i>
                            </button>
                        </a>

                        {!! Html::form('POST', route('loadWebCounts.destroy', $link->id))->attribute('method', 'DELETE')->open() !!}
                        {!! Html::submitButton('<i class="fa fa-trash-o" aria-hidden="true"></i>', ['class' => 'btn btn-danger btn-sm', 'onclick' => "return confirm('Are you sure?')"]) !!}
                        {{ Html::form()->close() }}

                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>