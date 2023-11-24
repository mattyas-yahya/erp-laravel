{{Form::open(array('url'=>'warning','method'=>'post'))}}
<div class="modal-body">
    <div class="row">
        @if(\Auth::user()->type != 'employee')            
            <div class="form-group col-md-6 col-lg-6 ">
                {{ Form::label('warning_by', __('Warning By'),['class'=>'form-label'])}}
                {{Form::label('branch_id_from',__('Branch'),['class'=>'form-label'])}}
                <select class="form-control select" name="branch_id_from" id="branch_id_from" placeholder="Select Branch">
                    <option value="">{{__('Select Branch')}}</option>
                    @foreach($branch as $branch)
                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                    @endforeach
                </select>
                <hr>
                {{ Form::label('warning_by', __('Warning By'),['class'=>'form-label'])}}
                {{Form::label('department_id_from',__('Department'),['class'=>'form-label'])}}
                <select name="department_id_from" id="department_from" class="form-control " required>
                </select>
                <hr>
                {{ Form::label('warning_by', __('Warning By'),['class'=>'form-label'])}}
                {{Form::label('employee_id_from',__('Employee'),['class'=>'form-label'])}}
                <select name="employee_id_from" id="employee_from" class="form-control " required>
                </select>
            </div>
        @endif
        <div class="form-group col-md-6 col-lg-6">
            {{Form::label('warning_to',__('Warning To'),['class'=>'form-label'])}}
            {{Form::label('branch_id_against',__('Branch'),['class'=>'form-label'])}}
            <select class="form-control select" name="branch_id_against" id="branch_id_against" placeholder="Select Branch">
                <option value="">{{__('Select Branch')}}</option>
                @foreach($branch2 as $branch)
                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                @endforeach
            </select>
            <hr>
            {{Form::label('warning_to',__('Warning To'),['class'=>'form-label'])}}
            {{Form::label('department_id_against',__('Department'),['class'=>'form-label'])}}
            <select name="department_id_against" id="department_against" class="form-control " required>
            </select>
            <hr>
            {{Form::label('warning_to',__('Warning To'),['class'=>'form-label'])}}
            {{Form::label('employee_id_against',__('Employee'),['class'=>'form-label'])}}
            <select name="employee_id_against" id="employee_against" class="form-control " required>
            </select>
        </div>
        <div class="form-group col-md-6 col-lg-6">
            {{Form::label('subject',__('Warning Type'),['class'=>'form-label'])}}
            <select class="form-control select" name="warning_type" placeholder="Select Type" required>
                <option value="Peringatan 1">Peringatan 1</option>
                <option value="Peringatan 2">Peringatan 2</option>
                <option value="Peringatan 3">Peringatan 3</option>                
            </select>
        </div>
        <div class="form-group col-md-6 col-lg-6">
            {{Form::label('subject',__('Subject'),['class'=>'form-label'])}}
            {{Form::text('subject',null,array('class'=>'form-control','required' => 'required'))}}
        </div>
        <div class="form-group col-md-6 col-lg-6">
            {{Form::label('warning_date',__('Warning Date'),['class'=>'form-label'])}}
            {{Form::date('warning_date',null,array('class'=>'form-control ','required' => 'required'))}}
        </div>
        <div class="form-group col-md-12">
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
