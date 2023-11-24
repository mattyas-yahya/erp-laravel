<div class="card sticky-top" style="top:30px">
    <div class="list-group list-group-flush">
        <a href="{{ route('payroll.overtime.staff.index') }}"
            class="list-group-item list-group-item-action border-0 {{ Request::route()->getName() == 'payroll.overtime.staff.index' ? ' active' : '' }}">{{ __('Staff Overtime') }}
            <div class="float-end"><i class="ti ti-chevron-right"></i></div>
        </a>
        <a href="{{ route('payroll.overtime.driver.index') }}"
            class="list-group-item list-group-item-action border-0 {{ Request::route()->getName() == 'payroll.overtime.driver.index' ? ' active' : '' }}">{{ __('Driver Overtime') }}
            <div class="float-end"><i class="ti ti-chevron-right"></i></div>
        </a>
    </div>
</div>
