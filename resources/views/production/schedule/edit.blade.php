{{ Form::model($schedule, ['route' => ['production.schedule.update', $schedule->id], 'method' => 'PUT']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-12">
            {{ Form::label('sales_order', __('Sales Order'), ['class' => 'form-label']) }} <span class="text-danger">*</span>
            @if (in_array($schedule->production_status, [
                App\Domains\Production\ProductionStatusValue::STATUS_PROCESSED,
                App\Domains\Production\ProductionStatusValue::STATUS_FINISHED,
                App\Domains\Production\ProductionStatusValue::STATUS_CANCELED,
            ]))
            {{ Form::text('', $schedule->salesOrderLine?->so_number . " - " . $schedule->salesOrderLine?->gr_from_so?->product_name, ['class' => 'form-control', 'readonly']) }}
            {{ Form::hidden('sales_order_line_id', $schedule->sales_order_line_id) }}
            @else
            <select class="form-control select2" name="sales_order_line_id" id="choices-multiple" required>
                <option value=""> </option>
                @foreach ($salesOrderDetails as $salesOrderDetail)
                    @if (old('sales_order_line_id', $schedule->sales_order_line_id) == $salesOrderDetail->id)
                        <option value="{{ $salesOrderDetail->id }}" selected>{{ $salesOrderDetail->so_number }} - {{ $salesOrderDetail?->gr_from_so?->product_name }}</option>
                    @else
                        <option value="{{ $salesOrderDetail->id }}">{{ $salesOrderDetail->so_number }} - {{ $salesOrderDetail?->gr_from_so?->product_name }}</option>
                    @endif
                @endforeach
            </select>
            @endif
        </div>

        <div class="form-group col-md-12">
            {!! Form::label('customer', __('Customer'), ['class' => 'form-label']) !!}
            {!! Form::text('customer', Auth::user()->customerNumberFormat($schedule->customer_id), ['class' => 'form-control', 'readonly']) !!}
            {{ Form::hidden('customer_id', $schedule->customer_id) }}
        </div>

        <div class="form-group col-lg-6 col-md-6">
            {{ Form::label('production_date', __('Production Date'), ['class' => 'form-label']) }} <span
                class="text-danger">*</span>
            {{ Form::date('production_date', null, ['class' => 'form-control', 'required']) }}
        </div>

        <div class="form-group col-lg-6 col-md-6">
            {{ Form::label('machine_id', __('Machine'), ['class' => 'form-label']) }}
            <select class="form-control select2" name="machine_id" id="machine_id">
                <option value=""> </option>
                @foreach ($machines as $machine)
                    @if (old('machine_id', $schedule->machine_id) == $machine->id)
                        <option value="{{ $machine->id }}" selected>{{ $machine->name }}</option>
                    @else
                        <option value="{{ $machine->id }}">{{ $machine->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>

        <div class="form-group col-lg-6 col-md-6">
            {{ Form::label('production_status', __('Production Status'), ['class' => 'form-label']) }} <span class="text-danger">*</span>
            <select class="form-control" name="production_status" id="production_status" required>
                @foreach ($productionStatusValues as $status)
                    <option value="{{ $status }}" @if (old('production_status', $schedule->production_status) == $status) selected @endif>{{ $status }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{ __('Cancel') }}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Update') }}" class="btn  btn-primary">
</div>
{{ Form::close() }}

<script>
    var customers = {!! $customers->toJson() !!}

    $('#sales_order_line_id').change(function() {
        const value = this.value;
        var customer = customers.find(customer => customer.sales_order_detail_id == value);

        $('#customer').val(customer.formatted_customer_id);
        $('[name="customer_id"]').val(customer.customer_id);
    });
</script>
