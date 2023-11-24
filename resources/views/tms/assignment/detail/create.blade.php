{{ Form::open(['route' => ['tms.assignment.detail.store', $assignment->id], 'method' => 'POST']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            {{ Form::label('customer_id', __('Konsumen'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
            <select class="form-control select2" name="customer_id" id="choices-multiple" required>
                <option value=""> </option>
                @foreach ($customers as $item)
                    <option value="{{ $item->id }}">{{ Auth::user()->customerNumberFormat($item->customer_id) }}
                        {{ $item->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('', __('Sales Order'), ['class' => 'form-label']) }} <span class="text-danger">*</span>
            <select class="form-control select2" name="sales_order_detail_id" id="sales_order_detail_id" required>
                <option value=""> </option>
                @foreach ($salesOrderDetails as $salesOrderDetail)
                    <option value="{{ $salesOrderDetail->id }}">{{ $salesOrderDetail->so_number }} - {{ $salesOrderDetail?->gr_from_so?->product_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('spec', __('Spec'), ['class' => 'form-label']) }}
                {{ Form::text('spec', null, ['class' => 'form-control', 'readonly']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('qty', __('Jumlah'), ['class' => 'form-label']) }}
                {{ Form::text('qty', null, ['class' => 'form-control', 'readonly']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('unit', __('Unit'), ['class' => 'form-label']) }}
                {{ Form::text('unit', null, ['class' => 'form-control', 'readonly']) }}
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{ __('Cancel') }}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Create') }}" class="btn btn-primary">
</div>
{{ Form::close() }}
