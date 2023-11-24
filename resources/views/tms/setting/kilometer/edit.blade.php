{{ Form::model($kilometer, ['route' => ['tms.setting.kilometer.update', $kilometer->id], 'method' => 'PUT']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            {!! Form::label('tms_vehicle_id', __('Vehicle'), ['class' => 'form-label']) !!}
            <select class="form-control select2" name="tms_vehicle_id" id="choices-multiple" required>
                <option value=""> </option>
                @foreach ($vehicles as $item)
                    <option value="{{ $item->id }}" @if ($item->id == $kilometer->tms_vehicle_id) selected @endif>{{ $item->license_plate }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('travel_date', __('Tanggal Tempuh'), ['class' => 'form-label']) !!}
            <div class="form-icon-user">
                {{ Form::date('travel_date', null, ['class' => 'form-control', 'required' => 'required']) }}
            </div>
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('travel_kilometers', __('Kilometer Tempuh'), ['class' => 'form-label']) !!}
            {!! Form::number('travel_kilometers', null, ['class' => 'form-control', 'required', 'autocomplete' => 'off']) !!}
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{ __('Cancel') }}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Update') }}" class="btn btn-primary">
</div>
{{ Form::close() }}
