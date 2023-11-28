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
                    <option value="0" @if ($vehicle->branch_id == 0) selected @endif>{{ __('All Branch') }}</option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}" @if ($vehicle->branch_id == $branch->id) selected @endif>{{ $branch->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('type', __('Type'), ['class' => 'form-label']) }}
                <select class="form-control select" name="type" id="type" placeholder="Select Type"
                    required>
                    <option value="">{{ __('Select Type') }}</option>
                    <option value="TRANSPORTASI" @if ($vehicle->type == 'TRANSPORTASI') selected @endif>Transportasi</option>
                    <option value="ALAT_TONASE" @if ($vehicle->type == 'ALAT_TONASE') selected @endif>Alat Tonase</option>
                    <option value="FORKLIFT" @if ($vehicle->type == 'FORKLIFT') selected @endif>Forklift</option>
                </select>
            </div>
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('hull_number', __('No. Lambung'), ['class' => 'form-label']) !!}
            {!! Form::text('hull_number', null, ['class' => 'form-control', 'required']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('license_plate', __('Nopol'), ['class' => 'form-label']) !!}
            {!! Form::text('license_plate', null, ['class' => 'form-control', 'required']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('owner_id', __('Pemilik Kendaraan'), ['class' => 'form-label']) !!}
            <select class="form-control select2" name="owner_id" id="vender-options" required>
                <option value=""></option>
                @foreach ($venders as $vender)
                    <option value="{{ $vender->id }}" @if ($vehicle->owner_id == $vender->id) selected @endif>{{ $vender->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('image', __('Foto'), ['class' => 'form-label']) !!}
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
            {{ Form::checkbox('active', 'true', $vehicle->active) }}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('inactive_reason', __('Alasan Tidak Aktif'), ['class' => 'form-label']) !!}
            {!! Form::text('inactive_reason', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <hr />
    <div class="row">
        <h6>Fisik</h6>
        <br />
        <br />
        <div class="form-group col-md-6">
            {!! Form::label('model', __('Model'), ['class' => 'form-label']) !!}
            {!! Form::text('model', $vehiclePhysical->model, ['class' => 'form-control', 'required']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('chassis_number', __('No. Rangka'), ['class' => 'form-label']) !!}
            {!! Form::text('chassis_number', $vehiclePhysical->chassis_number, ['class' => 'form-control', 'required']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('engine_number', __('No. Mesin'), ['class' => 'form-label']) !!}
            {!! Form::text('engine_number', $vehiclePhysical->engine_number, ['class' => 'form-control', 'required']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('color', __('Warna'), ['class' => 'form-label']) !!}
            {!! Form::text('color', $vehiclePhysical->color, ['class' => 'form-control', 'required']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('imei_number', __('No. IMEI'), ['class' => 'form-label']) !!}
            {!! Form::text('imei_number', $vehiclePhysical->imei_number, ['class' => 'form-control', 'required']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('fuel_capacity', __('Kapasitas BBM'), ['class' => 'form-label']) !!}
            {!! Form::text('fuel_capacity', $vehiclePhysical->fuel_capacity, ['class' => 'form-control', 'required']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('fuel_usage_ratio', __('Rasio Penggunaan BBM'), ['class' => 'form-label']) !!}
            {!! Form::text('fuel_usage_ratio', $vehiclePhysical->fuel_usage_ratio, ['class' => 'form-control', 'required']) !!}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('internal', __('Internal'), ['class' => 'form-label']) }}
            <br />
            {{ Form::checkbox('internal', 'true', $vehiclePhysical->internal) }}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('manufacturer_year', __('Tahun Pembuatan'), ['class' => 'form-label']) !!}
            {!! Form::text('manufacturer_year', $vehiclePhysical->manufacturer_year, ['class' => 'form-control', 'required']) !!}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('start_operation_date', __('Tgl Mulai Operasi'), ['class' => 'form-label']) }}
            {{ Form::date('start_operation_date', $vehiclePhysical->start_operation_date, ['class' => 'form-control ']) }}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('spare_tire_capacity', __('Kapasitas Ban Serep'), ['class' => 'form-label']) !!}
            {!! Form::text('spare_tire_capacity', $vehiclePhysical->spare_tire_capacity, ['class' => 'form-control', 'required']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('kilometer_setting', __('Setting KM'), ['class' => 'form-label']) !!}
            {!! Form::text('kilometer_setting', $vehiclePhysical->kilometer_setting, ['class' => 'form-control', 'required']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('daily_travel_distance', __('Jarak Tempuh Harian'), ['class' => 'form-label']) !!}
            {!! Form::text('daily_travel_distance', $vehiclePhysical->daily_travel_distance, ['class' => 'form-control', 'required']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('gps_gsm_number', __('No. GSM GPS'), ['class' => 'form-label']) !!}
            {!! Form::text('gps_gsm_number', $vehiclePhysical->gps_gsm_number, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
    <hr />
    <div class="row">
        <h6>Dokumen</h6>
        <br />
        <br />
        <div class="form-group col-md-6">
            {!! Form::label('stnk_number', __('No. STNK'), ['class' => 'form-label']) !!}
            {!! Form::text('stnk_number', $vehicleDocument->stnk_number, ['class' => 'form-control', 'required']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('stnk_owner_name', __('Nama STNK'), ['class' => 'form-label']) !!}
            {!! Form::text('stnk_owner_name', $vehicleDocument->stnk_owner_name, ['class' => 'form-control', 'required']) !!}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('stnk_validity_period', __('Masa Berlaku STNK'), ['class' => 'form-label']) }}
            {{ Form::date('stnk_validity_period', $vehicleDocument->stnk_validity_period, ['class' => 'form-control ']) }}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('stnk_owner_address', __('Alamat STNK'), ['class' => 'form-label']) !!}
            {!! Form::text('stnk_owner_address', $vehicleDocument->stnk_owner_address, ['class' => 'form-control', 'required']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('bpkb_number', __('No. BPKB'), ['class' => 'form-label']) !!}
            {!! Form::text('bpkb_number', $vehicleDocument->bpkb_number, ['class' => 'form-control', 'required']) !!}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('last_kir_date', __('Tgl. KIR Terakhir'), ['class' => 'form-label']) }}
            {{ Form::date('last_kir_date', $vehicleDocument->last_kir_date, ['class' => 'form-control ']) }}
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{ __('Cancel') }}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Update') }}" class="btn btn-primary">
</div>
{{ Form::close() }}

<script></script>
