@extends('layouts.admin')
@section('page-title')
    {{ __('Manage Purchase Request') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Purchase Request') }}</li>
@endsection

@section('action-btn')
    <div class="float-end">
        <a href="#" data-url="{{ route('purchase-request.create') }}" data-size="lg" data-bs-toggle="tooltip"
            title="{{ __('Create') }}" data-ajax-popup="true" data-title="{{ __('Create New Purchase Requisition') }}"
            class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i>
        </a>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class=" mt-2 " id="multiCollapseExample1">
                <div class="card">
                    <div class="card-body">
                        {{ Form::open(['route' => ['purchase-request.index'], 'method' => 'get', 'id' => 'purchase_filter']) }}
                        <div class="row">
                            <div class="col-md-3">
                                {{ Form::label('branch', __('Branch'), ['class' => 'form-label']) }}
                                <select class="form-control select" name="branch" id="branch"
                                    placeholder="Select Branch">
                                    <option value="">{{ __('Select Branch') }}</option>
                                    @foreach ($branch as $branch)
                                        @if ($getBranch == $branch->id)
                                            <option value="{{ $branch->id }}" selected>{{ $branch->name }}</option>
                                        @else
                                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                {{ Form::label('department', __('Department'), ['class' => 'form-label']) }}
                                <select name="department" id="department" class="form-control " required>
                                </select>
                            </div>
                            <div class="col-md-3">
                                {{ Form::label('employee', __('Requester'), ['class' => 'form-label']) }}
                                <select name="employee" id="employee" class="form-control " required>
                                </select>
                            </div>
                            <div class="col-auto mt-4">
                                <div class="row">
                                    <div class="col-auto">

                                        <a href="#" class="btn btn-sm btn-primary"
                                            onclick="document.getElementById('purchase_filter').submit(); return false;"
                                            data-bs-toggle="tooltip" title="{{ __('Search') }}"
                                            data-original-title="{{ __('Search') }}">
                                            <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                                        </a>

                                        <a href="{{ route('purchase-request.index') }}" class="btn btn-sm btn-danger "
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


    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>{{ __('Created Date') }}</th>
                                    <th>{{ __('PR Number') }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Request Date') }}</th>
                                    <th>{{ __('Date Required') }}</th>
                                    <th>{{ __('Branch') }}</th>
                                    <th>{{ __('Department') }}</th>
                                    <th>{{ __('Requester') }}</th>
                                    <th>{{ __('Received Quantity') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    @can('manage purchase request')
                                        <th>{{ __('Action') }}</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pr as $item)
                                    <tr>
                                        <td>{{ \Auth::user()->dateFormat($item->created_at) }}</td>
                                        <td>{{ $item->pr_number }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ \Auth::user()->dateFormat($item->request_date) }}</td>
                                        <td>{{ \Auth::user()->dateFormat($item->date_required) }}</td>
                                        <td>{{ !empty($item->branch()) ? $item->branch()->name : '' }}</td>
                                        <td>{{ !empty($item->department()) ? $item->department()->name : '' }}</td>
                                        <td>{{ !empty($item->employee()) ? $item->employee()->name : '' }}</td>
                                        <td>{{ $item?->purchaseOrder?->purchaseOrderDetails?->reduce(function ($carry, $item) {
                                            return $carry + $item->goodsReceiptDetail?->qty;
                                        }, 0) }}
                                        </td>
                                        <td>{{ $item->status }}</td>
                                        @if ($item->status == 'WIP')
                                            <td>
                                                <div class="action-btn bg-warning ms-2">
                                                    <a href="#"
                                                        data-url="{{ route('purchase-request.show', $item->id) }}"
                                                        data-size="lg" data-bs-toggle="tooltip" title="{{ __('Show') }}"
                                                        data-ajax-popup="true"
                                                        data-title="{{ __('Show') }} - {{ $item->pr_number }}"
                                                        class="mx-3 btn btn-sm align-items-center">
                                                        <i class="ti ti-eye text-white"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        @else
                                            <td>
                                                <div class="action-btn bg-warning ms-2">
                                                    <a href="#"
                                                        data-url="{{ route('purchase-request.show', $item->id) }}"
                                                        data-size="lg" data-bs-toggle="tooltip" title="{{ __('Show') }}"
                                                        data-ajax-popup="true"
                                                        data-title="{{ __('Show') }} - {{ $item->pr_number }}"
                                                        class="mx-3 btn btn-sm align-items-center">
                                                        <i class="ti ti-eye text-white"></i>
                                                    </a>
                                                </div>
                                                <div class="action-btn bg-success ms-2">
                                                    <a href="{{ route('purchase-request.index_requisition', $item->id) }}"
                                                        data-title="{{ __('Purchase Requisition') }}"
                                                        class="mx-3 btn btn-sm align-items-center" data-bs-toggle="tooltip"
                                                        title="{{ __('Purchase Requisition') }}"
                                                        data-original-title="{{ __('Purchase Requisition') }}">
                                                        <i class="ti ti-plus text-white"></i></a>
                                                </div>
                                                @can('manage purchase request')
                                                    <div class="action-btn bg-primary ms-2">
                                                        <a href="#"
                                                            data-url="{{ URL::to('purchase-request/' . $item->id . '/edit') }}"
                                                            data-size="lg" data-ajax-popup="true"
                                                            data-title="{{ __('Edit Purchase') }}"
                                                            class="mx-3 btn btn-sm align-items-center" data-bs-toggle="tooltip"
                                                            title="{{ __('Edit') }}"
                                                            data-original-title="{{ __('Edit') }}">
                                                            <i class="ti ti-pencil text-white"></i></a>
                                                    </div>
                                                @endcan
                                                @can('manage purchase request')
                                                    <div class="action-btn bg-danger ms-2">
                                                        {!! Form::open([
                                                            'method' => 'DELETE',
                                                            'route' => ['purchase-request.destroy', $item->id],
                                                            'id' => 'delete-form-' . $item->id,
                                                        ]) !!}

                                                        <a href="#"
                                                            class="mx-3 btn btn-sm  align-items-center bs-pass-para"
                                                            data-bs-toggle="tooltip" title="{{ __('Delete') }}"
                                                            data-original-title="{{ __('Delete') }}"
                                                            data-confirm="{{ __('Are You Sure?') . '|' . __('This action can not be undone. Do you want to continue?') }}"
                                                            data-confirm-yes="document.getElementById('delete-form-{{ $item->id }}').submit();">
                                                            <i class="ti ti-trash text-white"></i></a>
                                                        {!! Form::close() !!}
                                                    </div>
                                            @endif
                                            </td>
                                    @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @push('script-page')
        {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}
        <script>
            $(document).ready(function() {
                var urlParams = new URLSearchParams(window.location.search);
                var idbranch = urlParams.get('branch');
                var department = urlParams.get('department');
                var employee = urlParams.get('employee');
                console.log(idbranch);
                console.log(department);
                console.log(employee);
                $.ajax({
                    url: "{{ url('purchase-request/getdepartmentsearch/json') }}",
                    type: "POST",
                    data: {
                        branch: idbranch,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        $('#department').html('<option value="">Select Department</option>');
                        $.each(result.departments, function(key, value) {
                            $("#department").append('<option value="' + value.id + '">' + value
                                .name + '</option>');
                        });
                        $('#employee1').html('<option value="">Select Employee</option>');
                    }
                });
                /*------------------------------------------
                --------------------------------------------
                Country Dropdown Change Event
                --------------------------------------------
                --------------------------------------------*/
                $('#branch').on('change', function() {
                    var idBranch = this.value;
                    $("#department").html('');
                    $.ajax({
                        url: "{{ url('purchase-request/getdepartmentsearch/json') }}",
                        type: "POST",
                        data: {
                            branch: idBranch,
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(result) {
                            $('#department').html('<option value="">Select Department</option>');
                            $('#department').html('<option value="">All Department</option>');
                            $.each(result.departments, function(key, value) {
                                console.log(value.id);
                                $("#department").append('<option value="' + value.id +
                                    '">' + value.name + '</option>');
                            });
                            $('#employee').html('<option value="">Select Employee</option>');
                        }
                    });
                });

                /*------------------------------------------
                --------------------------------------------
                State Dropdown Change Event
                --------------------------------------------
                --------------------------------------------*/
                $('#department').on('change', function() {
                    var idDepartment = this.value;
                    $("#employee").html('');
                    $.ajax({
                        url: "{{ url('purchase-request/getemployeesearch/json') }}",
                        type: "POST",
                        data: {
                            department: idDepartment,
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(res) {
                            console.log(res.employees);
                            $('#employee').html('<option value="">Select Employee</option>');
                            $.each(res.employees, function(key, value) {
                                $("#employee").append('<option value="' + value.id + '">' +
                                    value.name + '</option>');
                            });
                        }
                    });
                });

            });
        </script>
    @endpush
