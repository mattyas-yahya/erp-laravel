{{ Form::model($paymentType, ['route' => ['accounting.config.payment-type.update', $paymentType->id], 'method' => 'PUT']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-12">
            {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}
            {{ Form::text('name', null, ['class' => 'form-control font-style', 'required' => 'required']) }}
            @error('name')
                <small class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </small>
            @enderror
        </div>
        <div class="form-group col-md-12">
            {{ Form::label('chart_of_account_id', __('Chart Of Account'), ['class' => 'form-label']) }}
            <select class="form-control select2" name="chart_of_account_id" id="chart_of_account_id" required>
                @foreach ($chartOfAccounts as $key => $chartOfAccount)
                    <option value="{{ $key }}" @if ($paymentType->chart_of_account_id === $key) selected @endif>{{ $chartOfAccount }}</option>
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
