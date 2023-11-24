<div class="card sticky-top" style="top:30px">
    <div class="list-group list-group-flush" id="useradd-sidenav">
        {{-- <a href="{{route('uom.index')}}" class="list-group-item list-group-item-action border-0 {{ (Request::route()->getName() == 'uom.index' ) ? ' active' : '' }}">UOM <div class="float-end"><i class="ti ti-chevron-right"></i></div></a> --}}
        
        <a href="{{route('payment-term.index')}}" class="list-group-item list-group-item-action border-0 {{ (Request::route()->getName() == 'payment-term.index' ) ? ' active' : '' }}">{{ __('Payment Terms') }} <div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

    </div>
</div>
