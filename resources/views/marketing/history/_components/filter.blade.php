<div class="row">
    <div class="col-sm-12">
        <div class="mt-2">
            <div class="card">
                <div class="card-body">
                    {{ Form::open(['route' => ['sales-order.history'], 'method' => 'GET', 'id' => 'sales_order_history_filter']) }}
                    <div class="row align-items-center justify-content-start">
                        <div class="col-xl-10">
                            <div class="row">
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                    <div class="btn-box">
                                        {{ Form::label('so_number', __('Sales Order'), ['class' => 'form-label']) }}
                                        {{ Form::select('so_number', $filterValues['sales_orders'], isset($_GET['so_number']) ? $_GET['so_number'] : null, ['class' => 'form-control select2']) }}
                                    </div>
                                </div>

                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                    <div class="btn-box">
                                        {{ Form::label('no_coil', __('No. Coil'), ['class' => 'form-label']) }}
                                        {{ Form::select('no_coil', $filterValues['coil_numbers'], isset($_GET['no_coil']) ? $_GET['no_coil'] : null, ['class' => 'form-control select2']) }}
                                    </div>
                                </div>

                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                    <div class="btn-box">
                                        {{ Form::label('sku_number', __('ID SJB'), ['class' => 'form-label']) }}
                                        {{ Form::select('sku_number', $filterValues['id_sjb'], isset($_GET['sku_number']) ? $_GET['sku_number'] : null, ['class' => 'form-control select2']) }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-2">
                            <div class="row float-end">
                                <div class="col-auto mt-4">
                                    <a href="#" class="btn btn-sm btn-primary"
                                        onclick="document.getElementById('sales_order_history_filter').submit(); return false;"
                                        data-bs-toggle="tooltip" title="{{ __('Apply Filter') }}"
                                        data-original-title="{{ __('Apply Filter') }}">
                                        <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                                    </a>

                                    <a href="{{ route('sales-order.history') }}" class="btn btn-sm btn-danger "
                                        data-bs-toggle="tooltip" title="{{ __('Reset') }}"
                                        data-original-title="{{ __('Reset') }}">
                                        <span class="btn-inner--icon"><i
                                                class="ti ti-trash-off text-white-off "></i></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
