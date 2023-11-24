{{ Form::open(array('url' => 'purchase-request/store','method'=>'post')) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('branch_id',__('Branch'),['class'=>'form-label'])}}
            <select class="form-control select" name="branch_id" id="inputbranch_id" placeholder="Select Branch">
                <option value="">{{__('Select Branch')}}</option>
                @foreach($branch as $branch)
                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('department_id',__('Department'),['class'=>'form-label'])}}
            <select name="department_id" id="inputdepartment" class="form-control " required>
            </select>
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{ Form::label('employee_id', __('Requester'),['class'=>'form-label'])}}
            <select name="employee_id" id="inputemployee" class="form-control " required>
            </select>
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
    <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
</div>
    {{ Form::close() }}
    <script>
        $(document).on('change', 'select[name=branch_id]', function () {
            var idBranch = this.value;
            $("#inputdepartment").html('');
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
                    $('#inputdepartment').html('<option value="">Select Department</option>');
                    $.each(result.departments, function (key, value) {
                        $("#inputdepartment").append('<option value="' + value
                            .id + '">' + value.name + '</option>');
                    });
                    $('#inputemployee').html('<option value="">Select Employee</option>');
                }
            });
        });
        $(document).on('change', '#inputdepartment', function () {
            var idDepartment = this.value;
            $("#inputemployee").html('');
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
                    $('#inputemployee').html('<option value="">Select Employee</option>');
                    $.each(res.employees, function (key, value) {
                        $("#inputemployee").append('<option value="' + value
                            .id + '">' + value.name + '</option>');
                    });
                }
            });
        });
    </script>