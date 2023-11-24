@extends('layouts.admin')
@section('page-title')
    {{__('Manage Bulk Attendance')}}
@endsection
@push('script-page')
    <script>
        var urlParams = new URLSearchParams(window.location.search);
        var idbranch = urlParams.get('branch');
        var department = urlParams.get('department');
        var employee = urlParams.get('employee');
        console.log(idbranch);
        console.log(department);
        console.log(employee);  
        $.ajax({
                url: "{{url('attendanceemployee/getdepartment/json')}}",
                type: "POST",
                data: {
                    branch: idbranch,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (result) {                    
                    $('#department').html('<option value="">Select Department</option>');
                    $.each(result.departments, function (key, value) {                        
                        $("#department").append('<option value="' + value.id + '">' + value.name + '</option>');                        
                    });
                    $('#employee').html('<option value="">Select Employee</option>');
                }
            });
        /*------------------------------------------
        --------------------------------------------
        Country Dropdown Change Event
        --------------------------------------------
        --------------------------------------------*/
        $('#branch').on('change', function () {
            var idBranch = this.value;
            $("#department").html('');
            $.ajax({
                url: "{{url('attendanceemployee/getdepartment/json')}}",
                type: "POST",
                data: {
                    branch: idBranch,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (result) {                    
                    $('#department').html('<option value="">Select Department</option>');
                    $('#department').html('<option value="">All Department</option>');
                    $.each(result.departments, function (key, value) {   
                        console.log(value.id);                     
                        $("#department").append('<option value="' + value.id + '">' + value.name + '</option>');                        
                    });
                    // $('#employee').html('<option value="">Select Employee</option>');
                }
            });
        });

        $('#present_all').click(function (event) {

            if (this.checked) {
                $('.present').each(function () {
                    this.checked = true;
                });

                $('.present_check_in').removeClass('d-none');
                $('.present_check_in').addClass('d-block');

            } else {
                $('.present').each(function () {
                    this.checked = false;
                });
                $('.present_check_in').removeClass('d-block');
                $('.present_check_in').addClass('d-none');

            }
        });

        $('.present').click(function (event) {


            var div = $(this).parent().parent().parent().parent().find('.present_check_in');
            if (this.checked) {
                div.removeClass('d-none');
                div.addClass('d-block');
            } else {
                div.removeClass('d-block');
                div.addClass('d-none');
            }

        });
    </script>
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Attendance')}}</li>
@endsection
{{--@section('action-btn')--}}
{{--    <div class="float-end">--}}
{{--        <a class="btn btn-sm btn-primary" data-bs-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1" data-bs-toggle="tooltip" title="{{__('Filter')}}">--}}
{{--            <i class="ti ti-filter"></i>--}}
{{--        </a>--}}
{{--    </div>--}}
{{--@endsection--}}



@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class=" " id="multiCollapseExample1">
                <div class="card">
                    <div class="card-body">
                        {{ Form::open(array('route' => array('attendanceemployee.bulkattendance'),'method'=>'get','id'=>'bulkattendance_filter')) }}
                        <div class="row align-items-center justify-content-end">
                            <div class="col-xl-10">
                                <div class="row">
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                            @php
                                                $date = \Carbon\Carbon::now();
                                            @endphp
                                            {{Form::label('date',__('Date'),['class'=>'form-label']) }}
                                            {{ Form::date('date', isset($_GET['date'])?$_GET['date']:$date, array('class' => 'form-control', 'required'=>'required')) }}

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                            {{ Form::label('branch', __('Branch'),['class'=>'form-label']) }}
                                            <select class="form-control select" name="branch" id="branch" placeholder="Select Branch" required>
                                                <option value="">{{__('Select Branch')}}</option>
                                                <option value="all">{{__('All')}}</option>
                                                @foreach($branch as $branch)
                                                @if($getBranch == $branch->id)
                                                <option value="{{ $branch->id }}" selected>{{ $branch->name }}</option>
                                                @else
                                                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                                @endif                                                        
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                            {{ Form::label('department', __('Department'),['class'=>'form-label']) }}
                                            <select name="department" id="department" class="form-control ">
                                            </select>
                                            {{-- {{ Form::select('department', $department,isset($_GET['department'])?$_GET['department']:'', array('class' => 'form-control select','required')) }} --}}
                                        </div>
                                    </div>



                                </div>
                            </div>
                            <div class="col-auto float-end ms-2 mt-4">
                                <button type="submit" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="{{__('Search')}}" data-original-title="{{__('Search')}}">
                                    <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                                </button>
                                {{-- <a href="#" class="btn btn-sm btn-primary" onclick="document.getElementById('bulkattendance_filter').submit(); return false;" data-bs-toggle="tooltip" title="{{__('Search')}}" data-original-title="{{__('Search')}}">
                                    <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                                </a> --}}
                                <a href="{{route('attendanceemployee.bulkattendance')}}" class="btn btn-sm btn-danger " data-bs-toggle="tooltip"  title="{{ __('Reset') }}" data-original-title="{{__('Reset')}}">
                                    <span class="btn-inner--icon"><i class="ti ti-trash-off text-white-off "></i></span>
                                </a>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header card-body table-border-style">
                    <h5></h5>

                    {{ Form::open(['route' => ['attendanceemployee.bulkattendance'], 'method' => 'post']) }}
                    <div class="table-responsive">
                        <table class="table" id="pc-dt-simple">
                            <thead>
                            <tr>
                                <th width="10%">{{ __('Employee Id') }}</th>
                                <th>{{ __('Employee') }}</th>
                                <th>{{ __('Branch') }}</th>
                                <th>{{ __('Department') }}</th>
                                <th>
                                    <div class="form-group my-auto">
                                        <div class="custom-control ">
                                            <input class="form-check-input" type="checkbox" name="present_all"
                                                   id="present_all" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="present_all">
                                                {{ __('Attendance') }}</label>
                                        </div>
                                    </div>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($employees as $employee)
                                @php
                                    $attendance = $employee->present_status($employee->id, isset($_GET['date']) ? $_GET['date'] : date('Y-m-d'));
                                @endphp
                                <tr>
                                    <td class="Id">
                                        <input type="hidden" value="{{ $employee->id }}" name="employee_id[]">
                                        <a href="{{ route('employee.show', \Illuminate\Support\Facades\Crypt::encrypt($employee->id)) }}"
                                           class=" btn btn-outline-primary">{{ \Auth::user()->employeeIdFormat($employee->employee_id) }}</a>
                                    </td>
                                    <td>{{ $employee->name }}</td>
                                    <td>{{ !empty($employee->branch) ? $employee->branch->name : '' }}</td>
                                    <td>{{ !empty($employee->department) ? $employee->department->name : '' }}</td>
                                    <td>

                                        <div class="row">
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <div class="custom-control custom-checkbox mt-2">
                                                        <input class="form-check-input present" type="checkbox"
                                                               name="present-{{ $employee->id }}"
                                                               id="present{{ $employee->id }}"
                                                            {{ !empty($attendance) && $attendance->status == 'Present' ? 'checked' : '' }}>
                                                        <label class="custom-control-label"
                                                               for="present{{ $employee->id }}"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="col-md-11 present_check_in {{ empty($attendance) ? 'd-none' : '' }} ">
                                                <div class="row">
                                                    <label class="col-md-2 form-label mt-2">{{ __('In') }}</label>
                                                    <div class="col-md-4">
                                                        <input type="time" class="form-control timepicker"
                                                               name="in-{{ $employee->id }}"
                                                               value="{{ !empty($attendance) && $attendance->clock_in != '00:00:00' ? $attendance->clock_in : \Utility::getValByName('company_start_time') }}">
                                                    </div>

                                                    <label for="inputValue"
                                                           class="col-md-2 form-label mt-2">{{ __('Out') }}</label>
                                                    <div class="col-md-4">
                                                        <input type="time" class="form-control timepicker"
                                                               name="out-{{ $employee->id }}"
                                                               value="{{ !empty($attendance) && $attendance->clock_out != '00:00:00' ? $attendance->clock_out : \Utility::getValByName('company_end_time') }}">
                                                        <input type="hidden" value="{{ !empty($employee->branch) ? $employee->branch->id : '' }}" name="branch_id">
                                                        <input type="hidden" value="{{ !empty($employee->department) ? $employee->department->id : '' }}" name="department_id">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="attendance-btn float-end pt-4">
                        <input type="hidden" value="{{ isset($_GET['date']) ? $_GET['date'] : date('Y-m-d') }}" name="date">
                        <input type="hidden" value="{{ isset($_GET['branch']) ? $_GET['branch'] : '' }}" name="branch">
                        <input type="hidden" value="{{ isset($_GET['department']) ? $_GET['department'] : '' }}"
                               name="department">
                        {{ Form::submit(__('Update'), ['class' => 'btn btn-primary']) }}
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>

    </div>
@endsection

@push('script-page')
    {{--    <script>--}}
    {{--        $(document).ready(function () {--}}
    {{--            $('.daterangepicker').daterangepicker({--}}
    {{--                format: 'yyyy-mm-dd',--}}
    {{--                locale: {format: 'YYYY-MM-DD'},--}}
    {{--            });--}}
    {{--        });--}}
    {{--    </script>--}}
@endpush
