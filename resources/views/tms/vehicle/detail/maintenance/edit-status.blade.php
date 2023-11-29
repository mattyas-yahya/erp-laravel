{{ Form::open(['route' => ['tms.vehicle.show.maintenance.status.update', ['id' => $vehicleMaintenance->tms_vehicle_id, 'maintenanceId' => $vehicleMaintenance->id]], 'method' => 'PUT']) }}
<div class="modal-body">
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                {{ Form::label('status', __('Status'), ['class' => 'form-label']) }}
                <select class="form-control" name="status" id="status" placeholder="Select Status" required>
                    <option value="SUBMISSION" @if ($vehicleMaintenance->status == 'SUBMISSION') selected @endif>Pengajuan</option>
                    <option value="PLAN" @if ($vehicleMaintenance->status == 'PLAN') selected @endif>Rencana</option>
                    <option value="MAINTENANCE" @if ($vehicleMaintenance->status == 'MAINTENANCE') selected @endif>Perawatan</option>
                    <option value="FINISHED" @if ($vehicleMaintenance->status == 'FINISHED') selected @endif>Selesai</option>
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
