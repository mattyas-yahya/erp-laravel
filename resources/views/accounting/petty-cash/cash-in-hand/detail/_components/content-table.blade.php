<div class="tab-pane fade show active" id="tab-machine-all" role="tabpanel" aria-labelledby="pills-user-tab-all">
    <div class="table-responsive">
        <table class="table datatable-all">
            <thead>
                @include('accounting.petty-cash.petty-cash.detail._components.header-table')
            </thead>

            <tbody>
                @forelse($cashPaymentDetails as $item)
                    <tr>
                        <td>{{ $item->payment_type }}</td>
                        <td>{{ $item->license_plate }}</td>
                        <td>{{ $item->information }}</td>
                        <td>{{ \Auth::user()->priceFormat($item->nominal) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="13" class="text-center text-dark">
                            <p>{{ __('No Data Found') }}</p>
                        </td>
                        <td colspan="2">
                        </td>
                    </tr>
                @endforelse

            </tbody>
            <tfoot>
                @if($cashPaymentDetails->count())
                    <tr>
                        <th colspan="3">TOTAL</th>
                        <th>{{ \Auth::user()->priceFormat($cashPayment->getTotal()) }}</th>
                    </tr>
                @endif
            </tfoot>
        </table>
    </div>
</div>
