<div class="form-row">
    <div class="row">
        <div class="form-group col-md-3">
            {!! Form::label('payment_type', 'Jenis Pembayaran', ['class' => 'form-label']) !!}
            <select class="form-control select2" id="choices-multiple{{ $loop->index }}" name="payment_type[]" required>
                <option value=""> </option>
                @foreach ($paymentTypes as $paymentType)
                    <option value="{{ $paymentType->name }}" @if ($item->payment_type == $paymentType->name) selected @endif>{{ $paymentType->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-3">
            {!! Form::label('license_plate', 'Nopol', ['class' => 'form-label']) !!}
            {!! Form::text('license_plate[]', $item->license_plate ?? '', ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-md-2">
            {!! Form::label('information', 'Keterangan', ['class' => 'form-label']) !!}
            {!! Form::text('information[]', $item->information ?? '', ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-md-2">
            {!! Form::label('nominal', 'Nominal', ['class' => 'form-label']) !!}
            {!! Form::number('nominal[]', $item->nominal ?? '', ['class' => 'form-control', 'required']) !!}
        </div>
        <div class="form-group row align-items-center col-md-2">
            {!! Form::label('', '', ['class' => 'form-label']) !!}
            <input type="button" value="{{ __('Delete') }}"
                class="btn btn-danger delete-form-row">
        </div>
    </div>
    <hr />
</div>
