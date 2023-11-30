<div class="form-row">
    <div class="row">
        <div class="form-group col-2">
            {!! Form::label('detail_category', 'Jenis Perawatan', ['class' => 'form-label']) !!}
            {!! Form::text('detail_category[]', $item->category, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-2">
            {!! Form::label('detail_activity_type', 'Jenis Kegiatan', ['class' => 'form-label']) !!}
            {!! Form::text('detail_activity_type[]', $item->activity_type, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-2">
            {!! Form::label('detail_name', 'Nama Item', ['class' => 'form-label']) !!}
            {!! Form::text('detail_name[]', $item->name, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-2">
            {!! Form::label('detail_bin_location', 'Bin Location', ['class' => 'form-label']) !!}
            {!! Form::text('detail_bin_location[]', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-1">
            {!! Form::label('detail_planned_quantity', 'Qty', ['class' => 'form-label']) !!}
            {!! Form::text('detail_planned_quantity[]', $item->planned_quantity, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-2">
            {!! Form::label('detail_planned_cost', 'Harga', ['class' => 'form-label']) !!}
            {!! Form::number('detail_planned_cost[]', $item->planned_cost, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group row align-items-center col-1">
            {!! Form::label('', '', ['class' => 'form-label']) !!}
            <a href="#" class="mx-3 btn btn-sm btn-danger align-items-center delete-form-row"
                title="{{ __('Delete') }}" data-bs-toggle="tooltip">
                <i class="ti ti-trash text-white"></i></a>
        </div>
    </div>
    <hr />
</div>
