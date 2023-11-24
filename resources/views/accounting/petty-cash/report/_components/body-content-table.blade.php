<tr>
    <td rowspan="{{ $item->count() }}" class="align-top">{{ \Auth::user()->dateFormat($item->first()->petty_cash_date) }}</td>
    <td rowspan="{{ $item->count() }}" class="align-top">{{ $item->first()->petty_cash_number }}</td>
    <td>{{ $item->first()->information }}</td>
    <td>@if ("CASH_PAYMENT" === $item->first()->petty_cash_type) {{ \Auth::user()->priceFormat($item->first()->nominal) }} @endif</td>
    <td>@if ("CASH_RECEIVED" === $item->first()->petty_cash_type) {{ \Auth::user()->priceFormat($item->first()->nominal) }} @endif</td>
    <td>@if ("CASH_PAYMENT" === $item->first()->petty_cash_type) {{ \Auth::user()->priceFormat($item->sum('nominal')) }} @endif</td>
    <td></td>
</tr>

@foreach ($item as $detail)
    @if ($loop->iteration == 1)
        @continue
    @endif
    <tr>
        <td style="padding-left: 0.75rem;">{{ $detail->information }}</td>
        <td>{{ \Auth::user()->priceFormat($detail->nominal) }}</td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
@endforeach
