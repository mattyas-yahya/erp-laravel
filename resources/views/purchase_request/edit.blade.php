{{Form::model($pr,array('route' => array('purchase-request.update', $pr->id), 'method' => 'PATCH')) }}
<div class="modal-body">
    <div class="row">        
        <input type="hidden" name="status" value="{{ $pr->status }}">
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('branch_id',__('Branch'),['class'=>'form-label'])}}
            {{Form::select('branch_id',$branch,null,array('class'=>'form-control select','required'=>'required', 'id' => 'branch_id'))}}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('department_id',__('Department'),['class'=>'form-label'])}}
            {{Form::select('department_id',$departments,null,array('class'=>'form-control select','required'=>'required', 'id' => 'department'))}}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{ Form::label('employee_id', __('Requester'),['class'=>'form-label'])}}
            {{ Form::select('employee_id', $employees,null, array('class' => 'form-control select','required'=>'required', 'id' => 'employee')) }}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('request_date',__('Request Date'),['class'=>'form-label'])}}
            {{Form::date('request_date',null,array('class'=>'form-control'))}}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('date_required',__('Date Required'),['class'=>'form-label'])}}
            {{Form::date('date_required',null,array('class'=>'form-control'))}}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('name',__('Name'),['class'=>'form-label'])}}
            {{Form::text('name',null,array('class'=>'form-control'))}}
        </div>

    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Update')}}" class="btn  btn-primary">
</div>
    {{ Form::close() }}
