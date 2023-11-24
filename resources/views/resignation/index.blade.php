@extends('layouts.admin')

@section('page-title')
    {{__('Manage Resignation')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Resignation')}}</li>
@endsection

@section('action-btn')
    <div class="float-end">
        @can('create resignation')
            <a href="#" data-size="lg" data-url="{{ route('resignation.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create')}}" data-title="{{__('Create New Resignation')}}" class="btn btn-sm btn-primary">
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
                                @role('company')
                                <th>{{__('Employee Name')}}</th>
                                @endrole
                                <th>{{__('Branch')}}</th>
                                <th>{{__('Department')}}</th>
                                <th>{{__('Resignation Date')}}</th>
                                <th>{{__('Last Working Date')}}</th>
                                <th>{{__('Reason')}}</th>
                                @if(Gate::check('edit resignation') || Gate::check('delete resignation'))
                                    <th width="200px">{{__('Action')}}</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody class="font-style">
                            @foreach ($resignations as $resignation)
                                <tr>
                                    @role('company')
                                    <td>{{ !empty($resignation->employee())?$resignation->employee()->name:'' }}</td>
                                    @endrole
                                    <td>{{ !empty($resignation->branch())?$resignation->branch()->name:'' }}</td>
                                    <td>{{ !empty($resignation->department())?$resignation->department()->name:'' }}</td>
                                    <td>{{  \Auth::user()->dateFormat($resignation->notice_date) }}</td>
                                    <td>{{  \Auth::user()->dateFormat($resignation->resignation_date) }}</td>
                                    <td>{{ $resignation->description }}</td>
                                    @if(Gate::check('edit resignation') || Gate::check('delete resignation'))
                                        <td>

                                            @can('edit resignation')
                                                <div class="action-btn bg-primary ms-2">
                                                    <a href="#" class="mx-3 btn btn-sm align-items-center" data-size="lg" data-url="{{ URL::to('resignation/'.$resignation->id.'/edit') }}" data-ajax-popup="true" data-title="{{__('Edit Resignation')}}" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}">
                                                        <i class="ti ti-pencil text-white"></i>
                                                    </a>
                                                </div>
                                            @endcan


                                            @can('delete resignation')
                                                <div class="action-btn bg-danger ms-2">
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['resignation.destroy', $resignation->id],'id'=>'delete-form-'.$resignation->id]) !!}
                                                    <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$resignation->id}}').submit();">
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
    $(document).on('change', 'select[name=branch_id]', function () {
        var idBranch = this.value;
        $("#department").html('');
        $.ajax({
            url: "{{url('resignation/getdepartment/json')}}",
            type: "POST",
            data: {
                branch_id: idBranch,
                _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function (result) {
                console.log(result);
                $('#department').html('<option value="">Select Department</option>');
                $.each(result.departments, function (key, value) {
                    $("#department").append('<option value="' + value
                        .id + '">' + value.name + '</option>');
                });
                $('#employee').html('<option value="">Select Employee</option>');
            }
        });
    });
    $(document).on('change', '#department', function () {
        var idDepartment = this.value;
        $("#employee").html('');
        $.ajax({
            url: "{{url('resignation/getemployee/json')}}",
            type: "POST",
            data: {
                department_id: idDepartment,
                _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function (res) {
                console.log(res.employees);
                $('#employee').html('<option value="">Select Employee</option>');
                $.each(res.employees, function (key, value) {
                    $("#employee").append('<option value="' + value
                        .id + '">' + value.name + '</option>');
                });
            }
        });
    });
</script>
@endpush