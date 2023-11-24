{{ Form::model($gr_det, ['route' => ['goods-receipt.update_detail', $gr_det->id], 'method' => 'PATCH', 'enctype' => 'multipart/form-data']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-lg-6 col-md-6">
            {{ Form::label('sku_number', __('ID_SJB'), ['class' => 'form-label']) }} <span class="text-danger">*</span>
            {{ Form::text('sku_number', $gr_det->sku_number, ['class' => 'form-control', 'required' => 'required']) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('no_coil', __('No. Coil'), ['class' => 'form-label']) }} <span class="text-danger">*</span>
            {{ Form::text('no_coil', $gr_det->no_coil, ['class' => 'form-control', 'required' => 'required']) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('actual_thick', __('Actual Thick'), ['class' => 'form-label']) }} <span
                class="text-danger">*</span>
            {{ Form::number('actual_thick', null, ['class' => 'form-control ', 'required' => 'required', 'step' => '0.01']) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('goods_location', __('Goods Location'), ['class' => 'form-label']) }} <span
                class="text-danger">*</span>
            {{ Form::text('goods_location', $gr_det->goods_location, ['class' => 'form-control', 'required' => 'required']) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('qty', __('Quantity'), ['class' => 'form-label']) }} <span
                class="text-danger">*</span>
            {{ Form::text('qty', $gr_det->qty, ['class' => 'form-control', 'required' => 'required']) }}
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            {{ Form::label('upload_certificate', __('Upload Certificate'),['class'=>'form-label']) }}
            <input type="file" class="form-control" name="upload_certificate" id="upload_certificate">
        </div>

        <div class="form-group col-md-6">
            {{ Form::label('code_certificate', __('Code Certificate'), ['class' => 'form-label']) }}
            {{ Form::text('code_certificate', $gr_det->code_certificate, ['class' => 'form-control']) }}
        </div>

        @if($gr_det->upload_certificate)
        <div class="form-group col-md-6">
            {{ Form::label('certificate', __('Certificate'),['class'=>'form-label']) }}
                <h5><a href="{{ Storage::url('uploads/goods_receipt_certificate/' + $gr_det->upload_certificate) }}">{{ __('See certificate') }}</a></h5>
        </div>
        @endif
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{ __('Cancel') }}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Save') }}" class="btn  btn-primary">
</div>
{{ Form::close() }}
