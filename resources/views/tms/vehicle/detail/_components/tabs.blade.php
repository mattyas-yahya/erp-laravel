<ul class="nav nav-tabs nav-fill" id="pills-tab" role="tablist">
    <li class="nav-item">
        <a href="{{ route('tms.vehicle.show.dashboard.index', ['id' => $vehicle->id]) }}" class="nav-link {{ in_array(Request::route()->getName(), ['tms.vehicle.show.dashboard.index']) ? ' active' : '' }}" id="pills-tab-dashboard">
            <i class="ti ti-dashboard"></i> Dashboard
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('tms.vehicle.show.detail.files.index', ['id' => $vehicle->id]) }}" class="nav-link {{ in_array(Request::route()->getName(), ['tms.vehicle.show.detail.files.index']) ? ' active' : '' }}" id="pills-tab-detail">
            <i class="ti ti-list-details"></i> Detail
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('tms.vehicle.show.maintenance.index', ['id' => $vehicle->id, 'status' => 'submission']) }}" class="nav-link {{ in_array(Request::route()->getName(), [
            'tms.vehicle.show.maintenance.index',
            'tms.vehicle.show.maintenance.show',
            'tms.vehicle.show.maintenance.create',
            'tms.vehicle.show.maintenance.edit',
            'tms.vehicle.show.maintenance.edit-realization',
        ]) ? ' active' : '' }}" id="pills-tab-maintenance">
            <i class="ti ti-car-garage"></i> Perawatan
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('tms.vehicle.show.document.index', ['id' => $vehicle->id, 'status' => 'submission']) }}" class="nav-link {{ in_array(Request::route()->getName(), ['tms.vehicle.show.document.index']) ? ' active' : '' }}" id="pills-tab-document">
            <i class="ti ti-file"></i> Dokumen
        </a>
    </li>
    {{-- <li class="nav-item">
        <a href="#" class="nav-link" id="pills-tab-tiremanagement">
            <i class="fas fa-wrench"></i> Manajemen Ban
        </a>
    </li>
    <li class="nav-item">
        <a href="#" class="nav-link" id="pills-tab-tire-trailer">
            <i class="fas fa-wrench"></i> Trailer
        </a>
    </li> --}}
</ul>
