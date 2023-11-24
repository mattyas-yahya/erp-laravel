{{ Form::model($grDetail, ['route' => ['marketing.stock.update', $grDetail->id], 'method' => 'PUT']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-lg-6 col-md-6">
            {{ Form::label('remarks', 'Remark', ['class' => 'form-label']) }} <span class="text-danger">*</span>
            {{ Form::text('remarks', $grDetail->remarks, ['class' => 'form-control', 'required' => 'required']) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('claim_note', 'Keterangan Klaim', ['class' => 'form-label']) }} <span
                class="text-danger">*</span>
            {{ Form::text('claim_note', $grDetail->claim_note, ['class' => 'form-control', 'required' => 'required']) }}
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{ __('Cancel') }}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Save') }}" class="btn  btn-primary">
</div>
{{ Form::close() }}
