@extends('layouts.admin')

@section('page-title')
    {{__('Manage Warning')}}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Warning')}}</li>
@endsection


@section('action-btn')
    <div class="float-end">
    @can('create warning')
            <a href="#" data-url="{{ route('warning.create') }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Create New Warning')}}" data-bs-toggle="tooltip" title="{{__('Create')}}"  class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i>
            </a>
        @endcan
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
            <div class="card-body table-border-style">
                    <div class="table-responsive">
                    <table class="table datatable">
                            <thead>
                            <tr>
                                <th>{{__('Warning By')}}</th>
                                <th>{{__('Warning By')}} {{ __('Branch') }}</th>
                                <th>{{__('Warning By')}} {{ __('Department') }}</th>
                                <th>{{__('Warning To')}}</th>
                                <th>{{__('Warning To')}} {{ __('Branch') }}</th>
                                <th>{{__('Warning To')}} {{ __('Department') }}</th>
                                <th>{{__('Warning Type')}}</th>
                                <th>{{__('Subject')}}</th>
                                <th>{{__('Warning Date')}}</th>
                                <th>{{__('Description')}}</th>
                                @if(Gate::check('edit warning') || Gate::check('delete warning'))
                                    <th width="200px">{{__('Action')}}</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody class="font-style">
                            @foreach ($warnings as $warning)
                                <tr>
                                    <td>{{ !empty($warning->employee_from())?$warning->employee_from()->name:'' }}</td>
                                    <td>{{ !empty($warning->branch_from())?$warning->branch_from()->name:'' }}</td>
                                    <td>{{ !empty($warning->department_from())?$warning->department_from()->name:'' }}</td>
                                    <td>{{ !empty($warning->employee_against())?$warning->employee_against()->name:'' }}</td>
                                    <td>{{ !empty($warning->branch_against())?$warning->branch_against()->name:'' }}</td>
                                    <td>{{ !empty($warning->department_against())?$warning->department_against()->name:'' }}</td>
                                    <td>{{ $warning->warning_type }}</td>
                                    <td>{{ $warning->subject }}</td>
                                    <td>{{  \Auth::user()->dateFormat($warning->warning_date) }}</td>
                                    <td>{{ $warning->description }}</td>
                                    @if(Gate::check('edit warning') || Gate::check('delete warning'))
                                        <td>
                                        

                                            @can('edit warning')
                                                <div class="action-btn bg-primary ms-2">
                                                    <a href="#" class="mx-3 btn btn-sm align-items-center" data-size="lg" data-url="{{ URL::to('warning/'.$warning->id.'/edit') }}" data-ajax-popup="true" data-title="{{__('Edit Warning')}}" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}">
                                                    <i class="ti ti-pencil text-white"></i>
                                                </a>
                                                </div>
                                           @endcan
                        

                                            @can('delete warning')
                                                <div class="action-btn bg-danger ms-2">
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['warning.destroy', $warning->id],'id'=>'delete-form-'.$warning->id]) !!}
                                                        <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$warning->id}}').submit();">
                                                            <i class="ti ti-trash text-white"></i>
                                                        </a>
                                                    {!! Form::close() !!}
                                                </div>
                                            @endcan

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
<script>
    // complaint from
    $(document).on('change', 'select[name=branch_id_from]', function () {
        var idBranch = this.value;
        $("#department_from").html('');
        $.ajax({
            url: "{{url('warning/getdepartment/json')}}",
            type: "POST",
            data: {
                branch_id: idBranch,
                _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function (result) {
                console.log(result);
                $('#department_from').html('<option value="">Select Department</option>');
                $.each(result.departments, function (key, value) {
                    $("#department_from").append('<option value="' + value
                        .id + '">' + value.name + '</option>');
                });
                $('#employee_from').html('<option value="">Select Employee</option>');
            }
        });
    });
    $(document).on('change', '#department_from', function () {
        var idDepartment = this.value;
        $("#employee_from").html('');
        $.ajax({
            url: "{{url('warning/getemployee/json')}}",
            type: "POST",
            data: {
                department_id: idDepartment,
                _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function (res) {
                console.log(res.employees);
                $('#employee_from').html('<option value="">Select Employee</option>');
                $.each(res.employees, function (key, value) {
                    $("#employee_from").append('<option value="' + value
                        .id + '">' + value.name + '</option>');
                });
            }
        });
    });

    //complaint against
    $(document).on('change', 'select[name=branch_id_against]', function () {
        var idBranch = this.value;
        $("#department_against").html('');
        $.ajax({
            url: "{{url('warning/getdepartment/json')}}",
            type: "POST",
            data: {
                branch_id: idBranch,
                _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function (result) {
                console.log(result);
                $('#department_against').html('<option value="">Select Department</option>');
                $.each(result.departments, function (key, value) {
                    $("#department_against").append('<option value="' + value
                        .id + '">' + value.name + '</option>');
                });
                $('#employee_against').html('<option value="">Select Employee</option>');
            }
        });
    });
    $(document).on('change', '#department_against', function () {
        var idDepartment = this.value;
        $("#employee_against").html('');
        $.ajax({
            url: "{{url('warning/getemployee/json')}}",
            type: "POST",
            data: {
                department_id: idDepartment,
                _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function (res) {
                console.log(res.employees);
                $('#employee_against').html('<option value="">Select Employee</option>');
                $.each(res.employees, function (key, value) {
                    $("#employee_against").append('<option value="' + value
                        .id + '">' + value.name + '</option>');
                });
            }
        });
    });
</script>
@endpush