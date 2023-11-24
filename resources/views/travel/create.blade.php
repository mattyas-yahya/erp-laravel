{{Form::open(array('url'=>'travel','method'=>'post'))}}
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
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('department_id',__('Department'),['class'=>'form-label'])}}
            <select name="department_id" id="department" class="form-control " required>
            </select>
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{ Form::label('employee_id', __('Employee'),['class'=>'form-label'])}}
            <select name="employee_id" id="employee" class="form-control " required>
            </select>
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('start_date',__('Start Date'),['class'=>'form-label'])}}
            {{Form::date('start_date',null,array('class'=>'form-control'))}}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('end_date',__('End Date'),['class'=>'form-label'])}}
            {{Form::date('end_date',null,array('class'=>'form-control'))}}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('purpose_of_visit',__('Purpose of Trip'),['class'=>'form-label'])}}
            {{Form::text('purpose_of_visit',null,array('class'=>'form-control'))}}
        </div>
        <div class="form-group col-md-6">
            {{Form::label('place_of_visit',__('Country'),['class'=>'form-label'])}}
            {{Form::text('place_of_visit',null,array('class'=>'form-control'))}}
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
