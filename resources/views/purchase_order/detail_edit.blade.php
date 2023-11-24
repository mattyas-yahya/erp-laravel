{{ Form::model($po_det, ['route' => ['purchase-order.update_detail', $po_det->id], 'method' => 'PATCH']) }}
<div class="modal-body">
    <div class="row">

        <div class="form-group col-md-6">
            {{ Form::label('qty', __('Quantity'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
            {{ Form::number('qty', $po_det->qty, ['class' => 'form-control', 'required' => 'required']) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('discount', __('Discount'), ['class' => 'form-label']) }}
            {{ Form::text('discount', '', ['class' => 'form-control']) }}
        </div>
        <div class="form-group col-md-12">
            {{ Form::label('price', __('Price'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
            {{ Form::number('price', $po_det->price, ['class' => 'form-control', 'required' => 'required', 'step' => '0.01']) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('tax', __('Tax'), ['class' => 'form-label']) }}
            <br />
            {{ Form::label('tax_ppn', __('PPN'), ['class' => 'form-label']) }}
            {{ Form::checkbox('tax_ppn', 'true') }}
            <br />
            {{ Form::label('tax_pph', __('PPh'), ['class' => 'form-label']) }}
            {{ Form::checkbox('tax_pph', 'true') }}
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{ __('Cancel') }}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Save') }}" class="btn  btn-primary">
</div>
{{ Form::close() }}
