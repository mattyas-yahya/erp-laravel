{{ Form::model($vehicle, ['route' => ['tms.vehicle.update', $vehicle->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
<div class="modal-body">
    <div class="row">
        <h6>Informasi Umum</h6>
        <br />
        <br />
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('branch_id', __('Branch'), ['class' => 'form-label']) }}
                <select class="form-control select" name="branch_id" id="branch_id" placeholder="Select Branch" required>
                    <option value="">{{ __('Select Branch') }}</option>
                    <option value="0">{{ __('All Branch') }}</option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('hull_number', __('Nomor Lambung'), ['class' => 'form-label']) !!}
            {!! Form::text('hull_number', null, ['class' => 'form-control', 'required']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('license_plate', __('Nopol'), ['class' => 'form-label']) !!}
            {!! Form::text('license_plate', null, ['class' => 'form-control', 'required']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('image', __('Vehicle Image'), ['class' => 'form-label']) !!}
            <div class="choose-file">
                <label for="file" class="form-label">
                    <input type="file" name="image" class="form-control" accept=".png, .jpg, jpeg">
                </label>
                <p class="upload_file"></p>
            </div>
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('active', __('Active'), ['class' => 'form-label']) }}
            <br />
            {{ Form::checkbox('active', 'true') }}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('inactive_reason', __('Alasan Tidak Aktif'), ['class' => 'form-label']) !!}
            {!! Form::text('inactive_reason', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
    <hr />
    <div class="row">
        <h6>Fisik</h6>
        <br />
        <br />
        <div class="form-group col-md-6">
            {!! Form::label('model', __('Model'), ['class' => 'form-label']) !!}
            {!! Form::text('model', null, ['class' => 'form-control', 'required']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('chassis_number', __('Chassis Number'), ['class' => 'form-label']) !!}
            {!! Form::text('chassis_number', null, ['class' => 'form-control', 'required']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('engine_number', __('Engine Number'), ['class' => 'form-label']) !!}
            {!! Form::text('engine_number', null, ['class' => 'form-control', 'required']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('color', __('Color'), ['class' => 'form-label']) !!}
            {!! Form::text('color', null, ['class' => 'form-control', 'required']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('imei_number', __('Imei Number'), ['class' => 'form-label']) !!}
            {!! Form::text('imei_number', null, ['class' => 'form-control', 'required']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('fuel_capacity', __('Fuel Capacity'), ['class' => 'form-label']) !!}
            {!! Form::text('fuel_capacity', null, ['class' => 'form-control', 'required']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('fuel_usage_ratio', __('Fuel Usage Ratio'), ['class' => 'form-label']) !!}
            {!! Form::text('fuel_usage_ratio', null, ['class' => 'form-control', 'required']) !!}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('internal', __('Internal'), ['class' => 'form-label']) }}
            <br />
            {{ Form::checkbox('internal', 'true') }}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('vehicle_owner', __('Vehicle Owner'), ['class' => 'form-label']) !!}
            {!! Form::text('vehicle_owner', null, ['class' => 'form-control', 'required']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('manufacturer_year', __('Manufacturer Year'), ['class' => 'form-label']) !!}
            {!! Form::text('manufacturer_year', null, ['class' => 'form-control', 'required']) !!}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('start_operation_date', __('Start Operation Date'), ['class' => 'form-label']) }}
            {{ Form::date('start_operation_date', '', ['class' => 'form-control ']) }}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('spare_tire_capacity', __('Spare Tire Capacity'), ['class' => 'form-label']) !!}
            {!! Form::text('spare_tire_capacity', null, ['class' => 'form-control', 'required']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('kilometer_setting', __('Kilometer Setting'), ['class' => 'form-label']) !!}
            {!! Form::text('kilometer_setting', null, ['class' => 'form-control', 'required']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('daily_travel_distance', __('Daily Travel Distance'), ['class' => 'form-label']) !!}
            {!! Form::text('daily_travel_distance', null, ['class' => 'form-control', 'required']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('gps_gsm_number', __('Gps Gsm Number'), ['class' => 'form-label']) !!}
            {!! Form::text('gps_gsm_number', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
    <hr />
    <div class="row">
        <h6>Dokumen</h6>
        <br />
        <br />
        <div class="form-group col-md-6">
            {!! Form::label('stnk_number', __('Stnk Number'), ['class' => 'form-label']) !!}
            {!! Form::text('stnk_number', null, ['class' => 'form-control', 'required']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('stnk_owner_name', __('Stnk Owner Name'), ['class' => 'form-label']) !!}
            {!! Form::text('stnk_owner_name', null, ['class' => 'form-control', 'required']) !!}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('stnk_validity_period', __('Stnk Validity Period'), ['class' => 'form-label']) }}
            {{ Form::date('stnk_validity_period', '', ['class' => 'form-control ']) }}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('stnk_owner_address', __('Stnk Owner Address'), ['class' => 'form-label']) !!}
            {!! Form::text('stnk_owner_address', null, ['class' => 'form-control', 'required']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('bpkb_number', __('Bpkb Number'), ['class' => 'form-label']) !!}
            {!! Form::text('bpkb_number', null, ['class' => 'form-control', 'required']) !!}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('last_kir_date', __('Last Kir Date'), ['class' => 'form-label']) }}
            {{ Form::date('last_kir_date', '', ['class' => 'form-control ']) }}
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{ __('Cancel') }}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Update') }}" class="btn btn-primary">
</div>
{{ Form::close() }}

<script></script>
