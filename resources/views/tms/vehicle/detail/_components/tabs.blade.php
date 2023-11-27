<ul class="nav nav-tabs nav-fill" id="pills-tab" role="tablist">
    <li class="nav-item">
        <a href="{{ route('tms.vehicle.show.dashboard', ['id' => $vehicle->id]) }}" class="nav-link {{ in_array(Request::route()->getName(), ['tms.vehicle.show.dashboard']) ? ' active' : '' }}" id="pills-tab-dashboard">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('tms.vehicle.show.detail', ['id' => $vehicle->id]) }}" class="nav-link {{ in_array(Request::route()->getName(), ['tms.vehicle.show.detail']) ? ' active' : '' }}"  id="pills-tab-detail">
            <i class="fas fa-tags"></i> Detail
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('tms.vehicle.show.maintenance', ['id' => $vehicle->id, 'status' => 'submission']) }}" class="nav-link {{ in_array(Request::route()->getName(), [
            'tms.vehicle.show.maintenance',
            'tms.vehicle.show.maintenance.create',
            'tms.vehicle.show.maintenance.show',
        ]) ? ' active' : '' }}"   id="pills-tab-maintenance">
            <i class="fas fa-wrench"></i> Perawatan
        </a>
    </li>
    <li class="nav-item">
        <a href="#" class="nav-link" id="pills-tab-tiremanagement">
            <i class="fas fa-wrench"></i> Manajemen Ban
        </a>
    </li>
    <li class="nav-item">
        <a href="#" class="nav-link" id="pills-tab-tire-trailer">
            <i class="fas fa-wrench"></i> Trailer
        </a>
    </li>
</ul>