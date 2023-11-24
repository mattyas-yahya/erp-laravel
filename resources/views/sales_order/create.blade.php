{{ Form::open(['url' => 'sales-order/store', 'method' => 'post']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group  col-md-12">
            {{ Form::label('customer_id', __('Konsumen'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
            <select class="form-control select2" name="customer_id" id="choices-multiple" required>
                <option value=""> </option>
                @foreach ($customers as $item)
                    <option value="{{ $item->id }}">{{ Auth::user()->customerNumberFormat($item->customer_id) }}
                        {{ $item->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-lg-6 col-md-6">
            {{ Form::label('warehouse_id', __('Warehouse'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
            <select class="form-control select" name="warehouse_id" id="warehouse_id" required>
                <option value="">{{ __('Select Warehouse') }}</option>
                @foreach ($warehouse as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-lg-6 col-md-6">
            {{ Form::label('reff_po_cust', __('Reff PO Cust'), ['class' => 'form-label']) }}
            {{ Form::text('reff_po_cust', null, ['class' => 'form-control', 'required']) }}
        </div>

        <div class="form-group col-lg-6 col-md-6">
            {{ Form::label('date_order', __('Order Date'), ['class' => 'form-label']) }}
            {{ Form::date('date_order', null, ['class' => 'form-control', 'required']) }}
        </div>

        <div class="form-group col-lg-6 col-md-6">
            {{ Form::label('employee_id', __('Marketing'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
            <select class="form-control select" name="employee_id" id="employee_id" required>
                <option value="">{{ __('Select Employee') }}</option>
                @foreach ($employees as $item)
                    <option value="{{ $item->id }}" @if (\Auth::user()->type != 'company') selected @endif>{{ $item->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-lg-6 col-md-6">
            {{ Form::label('payment_term_id', __('Payment Terms'), ['class' => 'form-label']) }}<span
                class="text-danger">*</span>
            <select class="form-control select" name="payment_term_id" id="payment_term_id" required>
                <option value="">{{ __('Select') }}</option>
                @foreach ($terms as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-lg-6 col-md-6">
            {{ Form::label('delivery', __('Delivery'), ['class' => 'form-label']) }}
            <select class="form-control select" name="delivery" id="delivery" required>
                <option value="">{{ __('Select') }}</option>
                @foreach ($delivery as $item)
                    <option value="{{ $item }}">{{ $item }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-lg-6 col-md-6">
            {{ Form::label('product_service_category_id', __('Category'), ['class' => 'form-label']) }}<span
                class="text-danger">*</span>
            <select class="form-control select" name="product_service_category_id" id="product_service_category_id"
                required>
                <option value="">{{ __('Select') }}</option>
                @foreach ($category as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-lg-6 col-md-6">
            {{ Form::label('status', __('Status'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
            <select class="form-control select" name="status" id="status" required>
                <option value="Booking">Booking</option>
                <option value="Deal">Deal</option>
                <option value="Production">Production</option>
                <option value="Delivery">Delivery</option>
                <option value="Done">Done</option>
            </select>
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{ __('Cancel') }}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Create') }}" class="btn  btn-primary">
</div>
{{ Form::close() }}
