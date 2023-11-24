<div class="card sticky-top" style="top:30px">
    <div class="list-group list-group-flush" id="useradd-sidenav">
        <a href="{{ route('taxes.index') }}"
            class="list-group-item list-group-item-action border-0 {{ Request::route()->getName() == 'taxes.index' ? ' active' : '' }}">{{ __('Taxes') }}
            <div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

        <a href="{{ route('product-category.index') }}"
            class="list-group-item list-group-item-action border-0 {{ Request::route()->getName() == 'product-category.index' ? 'active' : '' }}">{{ __('Category') }}
            <div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

        <a href="{{ route('product-unit.index') }}"
            class="list-group-item list-group-item-action border-0 {{ Request::route()->getName() == 'product-unit.index' ? ' active' : '' }}">{{ __('Unit') }}
            <div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

        <a href="{{ route('custom-field.index') }}"
            class="list-group-item list-group-item-action border-0 {{ Request::route()->getName() == 'custom-field.index' ? 'active' : '' }}   ">{{ __('Custom Field') }}
            <div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

        <a href="{{ route('chart-of-account-type.index') }}"
            class="list-group-item list-group-item-action border-0 {{ Request::route()->getName() == 'chart-of-account-type.index' ? 'active' : '' }}   ">{{ __('Chart of Accounts Type') }}
            <div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

        <a href="{{ route('chart-of-account-subtype.index') }}"
            class="list-group-item list-group-item-action border-0 {{ Request::route()->getName() == 'chart-of-account-subtype.index' ? 'active' : '' }}   ">{{ __('Chart of Accounts Sub Type') }}
            <div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

        <a href="{{ route('accounting.config.payment-method.index') }}"
            class="list-group-item list-group-item-action border-0 {{ Request::route()->getName() == 'accounting.config.payment-method.index' ? ' active' : '' }}">{{ __('Payment Method') }}
            <div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

        <a href="{{ route('accounting.config.payment-type.index') }}"
            class="list-group-item list-group-item-action border-0 {{ Request::route()->getName() == 'accounting.config.payment-type.index' ? ' active' : '' }}">{{ __('Payment Type') }}
            <div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
    </div>
</div>
