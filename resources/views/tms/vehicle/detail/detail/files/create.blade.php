{{ Form::open(['route' => ['tms.vehicle.show.detail.files.store', $vehicle->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            {!! Form::label('file', __('Berkas'), ['class' => 'form-label']) !!}
            <div class="choose-file">
                <label for="file" class="form-label">
                    <input type="file" name="file" class="form-control" accept=".png, .jpg, .jpeg, .pdf, .docx, .xlsx" required>
                </label>
                <p class="upload_file"></p>
            </div>
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('name', __('Nama'), ['class' => 'form-label']) !!}
            {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('type', __('Jenis'), ['class' => 'form-label']) !!}
            {!! Form::text('type', null, ['class' => 'form-control', 'required']) !!}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('expired_at', __('Tgl. Kadaluarsa'), ['class' => 'form-label']) }}
            {{ Form::date('expired_at', '', ['class' => 'form-control ']) }}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('remaining_time', __('Sisa Waktu'), ['class' => 'form-label']) !!}
            {!! Form::number('remaining_time', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('active', __('Active'), ['class' => 'form-label']) }}
            <br />
            {{ Form::checkbox('active', 'true') }}
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{ __('Cancel') }}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Create') }}" class="btn btn-primary">
</div>
{{ Form::close() }}
