{{ Form::open(['route' => ['tms.assignment.store'], 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            {!! Form::label('delivery_order_number', __('Delivery Order Number'), ['class' => 'form-label']) !!}
            {!! Form::text('delivery_order_number', $deliveryWaybillNumberCode, ['class' => 'form-control', 'readonly']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('vehicle_id', __('Vehicle'), ['class' => 'form-label']) !!}
            <select class="form-control select2" name="vehicle_id" id="choices-multiple" required>
                <option value=""> </option>
                @foreach ($vehicles as $item)
                    <option value="{{ $item->id }}">{{ $item->license_plate }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('driver_id', __('Driver'), ['class' => 'form-label']) !!}
            <select class="form-control select2" name="driver_id" id="choices-multiple1" required>
                <option value=""> </option>
                @foreach ($drivers as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('started_at', __('Start Date'), ['class' => 'form-label']) !!}
            <div class="form-icon-user">
                {{ Form::date('started_at', null, ['class' => 'form-control', 'required' => 'required']) }}
            </div>
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('starting_odometer', __('Start Odometer'), ['class' => 'form-label']) !!}
            {!! Form::number('starting_odometer', null, ['class' => 'form-control', 'required', 'autocomplete' => 'off']) !!}
        </div>
        <div class="form-group col-md-12">
            {!! Form::label('comment', __('Comment'), ['class' => 'form-label']) !!}
            <textarea class="form-control" id="comment" name="comment" rows="4"></textarea>
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{ __('Cancel') }}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Create') }}" class="btn btn-primary">
</div>
{{ Form::close() }}

<script></script>
