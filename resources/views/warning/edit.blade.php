{{Form::model($warning,array('route' => array('warning.update', $warning->id), 'method' => 'PUT')) }}
<div class="modal-body">

     <div class="row">
        @if(\Auth::user()->type != 'employee')
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
            {{Form::label('subject',__('Warning Type'),['class'=>'form-label'])}}
            <select class="form-control select" name="warning_type" placeholder="Select Type" required>
                <option value="Peringatan 1" {{ $warning->warning_type == "Peringatan 1" ? 'selected' : '' }}>Peringatan 1</option>
                <option value="Peringatan 2" {{ $warning->warning_type == "Peringatan 2" ? 'selected' : '' }}>Peringatan 2</option>
                <option value="Peringatan 3" {{ $warning->warning_type == "Peringatan 3" ? 'selected' : '' }}>Peringatan 3</option>                
            </select>
        </div>
        {{-- <div class="form-group col-lg-6 col-md-6">
            {{Form::label('warning_to',__('Warning To'),['class'=>'form-label'])}}
            {{Form::select('warning_to',$employees,null,array('class'=>'form-control select'))}}
        </div> --}}
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('subject',__('Subject'),['class'=>'form-label'])}}
            {{Form::text('subject',null,array('class'=>'form-control'))}}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('warning_date',__('Warning Date'),['class'=>'form-label'])}}
            {{Form::date('warning_date',null,array('class'=>'form-control '))}}
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

