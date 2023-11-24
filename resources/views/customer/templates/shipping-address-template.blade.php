<div class="shipping-address-form">
    <div class="w-100"><hr></div>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                {{ Form::label('shipping_name[]', __('Name'), ['class' => 'form-label']) }}
                {{ Form::text('shipping_name[]', $address->name ?? null, ['class' => 'form-control']) }}

            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                {{ Form::label('shipping_phone[]', __('Phone'), ['class' => 'form-label']) }}
                {{ Form::text('shipping_phone[]', $address->phone ?? null, ['class' => 'form-control']) }}

            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('shipping_address[]', __('Address'), ['class' => 'form-label']) }}
                <label class="form-label" for="example2cols1Input"></label>
                {{ Form::textarea('shipping_address[]', $address->address ?? null, ['class' => 'form-control', 'rows' => 3]) }}

            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                {{ Form::label('shipping_city[]', __('City'), ['class' => 'form-label']) }}
                {{ Form::text('shipping_city[]', $address->city ?? null, ['class' => 'form-control']) }}

            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                {{ Form::label('shipping_state[]', __('State'), ['class' => 'form-label']) }}
                {{ Form::text('shipping_state[]', $address->state ?? null, ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                {{ Form::label('shipping_country[]', __('Country'), ['class' => 'form-label']) }}
                {{ Form::text('shipping_country[]', $address->country ?? null, ['class' => 'form-control']) }}

            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                {{ Form::label('shipping_zip[]', __('Zip Code'), ['class' => 'form-label']) }}
                {{ Form::text('shipping_zip[]', $address->zip ?? null, ['class' => 'form-control']) }}
            </div>
        </div>
    </div>
</div>
