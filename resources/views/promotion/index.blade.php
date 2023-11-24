@extends('layouts.admin')

@section('page-title')
    {{__('Manage Promotion')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Promotion')}}</li>
@endsection

@section('action-btn')
    <div class="float-end">
    @can('create promotion')
            <a href="#" data-url="{{ route('promotion.create') }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Create New Promotion')}}" data-bs-toggle="tooltip" title="{{__('Create')}}"  class="btn btn-sm btn-primary">
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
                                <th>{{__('Designation')}}</th>
                                <th>{{__('Promotion Title')}}</th>
                                <th>{{__('Promotion Date')}}</th>
                                <th>{{__('Description')}}</th>
                                @if(Gate::check('edit promotion') || Gate::check('delete promotion'))
                                    <th width="200px">{{__('Action')}}</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody class="font-style">
                            @foreach ($promotions as $promotion)
                                <tr>
                                    @role('company')
                                    <td>{{ !empty($promotion->employee())?$promotion->employee()->name:'' }}</td>
                                    @endrole
                                    <td>{{ !empty($promotion->branch())?$promotion->branch()->name:'' }}</td>
                                    <td>{{ !empty($promotion->department())?$promotion->department()->name:'' }}</td>
                                    <td>{{ !empty($promotion->designation())?$promotion->designation()->name:'' }}</td>
                                    <td>{{ $promotion->promotion_title }}</td>
                                    <td>{{  \Auth::user()->dateFormat($promotion->promotion_date) }}</td>
                                    <td>{{ $promotion->description }}</td>
                                    @if(Gate::check('edit promotion') || Gate::check('delete promotion'))
                                        <td>
                                         
                                           @can('edit promotion')
                                                <div class="action-btn bg-primary ms-2">
                                                    <a href="#" class="mx-3 btn btn-sm align-items-center" data-url="{{ URL::to('promotion/'.$promotion->id.'/edit') }}" data-ajax-popup="true" data-title="{{__('Edit Promotion')}}" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}">
                                                    <i class="ti ti-pencil text-white"></i>
                                                </a>
                                                </div>
                                           @endcan

                                        

                                            @can('delete promotion')
                                                <div class="action-btn bg-danger ms-2">
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['promotion.destroy', $promotion->id],'id'=>'delete-form-'.$promotion->id]) !!}
                                                        <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$promotion->id}}').submit();">
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
            url: "{{url('promotion/getdepartment/json')}}",
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
                $('#designation').html('<option value="">Select designation</option>');
                $('#employee').html('<option value="">Select Employee</option>');
            }
        });
    });
    $(document).on('change', '#department', function () {
        var idDepartment = this.value;
        $("#designation").html('');
        $.ajax({
            url: "{{url('promotion/getdesignation/json')}}",
            type: "POST",
            data: {
                department_id: idDepartment,
                _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function (res) {
                console.log(res.designation);
                $('#designation').html('<option value="">Select Designation</option>');
                $.each(res.designation, function (key, value) {
                    $("#designation").append('<option value="' + value
                        .id + '">' + value.name + '</option>');
                });
            }
        });
    });
    $(document).on('change', '#department', function () {
        var idDepartment = this.value;
        $("#employee").html('');
        $.ajax({
            url: "{{url('promotion/getemployee/json')}}",
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