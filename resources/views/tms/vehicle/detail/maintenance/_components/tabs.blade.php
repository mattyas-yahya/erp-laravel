<a href="{{ route('tms.vehicle.show.maintenance.create', ['id' => $vehicle->id]) }}"
    title="{{ __('Tambah Perawatan') }}" data-title="Tambah Perawatan" data-url="#" data-size="lg"
    data-bs-toggle="tooltip" class="btn btn-sm btn-primary">
    <i class="ti ti-plus"></i> Tambah Perawatan
</a>

<div class="card" style="top:30px">
    <div class="list-group list-group-flush">
        <a href="{{ route('tms.vehicle.show.maintenance.index', ['id' => $vehicle->id, 'status' => 'submission']) }}"
            class="list-group-item list-group-item-action border-0 {{ Request::route()->getName() == 'tms.vehicle.show.maintenance.index' && Request::get('status') == 'submission' ? ' active' : '' }}">Pengajuan
            <div class="float-end"><span
                    class="badge bg-dark">{{ $vehicleMaintenancesSubmissionCount }}</span></div>
        </a>
        <a href="{{ route('tms.vehicle.show.maintenance.index', ['id' => $vehicle->id, 'status' => 'plan']) }}"
            class="list-group-item list-group-item-action border-0 {{ Request::route()->getName() == 'tms.vehicle.show.maintenance.index' && Request::get('status') == 'plan' ? ' active' : '' }}">Rencana
            <div class="float-end"><span
                    class="badge bg-dark">{{ $vehicleMaintenancesPlanCount }}</span></div>
        </a>
        <a href="{{ route('tms.vehicle.show.maintenance.index', ['id' => $vehicle->id, 'status' => 'maintenance']) }}"
            class="list-group-item list-group-item-action border-0 {{ Request::route()->getName() == 'tms.vehicle.show.maintenance.index' && Request::get('status') == 'maintenance' ? ' active' : '' }}">Perawatan
            <div class="float-end"><span
                    class="badge bg-dark">{{ $vehicleMaintenancesMaintenanceCount }}</span></div>
        </a>
        <a href="{{ route('tms.vehicle.show.maintenance.index', ['id' => $vehicle->id, 'status' => 'finished']) }}"
            class="list-group-item list-group-item-action border-0 {{ Request::route()->getName() == 'tms.vehicle.show.maintenance.index' && Request::get('status') == 'finished' ? ' active' : '' }}">Selesai
            <div class="float-end"><span
                    class="badge bg-dark">{{ $vehicleMaintenancesFinishedCount }}</span></div>
        </a>
    </div>
</div>
