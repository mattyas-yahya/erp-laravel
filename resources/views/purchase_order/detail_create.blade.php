{{ Form::open(['route' => 'purchase-order.store_detail', 'method' => 'post']) }}
<div class="modal-body">
    <div class="row">
        <input type="hidden" name="po_id" value="{{ $po->id }}">
        <input type="hidden" name="pr_id" value="{{ $po->pr_id }}">
        <input type="hidden" name="no_kontrak" value="{{ $po->no_kontrak }}">
        <div class="form-group col-lg-6 col-md-6">
            {{ Form::label('po_number', __('PO Number'), ['class' => 'form-label']) }}
            {{ Form::text('po_number', $po->po_number, ['class' => 'form-control', 'readonly']) }}
        </div>

        <div class="form-group  col-md-12">
            {{ Form::label('existing', __('Existing Product'), ['class' => 'form-label']) }}
            <select class="form-control select2" name="product_services_id" id="choices-multiple">
                <option value=""> </option>
                @foreach ($dataproduct as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-lg-6 col-md-6">
            {{ Form::label('sku_number', __('SKU'), ['class' => 'form-label']) }}
            {{ Form::text('sku_number', '-', ['class' => 'form-control', 'readonly']) }}
        </div>

        <div class="form-group col-lg-6 col-md-6">
            {{ Form::label('product_name', __('Product Name'), ['class' => 'form-label']) }}
            {{ Form::text('product_name', null, ['class' => 'form-control']) }}
            <p><i>*{{ __('new products written immediately') }}</i></p>
        </div>

        <div class="form-group col-lg-6 col-md-6">
            {{ Form::label('qty', __('Qty'), ['class' => 'form-label']) }}
            {{ Form::number('qty', null, ['class' => 'form-control', 'required']) }}
        </div>

        <div class="form-group col-lg-6 col-md-6">
            {{ Form::label('unit', __('Unit'), ['class' => 'form-label']) }}
            <select class="form-control select" name="unit_id" id="unit_id">
                @foreach ($unit as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('dimensions', __('Dimensions'), ['class' => 'form-label']) }}<span
                    class="text-danger">*</span>
                {{ Form::text('dimensions', null, ['class' => 'form-control']) }}
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('manufacture', __('Manufacture'), ['class' => 'form-label']) }}<span
                    class="text-danger">*</span>
                {{ Form::text('manufacture', null, ['class' => 'form-control']) }}
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('weight', __('Weight'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
                {{ Form::text('weight', null, ['class' => 'form-control']) }}
            </div>
        </div>

        <div class="form-group col-md-6">
        </div>

        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('price', __('Price'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
                {{ Form::text('price', null, ['class' => 'form-control', 'required']) }}
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('discount', __('Discount'), ['class' => 'form-label']) }}
                {{ Form::text('discount', null, ['class' => 'form-control']) }}
            </div>
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

        <div class="form-group col-md-12">
            {{ Form::label('description', __('Description')) }}
            {{ Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => __('Enter Description')]) }}
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{ __('Cancel') }}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Create') }}" class="btn  btn-primary">
</div>
{{ Form::close() }}


<script>
    $('#choices-multiple').change(function() {
        var productservice = this.value;
        console.log(productservice);
        $.ajax({
            url: "{{ url('purchase-request/getproductservice/json') }}",
            type: "POST",
            data: {
                product_services_id: productservice,
                _token: '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function(result) {
                if (productservice) {
                    console.log(result.productservice);
                    $('#sku_number').val(result.productservice.sku);
                    $('#product_name').val(result.productservice.name);
                    $('#unit_id').val(result.productservice.unit_id);
                    $('#dimensions').val(result.productservice.dimensions);
                    $('#price').val(result.productservice.purchase_price);
                    $('#manufacture').val(result.productservice.manufacture);
                    $('#weight').val(result.productservice.weight);
                } else {
                    $('#sku_number').val('-');
                    $('#product_name').val('');
                    $('#unit_id').val('');
                    $('#dimensions').val('');
                    $('#price').val('');
                    $('#manufacture').val('');
                    $('#weight').val('');
                }
            }
        });
    });
</script>
