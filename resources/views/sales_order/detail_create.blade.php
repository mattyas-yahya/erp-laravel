{{ Form::open(['route' => 'sales-order.store_detail', 'method' => 'post']) }}
<div class="modal-body">
    <div class="row">
        <input type="hidden" name="so_id" value="{{ $so->id }}">
        <div class="form-group col-lg-6 col-md-6">
            {{ Form::label('so_number', __('SO Number'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
            {{ Form::text('so_number', $so->so_number, ['class' => 'form-control', 'readonly']) }}
        </div>

        <div class="form-group  col-md-12">
            {{ Form::label('goods_receipt_details_id', __('SPEC'), ['class' => 'form-label']) }}<span
                class="text-danger">*</span>
            <select class="form-control select2" name="goods_receipt_details_id" id="choices-multiple" required>
                <option value=""> </option>
                @foreach ($dataproduct as $item)
                    <option value="{{ $item->id }}">{{ $item->product_name }} ( {{ $item->dimensions }} ) |
                        {{ $item->no_coil ?? '-' }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-lg-6 col-md-6">
            {{ Form::label('id_sjb', __('ID_SJB'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
            {{ Form::text('id_sjb', null, ['class' => 'form-control', 'readonly']) }}
        </div>

        <div class="form-group col-lg-6 col-md-6">
            {{ Form::label('no_coil', __('No. Coil'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
            {{ Form::text('no_coil', null, ['class' => 'form-control', 'readonly']) }}
        </div>

        <div class="form-group col-lg-6 col-md-6">
            {{ Form::label('weight', __('Weight'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
            {{ Form::text('weight', null, ['class' => 'form-control', 'readonly']) }}
        </div>

        <div class="form-group col-lg-6 col-md-6">
            {{ Form::label('sale_price', __('Sale Price'), ['class' => 'form-label']) }}<span
                class="text-danger">*</span>
            {{ Form::number('sale_price', null, ['class' => 'form-control', 'required']) }}
        </div>

        <div class="form-group col-lg-6 col-md-6">
            {{ Form::label('qty', __('Qty'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
            {{ Form::text('qty', null, ['class' => 'form-control', 'required']) }}
        </div>

        <div class="form-group col-md-6">
            {{ Form::label('unit', __('Unit'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
            <select class="form-control" name="unit" required>
                <option value=""> </option>
                @foreach ($unit as $item)
                    <option value="{{ $item }}">{{ $item }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-lg-6 col-md-6">
            {{ Form::label('production', __('Production'), ['class' => 'form-label']) }}
            <select class="form-control" name="production" required>
                <option value=""> </option>
                @foreach ($dataproduction as $item)
                    <option value="{{ $item }}">{{ $item }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-6">
            {{ Form::label('discount', __('Discount'), ['class' => 'form-label']) }}
            {{ Form::text('discount', 0, ['class' => 'form-control']) }}
        </div>

        <div class="form-group col-md-6">
            {{ Form::label('tax', __('Tax'), ['class' => 'form-label']) }}
            <br />
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="tax_ppn" value="true" id="checkboxTaxPpn">
                <label class="form-check-label" for="checkboxTaxPpn">
                    {{ __('PPN') }}
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="tax_pph" value="true" id="checkboxTaxPph">
                <label class="form-check-label" for="checkboxTaxPph">
                    {{ __('PPh') }}
                </label>
            </div>
        </div>

        <div class="form-group col-md-12">
            {{ Form::label('description', __('Description')) }}
            {{ Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => __('Enter Description')]) }}
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{ __('Cancel') }}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Create') }}" class="btn btn-primary">
</div>
{{ Form::close() }}

<script>
    $('#choices-multiple').change(function() {
        var grDetail = this.value;
        $.ajax({
            url: "{{ url('sales-order/getgrDetail/json') }}",
            type: "POST",
            data: {
                goods_receipt_details_id: grDetail,
                _token: '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function(result) {
                if (grDetail) {
                    $('#id_sjb').val(result.grDetail.sku_number);
                    $('#no_coil').val(result.grDetail.no_coil);
                    $('#weight').val(result.grDetail.weight);
                } else {
                    $('#id_sjb').val('');
                    $('#no_coil').val('');
                    $('#weight').val('');
                }
            }
        });
    });
</script>
