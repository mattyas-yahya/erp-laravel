{{ Form::open(array('url' => 'goods-receipt/store','method'=>'post')) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group  col-md-12">
            {{ Form::label('po_id', __('Purchase order'),['class'=>'form-label']) }}<span class="text-danger">*</span>
            <select class="form-control select2" name="po_id" id="choices-multiple" required>
                <option value="">  </option>
                @foreach($po as $item)
                <option value="{{ $item->id }}">{{ $item->po_number }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('no_sp',__('No. SP'),['class'=>'form-label'])}}
            {{Form::text('no_sp',null,array('class'=>'form-control','required'))}}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('date_goodscome',__('Goods Come'),['class'=>'form-label'])}}
            <input type="datetime-local" name="date_goodscome" class="form-control" required>
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('customers_id',__('Owner'),['class'=>'form-label'])}}<span class="text-danger">*</span>
            <select class="form-control select" name="customers_id" id="customers_id" required>
                <option value="">{{__('Select Owner')}}</option>
                @foreach($customers as $item)
                <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-12">
            {{Form::label('description',__('Description'))}}
            {{Form::textarea('description',null,array('class'=>'form-control','placeholder'=>__('Enter Description')))}}
        </div>

    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
</div>
    {{ Form::close() }}