<a href="{{ route('tms.vehicle.show.document.create', ['id' => $vehicle->id]) }}"
    title="{{ __('Tambah Dokumen') }}" data-title="Tambah Dokumen" data-url="#" data-size="lg"
    data-bs-toggle="tooltip" class="btn btn-sm btn-primary">
    <i class="ti ti-plus"></i> Tambah Dokumen
</a>

<div class="card" style="top:30px">
    <div class="list-group list-group-flush">
        <a href="{{ route('tms.vehicle.show.document.index', ['id' => $vehicle->id, 'status' => 'submission']) }}"
            class="list-group-item list-group-item-action border-0 {{ Request::route()->getName() == 'tms.vehicle.show.document.index' && Request::get('status') == 'submission' ? ' active' : '' }}">Pengajuan
            <div class="float-end"><span
                    class="badge bg-dark">{{ $vehicleDocumentsSubmissionCount }}</span></div>
        </a>
        <a href="{{ route('tms.vehicle.show.document.index', ['id' => $vehicle->id, 'status' => 'plan']) }}"
            class="list-group-item list-group-item-action border-0 {{ Request::route()->getName() == 'tms.vehicle.show.document.index' && Request::get('status') == 'plan' ? ' active' : '' }}">Rencana
            <div class="float-end"><span
                    class="badge bg-dark">{{ $vehicleDocumentsPlanCount }}</span></div>
        </a>
        <a href="{{ route('tms.vehicle.show.document.index', ['id' => $vehicle->id, 'status' => 'document']) }}"
            class="list-group-item list-group-item-action border-0 {{ Request::route()->getName() == 'tms.vehicle.show.document.index' && Request::get('status') == 'document' ? ' active' : '' }}">Dokumen
            <div class="float-end"><span
                    class="badge bg-dark">{{ $vehicleDocumentsDocumentCount }}</span></div>
        </a>
        <a href="{{ route('tms.vehicle.show.document.index', ['id' => $vehicle->id, 'status' => 'finished']) }}"
            class="list-group-item list-group-item-action border-0 {{ Request::route()->getName() == 'tms.vehicle.show.document.index' && Request::get('status') == 'finished' ? ' active' : '' }}">Selesai
            <div class="float-end"><span
                    class="badge bg-dark">{{ $vehicleDocumentsFinishedCount }}</span></div>
        </a>
    </div>
</div>
