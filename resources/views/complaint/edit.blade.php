    {{Form::model($complaint,array('route' => array('complaint.update', $complaint->id), 'method' => 'PUT')) }}
    <div class="modal-body">

    <div class="row">
        @if(\Auth::user()->type !='employee')
        <div class="form-group col-md-6 col-lg-6">
            {{Form::label('warning_to',__('Warning To'),['class'=>'form-label'])}}
        {{Form::label('branch_id_from',__('Branch'),['class'=>'form-label'])}}
        {{Form::select('branch_id_from',$branch,null,array('class'=>'form-control select', 'id' => 'branch_id_from'))}}
        <hr>
        {{Form::label('warning_to',__('Warning To'),['class'=>'form-label'])}}
        {{Form::label('department_id_from',__('Department'),['class'=>'form-label'])}}
        {{Form::select('department_id_from',$departments,null,array('class'=>'form-control select', 'id' => 'department_from'))}}
        <hr>
        {{Form::label('warning_to',__('Warning To'),['class'=>'form-label'])}}
        {{Form::label('employee_id_from',__('Employee'),['class'=>'form-label'])}}
        {{ Form::select('employee_id_from', $employees,null, array('class' => 'form-control select','required'=>'required', 'id' => 'employee_from')) }}
        </div>
        @endif
        <div class="form-group col-md-6 col-lg-6">
            {{Form::label('warning_to',__('Warning To'),['class'=>'form-label'])}}
            {{Form::label('branch_id_against',__('Branch'),['class'=>'form-label'])}}
            {{Form::select('branch_id_against',$branch2,null,array('class'=>'form-control select', 'id' => 'branch_id_against'))}}
            <hr>
            {{Form::label('warning_to',__('Warning To'),['class'=>'form-label'])}}
            {{Form::label('department_id_against',__('Department'),['class'=>'form-label'])}}
            {{Form::select('department_id_against',$departments2,null,array('class'=>'form-control select', 'id' => 'department_against'))}}
            <hr>
            {{Form::label('warning_to',__('Warning To'),['class'=>'form-label'])}}
            {{Form::label('employee_id_against',__('Employee'),['class'=>'form-label'])}}
            {{ Form::select('employee_id_against', $employees2,null, array('class' => 'form-control select','required'=>'required', 'id' => 'employee_against')) }}
        </div>
        <div class="form-group col-md-6 col-lg-6">
            {{Form::label('title',__('Title'),['class'=>'form-label'])}}
            {{Form::text('title',null,array('class'=>'form-control'))}}
        </div>
        <div class="form-group col-md-6 col-lg-6">
            {{Form::label('complaint_date',__('Complaint Date'),['class'=>'form-label'])}}
            {{Form::date('complaint_date',null,array('class'=>'form-control'))}}
        </div>
        <div class="form-group col-md-12">
            {{Form::label('description',__('Description'),['class'=>'form-label'])}}
            {{Form::textarea('description',null,array('class'=>'form-control','placeholder'=>__('Enter Description')))}}
        </div>
           
    </div>
    </div>
    <div class="modal-footer">
        <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
        <input type="submit" value="{{__('Update')}}" class="btn  btn-primary">
    </div>
    {{Form::close()}}

