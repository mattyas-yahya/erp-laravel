<tr>
    <td>{{ $item->cash_in_hand_number }}</td>
    <td>{{ \Auth::user()->dateFormat($item->date) }}</td>
    <td>{{ \Auth::user()->priceFormat($item->initial_balance) }}</td>
    <td>{{ \Auth::user()->priceFormat($item->getCashBalanceTotal()) }}</td>
    <td>{{ \Auth::user()->priceFormat($item->kasbon_balance) }}</td>
    <td>{{ \Auth::user()->priceFormat($item->account_balance) }}</td>
    <td>{{ \Auth::user()->priceFormat($item->getBalanceTotal()) }}</td>
    <td>{{ $item->information }}</td>
    {{-- @canany('manage production') --}}
    <td>
        <div class="action-btn bg-primary ms-2">
            <a href="{{ route('accounting.petty-cash.cash-in-hand.edit', $item->id) }}" data-title="{{ __('Edit Uang Tunai') }}" data-bs-toggle="tooltip"
            title="{{ __('Edit') }}" class="mx-3 btn btn-sm align-items-center">
                <i class="ti ti-pencil text-white"></i>
            </a>
        </div>
        <div class="action-btn bg-danger ms-2">
            {!! Form::open([
                'method' => 'DELETE',
                'route' => ['accounting.petty-cash.cash-in-hand.destroy', $item->id],
                'id' => 'delete-form-' . $item->id,
            ]) !!}

            <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para"
                title="{{ __('Delete') }}" data-bs-toggle="tooltip"
                data-original-title="{{ __('Delete') }}"
                data-confirm="{{ __('Are You Sure?') . '|' . __('This action can not be undone. Do you want to continue?') }}"
                data-confirm-yes="document.getElementById('delete-form-{{ $item->id }}').submit();">
                <i class="ti ti-trash text-white"></i></a>
            {!! Form::close() !!}
        </div>
    </td>
    {{-- @endcan --}}
</tr>
