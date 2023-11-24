@if (!empty($customer))
    <div class="row">
        <div class="col-md-5">
            <h6>{{ __('Bill to') }}</h6>
            <div class="bill-to">
                <small>
                    <span>{{ $customer['billing_name'] }}</span><br>
                    <span>{{ $customer['billing_phone'] }}</span><br>
                    <span>{{ $customer['billing_address'] }}</span><br>
                    <span>{{ $customer['billing_city'] . ' , ' . $customer['billing_state'] . ' , ' . $customer['billing_country'] . '.' }}</span><br>
                    <span>{{ $customer['billing_zip'] }}</span>

                </small>
            </div>
        </div>
        <div class="col-md-5">
            <h6>{{ __('Ship to') }}</h6>
            <div class="bill-to">
                <small>
                    @foreach ($customerShippingAddress as $shippingAddress)
                        <p class="card-text mb-0">{{ $shippingAddress->name }}</p>
                        <p class="card-text mb-0">{{ $shippingAddress->phone }}</p>
                        <p class="card-text mb-0">{{ $shippingAddress->address }}</p>
                        <p class="card-text mb-0">
                            {{ $shippingAddress->city . ', ' . $shippingAddress->state . ', ' . $shippingAddress->country }}
                        </p>
                        <p class="card-text mb-0">{{ $shippingAddress->zip }}</p>
                        <hr>
                    @endforeach
                </small>
            </div>
        </div>
        <div class="col-md-2">
            <a href="#" id="remove" class="text-sm">{{ __(' Remove') }}</a>
        </div>
    </div>
@endif
