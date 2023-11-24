@extends('layouts.admin')
@section('page-title')
{{ __('Detail Purchase Request') }} - {{ $pr->pr_number }}
@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
<li class="breadcrumb-item"><a href="{{route('purchase-request.index')}}">{{__('Purchase request')}}</a></li>
<li class="breadcrumb-item">{{__('Detail Purchase Request')}}</li>
@endsection

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h5>*Purchase Requisition Header</h5>
                <div class="row">
                    <div class="form-group col-md-4">
                        {!! Form::label('created_at', __('Created Date'),['class'=>'form-label']) !!}
                        {!! Form::text('created_at', \Auth::user()->dateFormat($pr->created_at), ['class' => 'form-control', 'readonly']) !!}
                    </div>
                    <div class="form-group col-md-4">
                        {!! Form::label('pr_number', __('PR Number'),['class'=>'form-label']) !!}
                        {!! Form::text('name', $pr->pr_number, ['class' => 'form-control', 'readonly']) !!}
                    </div>
                    <div class="form-group col-md-4">
                        {!! Form::label('name', __('Name'),['class'=>'form-label']) !!}
                        {!! Form::text('name',$pr->name, ['class' => 'form-control', 'readonly']) !!}
                    </div>
                    <div class="form-group col-md-4">
                        {!! Form::label('request_date', __('Request Date'),['class'=>'form-label']) !!}
                        {!! Form::date('request_date', $pr->request_date, ['class' => 'form-control', 'readonly'])
                        !!}
                    </div>
                    <div class="form-group col-md-4">
                        {!! Form::label('date_required', __('Date Required'),['class'=>'form-label']) !!}
                        {!! Form::date('date_required', $pr->date_required, ['class' => 'form-control', 'readonly'])
                        !!}
                    </div>
                    <div class="form-group col-md-4">
                        {!! Form::label('branch', __('Branch'),['class'=>'form-label']) !!}
                        {{ Form::text('branch_id', $pr->branch()->name, array('class' => 'form-control',
                        'readonly')) }}
                    </div>
                    <div class="form-group col-md-4">
                        {!! Form::label('department', __('Department'),['class'=>'form-label']) !!}
                        {{ Form::text('department_id', $pr->department()->name, array('class' => 'form-control',
                        'readonly')) }}
                    </div>
                    <div class="form-group col-md-4">
                        {!! Form::label('requester', __('Requester'),['class'=>'form-label']) !!}
                        {{ Form::text('employee_id', $pr->employee()->name, array('class' => 'form-control',
                        'readonly')) }}
                    </div>
                </div>
                @if ($pr->status != 'Created')
                <div class="col-auto float-end ms-2">
                    <a href="#" data-url="{{ route('purchase-request.create_requisition',$pr->id) }}" data-size="lg"
                        data-bs-toggle="tooltip" title="{{__('Add new line')}}" data-ajax-popup="true"
                        data-title="{{__('Add new line')}} {{__('Purchase Requisition')}}"
                        class="btn btn-sm btn-primary">
                        <i class="ti ti-plus"></i> {{__('Add new line')}}
                    </a>
                </div>

                <div class="col-auto float-end ms-2">
                    {{Form::model($pr,array('route' => array('purchase-request.update', $pr->id), 'method' => 'PATCH'))
                    }}
                    <input type="hidden" name="branch_id" value="{{ $pr->branch_id }}">
                    <input type="hidden" name="department_id" value="{{ $pr->department_id }}">
                    <input type="hidden" name="employee_id" value="{{ $pr->employee_id }}">
                    <input type="hidden" name="request_date" value="{{ $pr->request_date }}">
                    <input type="hidden" name="date_required" value="{{ $pr->date_required }}">
                    <input type="hidden" name="name" value="{{ $pr->name }}">
                    <input type="hidden" name="status" value="Created">
                    <button type="submit" class="btn btn-sm btn-danger" data-bs-toggle="tooltip">
                        {{__('Post!')}}
                    </button>
                    {{ Form::close() }}
                </div>                
                @else

                @endif
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body table-border-style">
                <h5>*Purchase Requisition Line</h5>
                <div class="table-responsive">
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>{{__('PR Number')}}</th>
                                <th>{{__('Requester')}}</th>
                                <th>{{__('SKU')}}</th>
                                <th>{{__('SPEC')}}</th>
                                <th>{{__('Qty')}}</th>
                                <th>{{__('Note')}}</th>
                                <th>{{__('Dimensions')}}</th>
                                <th>{{__('Manufacture')}}</th>
                                <th>{{__('Weight')}}</th>
                                <th>{{__('Unit')}}</th>
                                @if(Gate::check('edit attendance') || Gate::check('delete attendance'))
                                <th>{{__('Action')}}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($datarequisition as $item)
                            <tr>
                                <td>{{ $item->pr_number }}</td>
                                <td>{{ $item->purchase_request_head()->employee()->name }}</td>
                                <td>{{ $item->sku_number }}</td>
                                <td>{{ $item->product_name }}</td>
                                <td>{{ $item->qty }}</td>
                                <td>{{ $item->note }}</td>
                                <td>{{ $item->dimensions }}</td>
                                <td>{{ $item->manufacture }}</td>
                                <td>{{ $item->weight }}</td>
                                <td>{{ $item->unit()->name }}</td>
                                @if(Gate::check('edit attendance') || Gate::check('delete attendance'))
                                <td>
                                    {{-- <div class="action-btn bg-primary ms-2">
                                        <a href="#" data-url="{{ URL::to('purchase-request/'.$item->id.'/edit') }}"
                                            data-size="lg" data-ajax-popup="true" data-title="{{__('Edit Attendance')}}"
                                            class="mx-3 btn btn-sm align-items-center" data-bs-toggle="tooltip"
                                            title="{{__('Edit')}}" data-original-title="{{__('Edit')}}">
                                            <i class="ti ti-pencil text-white"></i></a>
                                    </div> --}}
                                    @if ($pr->status != 'Created')
                                        @can('delete attendance')
                                        <div class="action-btn bg-danger ms-2">
                                            {!! Form::open(['method' => 'DELETE', 'route' =>
                                            ['purchase-request.destroy_requisition',
                                            $item->id],'id'=>'delete-form-'.$item->id]) !!}

                                            <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para"
                                                data-bs-toggle="tooltip" title="{{__('Delete')}}"
                                                data-original-title="{{__('Delete')}}"
                                                data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}"
                                                data-confirm-yes="document.getElementById('delete-form-{{$item->id}}').submit();">
                                                <i class="ti ti-trash text-white"></i></a>
                                            {!! Form::close() !!}
                                        </div>
                                        @endcan
                                        @else
                                        <p>-</p>
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
<script>
    $(document).on('change', 'select[name=branch_id]', function () {
        var idBranch = this.value;
        $("#department").html('');
        $.ajax({
            url: "{{url('purchase-request/getdepartment/json')}}",
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
            url: "{{url('purchase-request/getemployee/json')}}",
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