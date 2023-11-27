<div class="form-row">
    <div class="row">
        <div class="form-group col-md-3">
            {!! Form::label('detail_category', 'Jenis Perawatan', ['class' => 'form-label']) !!}
            {!! Form::text('detail_category[]', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-3">
            {!! Form::label('detail_activity_type', 'Jenis Kegiatan', ['class' => 'form-label']) !!}
            {!! Form::text('detail_activity_type[]', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-3">
            {!! Form::label('detail_name', 'Nama Item', ['class' => 'form-label']) !!}
            {!! Form::text('detail_name[]', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-3">
            {!! Form::label('detail_bin_location', 'Bin Location', ['class' => 'form-label']) !!}
            {!! Form::text('detail_bin_location[]', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-3">
            {!! Form::label('detail_planned_quantity', 'Qty', ['class' => 'form-label']) !!}
            {!! Form::text('detail_planned_quantity[]', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-3">
            {!! Form::label('detail_planned_cost', 'Price', ['class' => 'form-label']) !!}
            {!! Form::number('detail_planned_cost[]', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="row">
        <div class="form-group row align-items-center col-md-2">
            {!! Form::label('', '', ['class' => 'form-label']) !!}
            <input type="button" value="{{ __('Delete') }}"
                class="btn btn-danger delete-form-row">
        </div>
    </div>
    <hr />
</div>
