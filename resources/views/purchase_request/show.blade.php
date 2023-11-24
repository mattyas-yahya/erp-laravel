<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>{{ __('PR Number') }}</th>
                                <th>{{ __('Requester') }}</th>
                                <th>{{ __('SKU') }}</th>
                                <th>{{ __('SPEC') }}</th>
                                <th>{{ __('Qty') }}</th>
                                <th>{{ __('Received Quantity') }}</th>
                                <th>{{ __('Unit') }}</th>
                                <th>{{ __('Note') }}</th>
                                <th>{{ __('Dimensions') }}</th>
                                <th>{{ __('Manufacture') }}</th>
                                <th>{{ __('Weight') }}</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($datarequisition as $item)
                                <tr>
                                    <td>{{ $item->id }} - {{ $item->pr_number }}</td>
                                    <td>{{ $item->purchase_request_head()->employee()->name }}</td>
                                    <td>{{ $item->sku_number }}</td>
                                    <td>{{ $item->product_name }}</td>
                                    <td>{{ $item->qty }}</td>
                                    <td>{{ $goodsReceiptDetails?->where('product_name', $item->product_name)?->first()?->qty ?? 0 }}</td>
                                    <td>{{ $item->unit()->name }}</td>
                                    <td>{{ $item->note }}</td>
                                    <td>{{ $item->dimensions }}</td>
                                    <td>{{ $item->manufacture }}</td>
                                    <td>{{ $item->weight }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
