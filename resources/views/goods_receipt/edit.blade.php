{{ Form::model($gr, ['route' => ['goods-receipt.update', $gr->id], 'method' => 'PATCH']) }}
<div class="modal-body">
    <div class="row">
        <input type="hidden" name="status" value="{{ $gr->status }}">
        <div class="form-group col-lg-6 col-md-6">
            {{ Form::label('no_sp', __('No. SP'), ['class' => 'form-label']) }}
            {{ Form::text('no_sp', null, ['class' => 'form-control', 'required']) }}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{ Form::label('date_goodscome', __('Goods Come'), ['class' => 'form-label']) }}
            {{ Form::date('date_goodscome', null, ['class' => 'form-control', 'required']) }}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{ Form::label('customers_id', __('Owner'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
            <select class="form-control select" name="customers_id" id="customers_id" required>
                @foreach ($customers as $item)
                    @if (old('customers_id', $gr->customers_id) == $item->id)
                        <option value="{{ $item->id }}" selected>{{ $item->name }}</option>
                    @else
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-12">
            {{ Form::label('description', __('Description')) }}
            {{ Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => __('Enter Description')]) }}
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{ __('Cancel') }}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Update') }}" class="btn  btn-primary">
</div>
{{ Form::close() }}
