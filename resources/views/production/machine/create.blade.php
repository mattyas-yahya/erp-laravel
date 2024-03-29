{{ Form::open(['route' => ['production.machine.store'], 'method' => 'POST']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-lg-12 col-md-12">
            {{ Form::label('name', __('Name'), ['class' => 'form-label']) }} <span class="text-danger">*</span>
            {{ Form::text('name', null, ['class' => 'form-control', 'required']) }}
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{ __('Cancel') }}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Create') }}" class="btn btn-primary">
</div>
{{ Form::close() }}
