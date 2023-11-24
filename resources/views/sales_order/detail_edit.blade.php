{{ Form::model($so_det, array('route' => array('sales-order.update_detail', $so_det->id), 'method' => 'PATCH')) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            {{ Form::label('qty', __('Quantity'),['class'=>'form-label']) }}<span class="text-danger">*</span>
            {{ Form::number('qty',$so_det->qty, array('class' => 'form-control','required'=>'required')) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('discount', __('Discount'),['class'=>'form-label']) }}
            {{ Form::text('discount',"", array('class' => 'form-control')) }}
        </div>
        <div class="form-group col-md-12">
            {{ Form::label('sale_price', __('Price'),['class'=>'form-label']) }}<span class="text-danger">*</span>
            {{ Form::number('sale_price',$so_det->sale_price, array('class' => 'form-control','required'=>'required')) }}
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Save')}}" class="btn  btn-primary">
</div>
{{Form::close()}}
