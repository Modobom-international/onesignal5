<div class="form-group col-sm-6">
    {!! Html::label('game', 'Game:') !!}
    {!! Html::text('game')->class('form-control') !!}
</div>

<div class="form-group col-sm-6">
    {!! Html::label('max_post', 'Max Post:') !!}
    {!! Html::text('max_post')->class('form-control') !!}
</div>

<div class="form-group col-sm-6">
    {!! Html::label('link_post', 'Link Post:') !!}
    {!! Html::text('link_post')->class('form-control') !!}
</div>

<div class="form-group col-sm-6">
    {!! Html::label('link_return', 'Link Return:') !!}
    {!! Html::text('link_return')->class('form-control') !!}
</div>

<div class="form-group col-sm-12">
    {!! Html::submit('Save')->class('btn btn-primary') !!}
    <a href="{{ route('loadWebCounts.index') }}" class="btn btn-default">Cancel</a>
</div>