{{ Form::open(array('route' => 'purchase-request.store_requisition','method'=>'post')) }}
<div class="modal-body">
    <div class="row">
        <input type="hidden" name="pr_id" value="{{ $pr->id }}">
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('pr_number',__('PR Number'),['class'=>'form-label'])}}
            {{Form::text('pr_number',$pr->pr_number,array('class'=>'form-control','readonly'))}}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('employee_id',__('Requester'),['class'=>'form-label'])}}
            {{Form::text('employee_id',$pr->employee()->name,array('class'=>'form-control','readonly'))}}
        </div>
        {{-- <div class="col-md-12">
            <div class="form-group">
                <div class="btn-box">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input type" id="customRadio5" name="type"
                                    value="old" checked="checked">
                                <label class="custom-control-label form-label" for="customRadio5">{{__('Existing
                                    Product')}}</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input type" id="customRadio6" name="type"
                                    value="new">
                                <label class="custom-control-label form-label" for="customRadio6">{{__('New')}}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="form-group  col-md-12">
            {{ Form::label('existing', __('Existing Product'),['class'=>'form-label']) }}
            {{-- {{ Form::select('employee_id', $dataproduct,null, array('class' => 'form-control
            select2','id'=>'choices-multiple')) }} --}}
            <select class="form-control select2" name="product_services_id" id="choices-multiple">
                <option value="">  </option>
                @foreach($dataproduct as $item)
                <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('sku_number',__('SKU'),['class'=>'form-label'])}}
            {{Form::text('sku_number','-',array('class'=>'form-control', 'readonly'))}}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('product_name',__('Product Name'),['class'=>'form-label'])}}
            {{Form::text('product_name',null,array('class'=>'form-control'))}}
            <p><i>*{{ __('new products written immediately') }}</i></p>
        </div>        

        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('qty',__('Qty'),['class'=>'form-label'])}}
            {{Form::number('qty',null,array('class'=>'form-control'))}}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('unit',__('Unit'),['class'=>'form-label'])}}
            <select class="form-control select" name="unit_id" id="unit_id">
                @foreach($unit as $item)
                <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('dimensions', __('Dimensions'),['class'=>'form-label']) }}<span class="text-danger">*</span>
                {{ Form::text('dimensions', null, array('class' => 'form-control')) }}
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('manufacture', __('Manufacture'),['class'=>'form-label']) }}<span class="text-danger">*</span>
                {{ Form::text('manufacture', null, array('class' => 'form-control')) }}
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('weight', __('Weight'),['class'=>'form-label']) }}<span class="text-danger">*</span>
                {{ Form::text('weight', null, array('class' => 'form-control')) }}
            </div>
        </div>
        <div class="form-group col-md-12">
            {{Form::label('note',__('Description'))}}
            {{Form::textarea('note',null,array('class'=>'form-control','placeholder'=>__('Enter Description')))}}
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
</div>
{{ Form::close() }}


<script>
    $('#choices-multiple').change(function(){
        var productservice = this.value;
        console.log(productservice);
        $.ajax({
            url: "{{url('purchase-request/getproductservice/json')}}",
            type: "POST",
            data: {
                product_services_id: productservice,
                _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function (result) {
                if (productservice) {                    
                    console.log(result.productservice);
                    $('#sku_number').val(result.productservice.sku);
                    $('#product_name').val(result.productservice.name);
                    $('#unit_id').val(result.productservice.unit_id);
                    $('#dimensions').val(result.productservice.dimensions);
                    $('#manufacture').val(result.productservice.manufacture);
                    $('#weight').val(result.productservice.weight);
                }else{                    
                    $('#sku_number').val('-');
                    $('#product_name').val('');
                    $('#unit_id').val('');
                    $('#dimensions').val('');
                    $('#manufacture').val('');
                    $('#weight').val('');
                }
            }
        });
    });
    //hide & show product
    // $('#newproduct').hide();
    // $('#newproduct2').hide();
    // $(document).on('click', '.type', function ()
    // {
    //     var type = $(this).val();
    //     if (type == 'old') {
    //         $('#existproduct').show();
    //         $('#newproduct').hide();
    //         $('#newproduct2').hide();   
    //     } else {
    //         $('#existproduct').hide();
    //         $('#newproduct').show();
    //         $('#newproduct2').show();
    //     }
    // });
    
</script>