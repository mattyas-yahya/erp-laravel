<div class="form-row">
    <div class="row">
        {!! Form::hidden('detail_id[]', $item->id) !!}

        <div class="form-group col-2">
            {!! Form::label('detail_category', 'Jenis Perawatan', ['class' => 'form-label']) !!}
            {!! Form::text('detail_category[]', $item->category, ['class' => 'form-control', 'disabled']) !!}
        </div>
        <div class="form-group col-2">
            {!! Form::label('detail_activity_type', 'Jenis Kegiatan', ['class' => 'form-label']) !!}
            {!! Form::text('detail_activity_type[]', $item->activity_type, ['class' => 'form-control', 'disabled']) !!}
        </div>
        <div class="form-group col-1">
            {!! Form::label('detail_name', 'Nama Item', ['class' => 'form-label']) !!}
            {!! Form::text('detail_name[]', $item->name, ['class' => 'form-control', 'disabled']) !!}
        </div>
        <div class="form-group col-1">
            {!! Form::label('detail_stock', 'Stok Barang', ['class' => 'form-label']) !!}
            {!! Form::text('detail_stock[]', null, ['class' => 'form-control', 'disabled']) !!}
        </div>
        <div class="form-group col-1">
            {!! Form::label('detail_planned_quantity', 'Qty Rencana', ['class' => 'form-label']) !!}
            {!! Form::text('detail_planned_quantity[]', $item->planned_quantity, ['class' => 'form-control', 'disabled']) !!}
        </div>
        <div class="form-group col-2">
            {!! Form::label('detail_planned_cost', 'Harga Rencana', ['class' => 'form-label']) !!}
            {!! Form::number('detail_planned_cost[]', $item->planned_cost, ['class' => 'form-control', 'disabled']) !!}
        </div>
        <div class="form-group col-1">
            {!! Form::label('detail_realized_quantity', 'Qty Realisasi', ['class' => 'form-label']) !!}
            {!! Form::text('detail_realized_quantity[]', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-2">
            {!! Form::label('detail_realized_cost', 'Harga Realisasi', ['class' => 'form-label']) !!}
            {!! Form::number('detail_realized_cost[]', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <hr />
</div>
