<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>{{ __('PO Number') }}</th>
                                <th>{{ __('No. Kontrak') }}</th>
                                <th>{{ __('SPEC') }}</th>
                                <th>{{ __('Dimensions') }}</th>
                                <th>{{ __('Unit') }}</th>
                                <th>{{ __('Weight') }}(KG)</th>
                                <th>{{ __('Quantity') }}</th>
                                <th>{{ __('Received Quantity') }}</th>
                                <th>{{ __('Tax PPN') }}</th>
                                <th>{{ __('Tax PPh') }}</th>
                                <th>{{ __('Discount') }}</th>
                                <th>{{ __('Price') }}</th>
                                <th>{{ __('Sub Total') }} <br>
                                    <small
                                        class="text-danger font-weight-bold">{{ __('before tax & discount') }}</small>
                                </th>
                                <th>{{ __('PPN') }}</th>
                                <th>{{ __('PPh') }}</th>
                                <th>{{ __('Price Include') }}</th>
                                <th>{{ __('Description') }}</th>
                                <th>{{ __('Approval') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($po_det as $item)
                                <tr>
                                    <td>{{ $item->po_number }}</td>
                                    <td>{{ $item->no_kontrak }}</td>
                                    <td>{{ $item->product_name }}</td>
                                    <td>{{ $item->dimensions }}</td>
                                    <td>{{ $item->unit()->name }}</td>
                                    <td>{{ $item->weight }}</td>
                                    <td>{{ $item->qty }}</td>
                                    <td>{{ $item?->goodsReceiptDetail?->status === 'Completed' ? $item?->goodsReceiptDetail?->qty : 0 }}</td>
                                    <td>
                                        @if ($item->tax_ppn)
                                            <span
                                                class="badge bg-primary mt-1 mr-2">{{ $taxes->where('id', 1)->first()->name . ' (' . $taxes->where('id', 1)->first()->rate . '%)' }}</span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->tax_pph)
                                            <span
                                                class="badge bg-primary mt-1 mr-2">{{ $taxes->where('id', 2)->first()->name . ' (' . $taxes->where('id', 2)->first()->rate . '%)' }}</span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $item->discount }}</td>
                                    <td>Rp {{ number_format($item->price, 2, ',', '.') }}</td>
                                    <td>
                                        @if ($item->unit()->name === 'Kg')
                                            Rp {{ number_format($item->price * $item->weight, 2, ',', '.') }}
                                        @elseif ($item->unit()->name === 'Pcs')
                                            Rp {{ number_format($item->price * $item->qty, 2, ',', '.') }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->tax_ppn)
                                            @if ($item->unit()->name === 'Kg')
                                                Rp
                                                {{ number_format(round((($item->price * $taxes->where('id', 1)->first()->rate) / 100) * $item->weight, 2, PHP_ROUND_HALF_DOWN), 2, ',', '.') }}
                                            @elseif ($item->unit()->name === 'Pcs')
                                                Rp
                                                {{ number_format(round((($item->price * $taxes->where('id', 1)->first()->rate) / 100) * $item->qty, 2, PHP_ROUND_HALF_DOWN), 2, ',', '.') }}
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->tax_pph)
                                            @if ($item->unit()->name === 'Kg')
                                                Rp
                                                {{ number_format(round((($item->price * $taxes->where('id', 2)->first()->rate) / 100) * $item->weight, 2, PHP_ROUND_HALF_DOWN), 2, ',', '.') }}
                                            @elseif ($item->unit()->name === 'Pcs')
                                                Rp
                                                {{ number_format(round((($item->price * $taxes->where('id', 2)->first()->rate) / 100) * $item->qty, 2, PHP_ROUND_HALF_DOWN), 2, ',', '.') }}
                                            @endif
                                        @endif
                                    </td>
                                    <td>Rp
                                        {{ number_format(round($item->price + ($item->tax_ppn ? ($item->price * 11) / 100 : 0) + ($item->tax_pph ? ($item->price * 0.3) / 100 : 0), 2, PHP_ROUND_HALF_DOWN), 2, ',', '.') }}
                                    </td>
                                    <td>{{ $item->description }}</td>
                                    <td>{{ $item->approval }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
