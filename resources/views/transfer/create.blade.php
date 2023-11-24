{{Form::open(array('url'=>'transfer','method'=>'post'))}}
<div class="modal-body">

    <div class="row">

        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('branch_id',__('Branch'),['class'=>'form-label'])}}
            <select class="form-control select" name="branch_id" id="branch_id" placeholder="Select Branch">
                <option value="">{{__('Select Branch')}}</option>
                @foreach($branch as $branch)
                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                @endforeach
            </select>
            {{-- {{Form::select('branch_id',$branches,null,array('class'=>'form-control select'))}} --}}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('department_id',__('Department'),['class'=>'form-label'])}}
            <select name="department_id" id="department" class="form-control " required>
            </select>
            {{-- {{Form::select('department_id',$departments,null,array('class'=>'form-control select'))}} --}}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{ Form::label('employee_id', __('Employee'),['class'=>'form-label'])}}
            <select name="employee_id" id="employee" class="form-control " required>
            </select>
            {{-- {{ Form::select('employee_id', $employees,null, array('class' => 'form-control
            select','required'=>'required')) }} --}}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('transfer_date',__('Transfer Date'),['class'=>'form-label'])}}
            {{Form::date('transfer_date',null,array('class'=>'form-control '))}}
        </div>
        <hr>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('branch_id_to',__('Branch Destination'),['class'=>'form-label'])}}
            <select class="form-control select" name="branch_id_to" id="branch_id_to" placeholder="Select Branch">
                <option value="">{{__('Select Branch')}}</option>
                @foreach($branch2 as $branch)
                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                @endforeach
            </select>
            {{-- {{Form::select('branch_id',$branches,null,array('class'=>'form-control select'))}} --}}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('department_id',__('Department Destination'),['class'=>'form-label'])}}
            <select name="department_id_to" id="department_id_to" class="form-control " required>
            </select>
            {{-- {{Form::select('department_id',$departments,null,array('class'=>'form-control select'))}} --}}
        </div>
        <div class="form-group col-lg-12">
            {{Form::label('description',__('Description'),['class'=>'form-label'])}}
            {{Form::textarea('description',null,array('class'=>'form-control','placeholder'=>__('Enter Description')))}}
        </div>

    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
</div>
{{Form::close()}}