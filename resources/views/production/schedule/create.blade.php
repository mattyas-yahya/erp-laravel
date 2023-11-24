{{ Form::open(['route' => ['production.schedule.store'], 'method' => 'POST']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            {{ Form::label('', __('Raw Material ?'), ['class' => 'form-label']) }}
            <div class="form-check custom-checkbox">
                <input type="checkbox" class="form-check-input" name="is_raw_material" value="true" id="check-raw-material">
                <label class="form-check-label" for="check-raw-material">{{ __('Yes') }} </label>
            </div>
        </div>
        <div class="form-group col-md-12">
            {{ Form::label('sales_order_line_id', __('Sales Order'), ['class' => 'form-label']) }} <span
                class="text-danger">*</span>
            <select class="form-control select2" name="sales_order_line_id" id="sales_order_line_id" required>
                <option value=""> </option>
                @foreach ($salesOrderDetails as $salesOrderDetail)
                    <option value="{{ $salesOrderDetail->id }}">{{ $salesOrderDetail->so_number }} -
                        {{ $salesOrderDetail?->gr_from_so?->product_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-12">
            {!! Form::label('customer', __('Customer'), ['class' => 'form-label']) !!}
            {!! Form::text('customer', null, ['class' => 'form-control', 'readonly']) !!}
            {{ Form::hidden('customer_id', '') }}
        </div>

        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('dimensions', __('Dimensions'), ['class' => 'form-label']) }}
                {{ Form::text('dimensions', null, ['class' => 'form-control', 'readonly']) }}
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('coil_number', __('Coil Number'), ['class' => 'form-label']) }}
                {{ Form::text('coil_number', null, ['class' => 'form-control', 'readonly']) }}
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('weight', __('Weight'), ['class' => 'form-label']) }}
                {{ Form::text('weight', null, ['class' => 'form-control', 'readonly']) }}
            </div>
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
                    <option value="{{ $machine->id }}">{{ $machine->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{ __('Cancel') }}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Create') }}" class="btn btn-primary">
</div>
{{ Form::close() }}

<script>
    var customers = {!! $customers->toJson() !!}
    var goodsDetails = {!! $goodsDetails->toJson() !!}

    function setProductionTotal(payload) {
        let result = productionTotalFormula(productionScheduleDetail);

        $('#production_total_text').val(result);
        $('[name="production_total"]').val(result);
    }

    $('#dimension_t').on("keyup", function() {
        productionScheduleDetail.t = this.value;
        setProductionTotal(productionScheduleDetail);
    });

    $('#dimension_l').on("keyup", function() {
        productionScheduleDetail.l = this.value;
        setProductionTotal(productionScheduleDetail);
    });

    $('#dimension_p').on("keyup", function() {
        productionScheduleDetail.p = this.value;
        setProductionTotal(productionScheduleDetail);
    });

    $('#pieces').on("keyup", function() {
        productionScheduleDetail.pieces = this.value;
        setProductionTotal(productionScheduleDetail);
    });

    $('#sales_order_line_id').change(function() {
        const value = this.value;
        var customer = customers.find(customer => customer.sales_order_detail_id == value);
        var goodsDetail = goodsDetails.find(goodsDetail => goodsDetail.sales_order_detail_id == value);

        $('#customer').val(customer.formatted_customer_id);
        $('#dimensions').val(goodsDetail.dimensions);
        $('#coil_number').val(goodsDetail.no_coil);
        $('#weight').val(goodsDetail.weight);
        $('[name="customer_id"]').val(customer.customer_id);
    });
</script>
