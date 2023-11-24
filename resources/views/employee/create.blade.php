@extends('layouts.admin')
@section('page-title')
    {{__('Create Employee')}}
@endsection
@section('content')
    <div class="row">
        {{Form::open(array('route'=>array('employee.store'),'method'=>'post','enctype'=>'multipart/form-data', 'autocomplete'=>'off'))}}
    </div>
    <div class="row">
        <div class="col-md-6 ">
            <div class="card card-fluid">
                <div class="card-header"><h6 class="mb-0">{{__('Personal Detail')}}</h6></div>
                <div class="card-body ">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="name" class="form-label">Nama</label><span class="text-danger pl-1">*</span>
                            <input class="form-control @error('name') is-invalid @enderror" name="name" type="text" id="name" value="{{ old('name') }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="phone" class="form-label">Phone</label><span class="text-danger pl-1">*</span>
                            <input class="form-control @error('phone') is-invalid @enderror" name="phone" type="text" id="phone" value="{{ old('phone') }}">
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date_of_birth" class="form-label">Tanggal Lahir</label><span class="text-danger pl-1">*</span>
                                <input class="form-control @error('date_of_birth') is-invalid @enderror" name="date_of_birth" type="date" id="date_of_birth" value="{{ old('date_of_birth') }}">
                                @error('date_of_birth')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group ">
                                {!! Form::label('gender', __('Gender'),['class'=>'form-label']) !!}<span class="text-danger pl-1">*</span>
                                <br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" value="Male" name="gender" id="g_male">
                                    <label class="form-check-label" for="inlineRadio1">{{__('Male')}}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" value="Female" name="gender" id="g_female">
                                    <label class="form-check-label" for="inlineRadio2">{{__('Female')}}</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="email" class="form-label">Email</label><span class="text-danger pl-1">*</span>
                            <input class="form-control @error('email') is-invalid @enderror" name="email" type="text" id="email" value="{{ old('email') }}">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="password" class="form-label">Password</label><span class="text-danger pl-1">*</span>
                            <input class="form-control @error('password') is-invalid @enderror" name="password" type="password" id="password" value="{{ old('password') }}">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('address', __('Address'),['class'=>'form-label']) !!}<span class="text-danger pl-1">*</span>
                        {!! Form::textarea('address',old('address'), ['class' => 'form-control','rows'=>2]) !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 ">
            <div class="card card-fluid">
                <div class="card-header"><h6 class="mb-0">{{__('Company Detail')}}</h6></div>
                <div class="card-body employee-detail-create-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            {!! Form::label('employee_id', __('Employee ID'),['class'=>'form-label']) !!}
                            {!! Form::text('employee_id', $employeesId, ['class' => 'form-control','readonly'=>'true']) !!}
                        </div>

                        <div class="form-group col-md-6">
                            {{ Form::label('branch_id', __('Branch'),['class'=>'form-label']) }}
                            <select class="form-control" id="branch_id" name="branch_id" data-toggle="select2" data-placeholder="{{ __('Select Branch') }}">
                                <option value="">{{__('Select Branch')}}</option>
                                @foreach ($branches as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            {{ Form::label('department_id', __('Department'),['class'=>'form-label']) }}
                            <select class="form-control" id="department_id" name="department_id" data-placeholder="{{ __('Select Department') }}">
                                <option value="">{{__('Select Department')}}</option>
                                @foreach ($departments as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-12">
                            {{ Form::label('designation_id', __('Designation'),['class'=>'form-label']) }}
                            <select class="select2 form-control select2-multiple" id="designation_id" name="designation_id" data-placeholder="{{ __('Select Designation ...') }}">
                                <option value="">{{__('Select any Designation')}}</option>
                            </select>
                        </div>
                        {{-- <div class="form-group col-md-12 ">
                            {!! Form::label('company_doj', __('Company Date Of Joining'),['class'=>'form-label']) !!}
                            {!! Form::text('company_doj', null, ['class' => 'form-control datepicker','required' => 'required']) !!}
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="row">
        <div class="col-md-6 ">
            <div class="card card-fluid">
                <div class="card-header"><h6 class="mb-0">{{__('Document')}}</h6></div>
                <div class="card-body employee-detail-create-body">
                    @foreach($documents as $key=>$document)
                        <div class="row">
                            <div class="form-group col-12">
                                <div class="float-left col-4">
                                    <label for="document" class="float-left pt-1 form-label">{{ $document->name }} @if($document->is_required == 1) <span class="text-danger">*</span> @endif</label>
                                </div>
                                <div class="float-right col-8">
                                    <input type="hidden" name="emp_doc_id[{{ $document->id}}]" id="" value="{{$document->id}}">
                                    <div class="choose-file form-group">
                                        <label for="document[{{ $document->id }}]">
                                            <div>{{__('Choose File')}}</div>
                                            <input class="form-control  @error('document') is-invalid @enderror border-0" @if($document->is_required == 1) required @endif name="document[{{ $document->id}}]" type="file" id="document[{{ $document->id }}]" data-filename="{{ $document->id.'_filename'}}">
                                        </label>
                                        <p class="{{ $document->id.'_filename'}}"></p>
                                    </div>

                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-6 ">
            <div class="card card-fluid">
                <div class="card-header"><h6 class="mb-0">{{__('Bank Account Detail')}}</h6></div>
                <div class="card-body employee-detail-create-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            {!! Form::label('account_holder_name', __('Account Holder Name'),['class'=>'form-label']) !!}
                            {!! Form::text('account_holder_name', old('account_holder_name'), ['class' => 'form-control']) !!}

                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('account_number', __('Account Number'),['class'=>'form-label']) !!}
                            {!! Form::number('account_number', old('account_number'), ['class' => 'form-control']) !!}

                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('bank_name', __('Bank Name'),['class'=>'form-label']) !!}
                            {!! Form::text('bank_name', old('bank_name'), ['class' => 'form-control']) !!}

                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('bank_identifier_code', __('Bank Identifier Code'),['class'=>'form-label']) !!}
                            {!! Form::text('bank_identifier_code',old('bank_identifier_code'), ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('branch_location', __('Branch Location'),['class'=>'form-label']) !!}
                            {!! Form::text('branch_location',old('branch_location'), ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('tax_payer_id', __('Tax Payer Id'),['class'=>'form-label']) !!}
                            {!! Form::text('tax_payer_id',old('tax_payer_id'), ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="row">
        <div class="col-12 text-end">
            <button type="submit" class="btn btn-xs btn-primary radius-10px">
                {{__('Create')}}
            </button>
            <a href="{{ route('employee.index') }}" class="btn btn-xs btn-secondary radius-10px">
                {{__('Back')}}
            </a>
            {{-- {!! Form::submit('Create', ['class' => 'btn btn-xs btn-primary  float-right radius-10px']) !!} --}}
{{--            </form>--}}
            {{Form::close()}}
        </div>
    </div>
@endsection

@push('script-page')

    <script>

        $(document).ready(function () {
            var d_id = $('#department_id').val();
            getDesignation(d_id);
        });

        $(document).on('change', 'select[name=department_id]', function () {
            var department_id = $(this).val();
            getDesignation(department_id);
        });

        function getDesignation(did) {

            $.ajax({
                url: '{{route('employee.json')}}',
                type: 'POST',
                data: {
                    "department_id": did, "_token": "{{ csrf_token() }}",
                },
                success: function (data) {
                    $('#designation_id').empty();
                    $('#designation_id').append('<option value="">{{__('Select any Designation')}}</option>');
                    $.each(data, function (key, value) {
                        $('#designation_id').append('<option value="' + key + '">' + value + '</option>');
                    });
                }
            });
        }
    </script>
@endpush
