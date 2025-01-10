<div class="form-group">
    <b>{!! Html::label('id', 'Id:') !!}</b>
    <p>{{ $loadWebCount->id }}</p>
</div>

<div class="form-group">
    <b>{!! Html::label('game', 'Game:') !!}</b>
    <p>{{ $loadWebCount->game }}</p>
</div>

<div class="form-group">
    <b>{!! Html::label('max_post', 'Max Post:') !!}</b>
    <p>{{ $loadWebCount->max_post }}</p>
</div>

<div class="form-group">
    <b>{!! Html::label('link_post', 'Link Post:') !!}</b>
    <p>{!! nl2br($loadWebCount->link_post) !!}</p>
</div>

<div class="form-group">
    <b>{!! Html::label('link_return', 'Link Return:') !!}</b>
    <p>{{ $loadWebCount->link_return }}</p>
</div>

<div class="form-group">
    <b>{!! Html::label('created_at', 'Created at:') !!}</b>
    <p>{{ $loadWebCount->created_at }}</p>
</div>

<div class="form-group">
    <b>{!! Html::label('updated_at', 'Updated at:') !!}</b>
    <p>{{ $loadWebCount->updated_at }}</p>
</div>
