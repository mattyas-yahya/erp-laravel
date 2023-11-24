<tr>
    <td>{{ $item->bill?->vender?->name }}</td>
    <td>{{ Auth::user()->billNumberFormat($item->bill->bill_id) }}</td>
    <td>{{ \Auth::user()->dateFormat($item->bill->due_date) }}</td>
    <td>{{ $item?->paymentMethod?->name }}</td>
    <td>{{ $item->giro_date ? \Auth::user()->dateFormat($item->giro_date) : '' }}</td>
    <td>{{ \Auth::user()->dateFormat($item->bill->bill_date) }}</td>
    <td>{{ \Auth::user()->priceFormat($item->amount) }}</td>
    <td>KELUAR</td>
</tr>
