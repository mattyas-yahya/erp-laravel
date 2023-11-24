@extends('layouts.admin')
@section('page-title')
    {{__('Assets')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Assets')}}</li>
@endsection
@php
    $profile=\App\Models\Utility::get_file('uploads/avatar/');
@endphp


@section('action-btn')
    <div class="float-end">
        @can('create assets')
            <a href="#" data-url="{{ route('account-assets.create') }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Create New Assets')}}" data-bs-toggle="tooltip" title="{{__('Create')}}"  class="btn btn-sm btn-primary">
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
                                <th>{{__('Employee Name')}}</th>
                                <th>{{__('Branch')}}</th>
                                <th>{{__('Department')}}</th>
                                <th>{{__('Name')}}</th>
                                <th>{{__('Users')}}</th>
                                <th>{{__('Purchase Date')}}</th>
                                <th>{{__('Supported Date')}}</th>
                                <th>{{__('Amount')}}</th>
                                <th>{{__('Description')}}</th>
                                <th>{{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($assets as $asset)
                                <tr>
                                    <td>{{ !empty($asset->employees())?$asset->employees()->name:'' }}</td>
                                    <td>{{ !empty($asset->branch())?$asset->branch()->name:'' }}</td>
                                    <td>{{ !empty($asset->department())?$asset->department()->name:'' }}</td>
                                    <td class="font-style">{{ $asset->name }}</td>
                                    <td>
                                        <div class="avatar-group">
                                            @foreach($asset->users($asset->employee_id) as $user)
                                                <a href="#" class="avatar rounded-circle avatar-sm avatar-group">
                                                    <img alt="" @if(!empty($user->avatar)) src="{{$profile.'/'.$user->avatar}}"
                                                         @else src="{{asset('/storage/uploads/avatar/avatar.png')}}"
                                                         @endif data-original-title="{{(!empty($user)?$user->name:'')}}"
                                                         data-bs-toggle="tooltip" data-original-title="{{(!empty($user)?$user->name:'')}}" class="">
                                                </a>
                                            @endforeach
                                        </div>

                                    </td>

                                    <td class="font-style">{{ \Auth::user()->dateFormat($asset->purchase_date) }}</td>
                                    <td class="font-style">{{ \Auth::user()->dateFormat($asset->supported_date) }}</td>
                                    <td class="font-style">Rp. {{ $asset->amount }}</td>
                                    <td class="font-style">{{ !empty($asset->description)?$asset->description:'-' }}</td>
                                    <td class="Action">
                                        <span>
                                        @can('edit assets')
                                                <div class="action-btn bg-primary ms-2">
                                                <a href="#" class="mx-3 btn btn-sm align-items-center" data-url="{{ route('account-assets.edit',$asset->id) }}" data-ajax-popup="true" data-size="lg" data-title="{{__('Edit Assets')}}" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}">
                                                <i class="ti ti-pencil text-white"></i>
                                            </a>
                                            </div>
                                            @endcan
                                            @can('delete assets')
                                                <div class="action-btn bg-danger ms-2">
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['account-assets.destroy', $asset->id],'id'=>'delete-form-'.$asset->id]) !!}

                                                <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$asset->id}}').submit();">
                                                    <i class="ti ti-trash text-white text-white"></i>
                                                </a>
                                                {!! Form::close() !!}
                                                    @endcan
                                            </div>
                                        </span>
                                    </td>
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
        $(document).on("keypress", ".just-number", function (e) {
  let charCode = (e.which) ? e.which : e.keyCode;
  if (charCode > 31 && (charCode < 48 || charCode > 57)) {
    return false;
  }
});
$(document).on('keyup', '.price-format-input', function (e) {
  let val = this.value;
  val = val.replace(/,/g, "");
  if (val.length > 3) {
    let noCommas = Math.ceil(val.length / 3) - 1;
    let remain = val.length - (noCommas * 3);
    let newVal = [];
    for (let i = 0; i < noCommas; i++) {
      newVal.unshift(val.substr(val.length - (i * 3) - 3, 3));
    }
    newVal.unshift(val.substr(0, remain));
    this.value = newVal;
  }
  else {
    this.value = val;
  }
});

$(document).ready(function(){
  $('#amount').focus();
});

$(document).on('change', 'select[name=branch_id]', function () {
        var idBranch = this.value;
        $("#department").html('');
        $.ajax({
            url: "{{url('account-assets/getdepartment/json')}}",
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
            url: "{{url('account-assets/getemployee/json')}}",
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