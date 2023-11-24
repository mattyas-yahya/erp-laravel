<div class="card sticky-top" style="top:30px">
    <div class="list-group list-group-flush" id="useradd-sidenav">
        <a href="{{ route('tms.setting.ownership.index') }}"
            class="list-group-item list-group-item-action border-0 {{ Request::route()->getName() == 'tms.setting.ownership.index' ? ' active' : '' }}">{{ __('Master Kepemilikan') }}
            <div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
        <a href="{{ route('tms.setting.kilometer.index') }}"
            class="list-group-item list-group-item-action border-0 {{ Request::route()->getName() == 'tms.setting.kilometer.index' ? ' active' : '' }}">{{ __('Master Kilometer') }}
            <div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
        <a href="{{ route('tms.setting.vehicle-factory.index') }}"
            class="list-group-item list-group-item-action border-0 {{ Request::route()->getName() == 'tms.setting.vehicle-factory.index' ? ' active' : '' }}">{{ __('Master Pabrikan Kendaraan') }}
            <div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
        <a href="{{ route('tms.setting.tire-factory.index') }}"
            class="list-group-item list-group-item-action border-0 {{ Request::route()->getName() == 'tms.setting.tire-factory.index' ? ' active' : '' }}">{{ __('Master Pabrikan Ban') }}
            <div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
    </div>
</div>
