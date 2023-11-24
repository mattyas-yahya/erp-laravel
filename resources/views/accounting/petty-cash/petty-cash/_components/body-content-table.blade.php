<tr>
    <td>{{ $item->petty_cash_number }}</td>
    <td>{{ $item->received_by }}</td>
    <td>{{ \Auth::user()->priceFormat($item->getTotal()) }}</td>
    <td>{{ \Auth::user()->dateFormat($item->date) }}</td>
    <td>{{ $item->information }}</td>
    <td>{{ $item->status_text }}</td>
    {{-- @canany('manage production') --}}
    <td>
        @if ($item->status == \App\Domains\Accounting\PettyCash\PettyCashStatusValue::STATUS_DONE)
        <div class="action-btn bg-dark ms-2">
            <a href="{{ route('accounting.petty-cash.petty-cash.print', $item->id) }}"
                class="btn btn-sm btn-icon m-1" data-bs-toggle="tooltip"
                data-bs-placement="top" title="{{ __('Print') }} - {{ $item->petty_cash_number }}" target="_blanks">
                <i class="ti ti-printer text-white"></i>
            </a>
        </div>
        @endif

        @unless ($item->status == \App\Domains\Accounting\PettyCash\PettyCashStatusValue::STATUS_DONE)
        <div class="action-btn bg-primary ms-2">
            <a href="#" title="{{ __('Edit') }}"
                class="mx-3 btn btn-sm align-items-center" data-title="{{ __('Edit Petty Cash') }}"
                data-original-title="{{ __('Edit') }}"
                data-url="{{ route('accounting.petty-cash.petty-cash.edit', $item->id) }}" data-size="lg"
                data-ajax-popup="true" data-bs-toggle="tooltip">
                <i class="ti ti-pencil text-white"></i></a>
        </div>
        @endunless

        <div class="action-btn bg-success ms-2">
            <a href="{{ route('accounting.petty-cash.petty-cash.detail.index', $item->id) }}"
                title="{{ __('Petty Cash Line') }}"
                class="mx-3 btn btn-sm align-items-center"
                data-title="{{ __('Petty Cash Line') }}"
                data-original-title="{{ __('Petty Cash Line') }}"
                data-bs-toggle="tooltip">
                <i class="ti ti-plus text-white"></i></a>
        </div>

        @unless ($item->status == \App\Domains\Accounting\PettyCash\PettyCashStatusValue::STATUS_DONE)
        <div class="action-btn bg-primary ms-2">
            {!! Form::open([
                'method' => 'POST',
                'route' => ['accounting.petty-cash.petty-cash.duplicate', $item->id],
                'id' => 'duplicate-form-' . $item->id,
            ]) !!}

            <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para"
                title="{{ __('Duplicate') }}" data-bs-toggle="tooltip"
                data-original-title="{{ __('Duplicate') }}"
                data-confirm="{{ __('Are You Sure?') . '|' . __('You are going to duplicate this item. Do you want to continue?') }}"
                data-confirm-yes="document.getElementById('duplicate-form-{{ $item->id }}').submit();">
                <i class="ti ti-copy text-white"></i></a>
            {!! Form::close() !!}
        </div>
        <div class="action-btn bg-danger ms-2">
            {!! Form::open([
                'method' => 'DELETE',
                'route' => ['accounting.petty-cash.petty-cash.destroy', $item->id],
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
        @endunless
    </td>
    {{-- @endcan --}}
</tr>
