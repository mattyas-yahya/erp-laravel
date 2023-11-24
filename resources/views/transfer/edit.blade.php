{{Form::model($transfer,array('route' => array('transfer.update', $transfer->id), 'method' => 'PUT')) }}
<div class="modal-body">
   
    <div class="row">
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('branch_id',__('Branch'),['class'=>'form-label'])}}
            {{Form::select('branch_id',$branch,null,array('class'=>'form-control select','required'=>'required', 'id' => 'branch_id'))}}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('department_id',__('Department'),['class'=>'form-label'])}}
            {{Form::select('department_id',$departments,null,array('class'=>'form-control select','required'=>'required', 'id' => 'department'))}}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{ Form::label('employee_id', __('Employee'),['class'=>'form-label'])}}
            {{ Form::select('employee_id', $employees,null, array('class' => 'form-control select','required'=>'required', 'id' => 'employee')) }}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('transfer_date',__('Transfer Date'),['class'=>'form-label'])}}
            {{Form::date('transfer_date',null,array('class'=>'form-control datepicker'))}}
        </div>
        <hr>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('branch_id_to',__('Branch Destination'),['class'=>'form-label'])}}
            {{Form::select('branch_id_to',$branch2,null,array('class'=>'form-control select','required'=>'required', 'id' => 'branch_id_to'))}}            
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('department_id',__('Department Destination'),['class'=>'form-label'])}}
            {{Form::select('department_id_to',$departments2,null,array('class'=>'form-control select','required'=>'required', 'id' => 'department_id_to'))}}            
        </div>
        <div class="form-group col-lg-12">
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
