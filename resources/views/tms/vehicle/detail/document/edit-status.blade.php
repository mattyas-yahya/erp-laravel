{{ Form::open(['route' => ['tms.vehicle.show.document.status.update', ['id' => $vehicleOtherDocument->tms_vehicle_id, 'documentId' => $vehicleOtherDocument->id]], 'method' => 'PUT']) }}
<div class="modal-body">
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                {{ Form::label('status', __('Status'), ['class' => 'form-label']) }}
                <select class="form-control" name="status" id="status" placeholder="Select Status" required>
                    <option value="SUBMISSION" @if ($vehicleOtherDocument->status == 'SUBMISSION') selected @endif>Pengajuan</option>
                    <option value="PLAN" @if ($vehicleOtherDocument->status == 'PLAN') selected @endif>Rencana</option>
                    <option value="DOCUMENT" @if ($vehicleOtherDocument->status == 'DOCUMENT') selected @endif>Document</option>
                    <option value="FINISHED" @if ($vehicleOtherDocument->status == 'FINISHED') selected @endif>Selesai</option>
                </select>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{ __('Cancel') }}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Update') }}" class="btn btn-primary">
</div>
{{ Form::close() }}
