{{Form::open(array('url'=>'designation','method'=>'post'))}}
    <div class="modal-body">

    <div class="row">
        <div class="col-12">
            {{-- <div class="form-group">
                {{ Form::label('branch_id', __('Branch'),['class'=>'form-label']) }}
                {{ Form::select('branch_id', $branches,null, array('class' => 'form-control select','required'=>'required','id' => 'branch_id')) }}
            </div>
            <div class="form-group">
                {{ Form::label('department_id', __('Department'),['class'=>'form-label']) }}
                <select class=" select form-control " id="department_id" name="department_id"  >
                                   <option value="">{{__('Select any Department')}}</option>
                    @foreach($departmentData as $key=>$val )
                        <option value="{{$key}}" {{$key==$employee->department_id?'selected':''}}>{{$val}}</option>
                    @endforeach
                </select>

            </div> --}}
            <div class="form-group">
                {{ Form::label('department_id', __('Department'),['class'=>'form-label']) }}
                {{ Form::select('department_id', $departments,null, array('class' => 'form-control select','required'=>'required')) }}
            </div>
            <div class="form-group">
                {{Form::label('name',__('Name'),['class'=>'form-label'])}}
                {{Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter Designation Name')))}}
                @error('name')
                <span class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

    </div>
    </div>
    <div class="modal-footer">
        <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
        <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
    </div>
    {{Form::close()}}

