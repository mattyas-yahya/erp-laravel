{{ Form::open(['route' => ['production.schedule.production-remaining.update', ['id' => $schedule->id]], 'method' => 'PUT']) }}
<div class="modal-body">
    <div class="row">
        <input type="hidden" name="production_schedule_id" value="{{ $schedule->id }}">
        <div class="form-group col-md-12">
            {{ Form::label('job_order_number', 'Job Order', ['class' => 'form-label']) }}
            {{ Form::text('job_order_number', $schedule->job_order_number, ['class' => 'form-control', 'readonly']) }}
        </div>

        <div class="form-group col-md-12">
            {!! Form::label('coil_number', 'No. Coil', ['class' => 'form-label']) !!}
            {!! Form::text('coil_number', $schedule?->salesOrderLine?->gr_from_so?->no_coil, ['class' => 'form-control', 'readonly']) !!}
        </div>

        <div class="form-group col-md-12">
            {!! Form::label('spec', __('Spec'), ['class' => 'form-label']) !!}
            {!! Form::text('spec', $schedule?->salesOrderLine?->gr_from_so?->product_name, ['class' => 'form-control', 'readonly']) !!}
        </div>

        <div class="form-group col-md-12">
            {!! Form::label('production_total', 'Sisa Produksi (kg mill)', ['class' => 'form-label']) !!}
            {!! Form::text('production_total', $schedule->production_remaining, ['class' => 'form-control', 'readonly']) !!}
            {!! Form::hidden('production_total', $schedule->production_remaining) !!}
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-3 col-md-3">
            {{ Form::label('dimension_t', 'T', ['class' => 'form-label']) }} <span class="text-danger">*</span>
            {{ Form::text('dimension_t', $productionRemainingDetail->dimension_t, ['class' => 'form-control', 'readonly']) }}
        </div>

        <div class="form-group col-lg-3 col-md-3">
            {{ Form::label('dimension_l', 'L', ['class' => 'form-label']) }} <span class="text-danger">*</span>
            {{ Form::text('dimension_l', $productionRemainingDetail->dimension_l, ['class' => 'form-control', 'readonly']) }}
        </div>

        <div class="form-group col-lg-3 col-md-3">
            {{ Form::label('dimension_p', 'P', ['class' => 'form-label']) }} <span class="text-danger">*</span>
            {{ Form::text('dimension_p', $productionRemainingDetail->dimension_p, ['class' => 'form-control']) }}
        </div>

        <div class="form-group col-lg-3 col-md-3">
            {{ Form::label('pieces', 'Total Pcs', ['class' => 'form-label']) }} <span class="text-danger">*</span>
            {{ Form::text('pieces', 1, ['class' => 'form-control', 'required']) }}
        </div>

    </div>
    <div class="row">
        <div class="form-group col-md-12">
            {!! Form::label('pack', 'Pack', ['class' => 'form-label']) !!}
            {!! Form::text('pack', App\Domains\Production\ProductionScheduleDetailPackValue::PACK_AVAL, ['class' => 'form-control', 'readonly']) !!}
        </div>

        <div class="form-group col-md-12">
            {!! Form::label('description', 'Keterangan', ['class' => 'form-label']) !!}
            {!! Form::text('description', '', ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{ __('Cancel') }}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Update') }}" class="btn btn-primary">
</div>
{{ Form::close() }}
