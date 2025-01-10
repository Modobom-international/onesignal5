{!! Html::form('POST', route('appLinkStores.destroy', $id))->attribute('method', 'DELETE')->open() !!}
<div class='btn-group'>
    <a href="{{ route('appLinkStores.show', $id) }}" class='btn btn-default btn-xs'>
        <i class="glyphicon glyphicon-eye-open"></i>
    </a>
    <a href="{{ route('appLinkStores.edit', $id) }}" class='btn btn-default btn-xs'>
        <i class="glyphicon glyphicon-edit"></i>
    </a>
    {!! Html::submitButton('<i class="glyphicon glyphicon-trash"></i>', [
    'class' => 'btn btn-danger btn-xs',
    'onclick' => "return confirm('Are you sure?')"
    ]) !!}
</div>
{{ Html::form()->close() }}