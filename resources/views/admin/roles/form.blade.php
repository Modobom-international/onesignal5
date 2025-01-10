<div class="form-group{{ $errors->has('name') ? ' has-error' : ''}}">
    {{ Html::label('name', 'Name:', ['class' => 'control-label']) }}
    {{ Html::text('name', null, ['class' => 'form-control', 'required' => true]) }}
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('label') ? ' has-error' : ''}}">
    {{ Html::label('label', 'Label:', ['class' => 'control-label']) }}
    {{ Html::text('label', null, ['class' => 'form-control']) }}
    {!! $errors->first('label', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('label') ? ' has-error' : ''}}">
    {{ Html::label('permissions', 'Permissions:', ['class' => 'control-label']) }}
    {{ Html::select('permissions[]', $permissions, isset($role) ? $role->permissions->pluck('name')->toArray() : [], ['class' => 'form-control', 'multiple' => true]) }}
    {!! $errors->first('label', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group">
    {{ Html::button($formMode === 'edit' ? 'Update' : 'Create', ['class' => 'btn btn-primary', 'type' => 'submit']) }}
</div>