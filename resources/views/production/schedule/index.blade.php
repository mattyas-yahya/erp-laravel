@extends('layouts.admin')
@section('page-title')
    {{ __('Production Schedule') }}
@endsection

@section('breadcrumb')
    @include ('partials.admin.breadcrumbs', [
        'item' => __('Production Schedule'),
    ])
@endsection

@push('css-page')
    <link rel="stylesheet" href="{{ asset('css/datatable/buttons.dataTables.min.css') }}">
    <style>
        .scrollable {
            position: relative;
            overflow-x: auto;
            overflow-y: hidden;
            flex-wrap: nowrap;
            height: 70px;
        }
        .scrollable .nav-link {
            white-space: nowrap;
        }
    </style>
@endpush

@section('action-btn')
    <div class="float-end">
        @can('manage production')
            <a href="#" title="{{ __('Create') }}" data-title="Tambah Jadwal Produksi"
                data-url="{{ route('production.schedule.create') }}" data-size="lg" data-bs-toggle="tooltip" data-ajax-popup="true"
                class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i>
            </a>
        @endcan
    </div>
@endsection

@section('content')
    @include('production.schedule._components.filter')

    <div class="row">
        <div class="col-md-12">
            @include('production.schedule._components.tab-machines', [
                'machines' => $machines
            ])
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="col-auto float-end ms-2">
                        {!! Form::open([
                            'id' => 'print-bulk-form',
                            'style' => 'display: none',
                            'method' => 'GET',
                            'route' => ['production.schedule.generate-multi-pdf'],
                        ]) !!}
                            <a
                                href="javascript:;"
                                onclick="document.getElementById('print-bulk-form').submit();"
                                class="mx-3 btn btn-sm btn-icon m-1 bg-dark align-items-center text-white"
                                data-bs-placement="top"
                                title="{{ __('Print Selected') }}"
                            >
                                <i class="ti ti-printer text-white"></i> {{ __('Print Selected') }}
                            </a>
                        {!! Form::close() !!}
                    </div>
                    <div class="tab-content" id="pills-tabContent">
                        @include('production.schedule._components.all-schedules-table')
                        @include('production.schedule._components.machines-schedules-table')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-page')
    <script>
        if (document.querySelector(".scrollable")) {
            var px = new PerfectScrollbar(".scrollable", {
                wheelSpeed: 0.5,
                swipeEasing: 0,
                suppressScrollX: false,
                wheelPropagation: 1,
                minScrollbarLength: 40,
            });
        }

        $(document).ready(function () {
            const dataTableAll = new simpleDatatables.DataTable(".datatable-all");
            @foreach ($machines as $machine)
            const dataTable{{ $loop->iteration }} = new simpleDatatables.DataTable(".datatable{{ $loop->iteration }}");
            @endforeach

            // multi-select print
            const inputHidden = (val) => `<input type="hidden" class="print-bulk-form-id" name="ids[]" value="${val}">`;

            $('.print-bulk').change(function() {
                const value = this.value;

                if (this.checked) {
                    $('#print-bulk-form').append(inputHidden(value));
                }

                if (!this.checked) {
                    $(`.print-bulk-form-id`).filter(function() {
                        return $(this).val() === value
                    }).remove();
                }

                const printBulkIdsCount = $(`.print-bulk-form-id`).length;

                if (printBulkIdsCount > 0) {
                    $('#print-bulk-form').show();
                } else {
                    $('#print-bulk-form').hide();
                }

                $('#print-bulk-form a').html(`<i class="ti ti-printer text-white"></i> {{ __('Print Selected') }} (${printBulkIdsCount})`);
            });
        });
    </script>
@endpush
