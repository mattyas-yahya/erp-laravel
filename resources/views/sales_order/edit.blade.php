{{Form::model($so,array('route' => array('sales-order.update', $so->id), 'method' => 'PATCH')) }}
<div class="modal-body">
    <div class="row">
        {{-- <input type="hidden" name="status" value="{{ $so->status }}"> --}}
        <div class="form-group  col-md-12">
            {{ Form::label('customer_id', __('Konsumen'),['class'=>'form-label']) }}<span class="text-danger">*</span>
            <select class="form-control select2" name="customer_id" id="choices-multiple" required>
                <option value="">  </option>
                @foreach($customers as $item)
                @if (old('customer_id', $so->customer_id == $item->id))                    
                <option value="{{ $item->id }}" selected>{{ $item->name }}</option>
                @else                
                <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endif
                @endforeach
            </select>
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('warehouse_id',__('Warehouse'),['class'=>'form-label'])}}
            <select class="form-control select" name="warehouse_id" id="warehouse_id" required>
                <option value="">{{__('Select Warehouse')}}</option>
                @foreach($warehouse as $item)
                @if(old('warehouse_id', $so->warehouse_id) == $item->id)
                <option value="{{ $item->id }}" selected>{{ $item->name }}</option>
                @else
                <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endif
                @endforeach
            </select>
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('reff_po_cust',__('Reff PO Cust'),['class'=>'form-label'])}}
            {{Form::text('reff_po_cust',null,array('class'=>'form-control','required'))}}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('date_order',__('Order Date'),['class'=>'form-label'])}}
            {{Form::date('date_order',null,array('class'=>'form-control', 'required'))}}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('employee_id',__('Employee'),['class'=>'form-label'])}}<span class="text-danger">*</span>
            <select class="form-control select" name="employee_id" id="employee_id" required>
                <option value="">{{__('Select Employee')}}</option>
                @foreach($employees as $item)
                @if (old('employee_id', $so->employee_id) == $item->id)                
                <option value="{{ $item->id }}" selected>{{ $item->name }}</option>    
                @else
                <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endif
                @endforeach
            </select>
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('payment_term_id',__('Payment Terms'),['class'=>'form-label'])}}<span class="text-danger">*</span>
            <select class="form-control select" name="payment_term_id" id="payment_term_id" required>
                <option value="">{{__('Select')}}</option>
                @foreach($terms as $item)
                @if (old('payment_term_id', $so->payment_term_id) == $item->id)
                <option value="{{ $item->id }}" selected>{{ $item->name }}</option>
                @else
                <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endif
                @endforeach
            </select>
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('delivery',__('Delivery'),['class'=>'form-label'])}}
            {{Form::text('delivery',null,array('class'=>'form-control','required'))}}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('product_service_category_id',__('Category'),['class'=>'form-label'])}}<span class="text-danger">*</span>
            <select class="form-control select" name="product_service_category_id" id="product_service_category_id" required>
                <option value="">{{__('Select')}}</option>
                @foreach($category as $item)
                @if (old('product_service_category_id', $so->product_service_category_id) == $item->id)                
                <option value="{{ $item->id }}" selected>{{ $item->name }}</option>
                @else
                <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endif
                @endforeach
            </select>
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('status',__('Status'),['class'=>'form-label'])}}<span class="text-danger">*</span>
            <select class="form-control select" name="status" id="status" required>
                <option value="Booking" {{($so->status == 'Booking')? 'selected':'' }}>Booking</option>
                <option value="Deal" {{($so->status == 'Deal')? 'selected':'' }}>Deal</option>
                <option value="Production" {{($so->status == 'Production')? 'selected':'' }}>Production</option>
                <option value="Delivery" {{($so->status == 'Delivery')? 'selected':'' }}>Delivery</option>
                <option value="Done" {{($so->status == 'Done')? 'selected':'' }}>Done</option>
            </select>
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Update')}}" class="btn  btn-primary">
</div>
{{ Form::close() }}