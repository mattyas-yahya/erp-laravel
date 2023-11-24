{{ Form::open(['url' => 'purchase-order/store', 'method' => 'post']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group  col-md-12">
            {{ Form::label('vender', __('Vender'), ['class' => 'form-label']) }} <span class="text-danger">*</span>
            <select class="form-control select2" name="vender_id" id="choices-multiple" required>
                <option value=""> </option>
                @foreach ($vender as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
            <div class=" text-xs">
                {{ __('Create New Vendor') }} <a href="{{ route('vender.index') }}"><b>{{ __('Add Vendor') }}</b></a>
            </div>
        </div>

        <div class="form-group col-lg-6 col-md-6">
            {{ Form::label('no_kontrak', __('No. Kontrak'), ['class' => 'form-label']) }} <span class="text-danger">*</span>
            {{ Form::text('no_kontrak', null, ['class' => 'form-control', 'required']) }}
        </div>

        <div class="form-group col-lg-6 col-md-6">
            {{ Form::label('warehouse_id', __('Warehouse'), ['class' => 'form-label']) }} <span class="text-danger">*</span>
            <select class="form-control select" name="warehouse_id" id="warehouse_id" required>
                <option value="">{{ __('Select Warehouse') }}</option>
                @foreach ($warehouse as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-lg-6 col-md-6">
            {{ Form::label('pr_id', __('Purchase request'), ['class' => 'form-label']) }}
            <select class="form-control select" name="pr_id" id="pr_id">
                <option value=""> </option>
                @foreach ($pr as $item)
                    <option value="{{ $item->id }}">{{ $item->pr_number }} - {{ $item->name }} -
                        {{ $item->employee()->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-lg-6 col-md-6">
            {{ Form::label('send_date', __('Estimated Delivery Date'), ['class' => 'form-label']) }} <span
                class="text-danger">*</span>
            {{ Form::date('send_date', null, ['class' => 'form-control', 'required']) }}
        </div>

        <div class="form-group col-lg-6 col-md-6">
            {{ Form::label('payment_term_id', __('Payment Terms'), ['class' => 'form-label']) }}<span
                class="text-danger">*</span>
            <select class="form-control select" name="payment_term_id" id="payment_term_id" required>
                <option value="">{{ __('Payment Terms') }}</option>
                @foreach ($terms as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
            <div class=" text-xs">
                {{ __('Create New Payment Terms') }} <a
                    href="{{ route('payment-term.index') }}"><b>{{ __('Add Payment Terms') }}</b></a>
            </div>
        </div>

        <div class="form-group col-lg-6 col-md-6">
            {{ Form::label('category_id', __('Category'), ['class' => 'form-label']) }} <span class="text-danger">*</span>
            <select class="form-control select" name="category_id" id="category_id" required>
                <option value="">{{ __('Select Category') }}</option>
                @foreach ($categories as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-lg-12 col-md-12">
            {{ Form::label('note', __('Note'), ['class' => 'form-label']) }}
            {{ Form::text('note', null, ['class' => 'form-control', 'required']) }}
        </div>

        <div class="form-group col-md-12">
            {{ Form::label('description', __('Description'), ['class' => 'form-label']) }}
            {{ Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => __('Enter Description')]) }}
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{ __('Cancel') }}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Create') }}" class="btn  btn-primary">
</div>
{{ Form::close() }}
