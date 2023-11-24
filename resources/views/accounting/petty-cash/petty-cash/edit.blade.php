{{ Form::model($pettyCash, ['route' => ['accounting.petty-cash.petty-cash.update', $pettyCash->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            {!! Form::label('petty_cash_number', 'Nomor', ['class' => 'form-label']) !!}
            {!! Form::text('petty_cash_number', null, ['class' => 'form-control', 'readonly']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('received_by', 'Diterima', ['class' => 'form-label']) !!}
            {!! Form::text('received_by', null, ['class' => 'form-control', 'required']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('date', __('Date'), ['class' => 'form-label']) !!}
            <div class="form-icon-user">
                {{ Form::date('date', null, ['class' => 'form-control', 'required' => 'required']) }}
            </div>
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('information', 'Keterangan', ['class' => 'form-label']) !!}
            {!! Form::text('information', null, ['class' => 'form-control', 'required']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('status', 'Status', ['class' => 'form-label']) !!}
            <select class="form-control select2" name="status" id="choices-multiple" required>
                @foreach (['DRAFT', 'DONE'] as $status)
                    <option value="{{ $status }}" @if ($status == $pettyCash->status) selected @endif>{{ $status }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{ __('Cancel') }}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Update') }}" class="btn btn-primary">
</div>
{{ Form::close() }}

<script></script>
