<tr>
    <td>{{ $item->invoice?->customer?->name }}</td>
    <td>{{ Auth::user()->invoiceNumberFormat($item->invoice->invoice_id) }}</td>
    <td>{{ \Auth::user()->dateFormat($item->invoice->due_date) }}</td>
    <td>{{ $item->paymentMethod->name }}</td>
    <td>{{ $item->giro_date ? \Auth::user()->dateFormat($item->giro_date) : '' }}</td>
    <td>{{ \Auth::user()->dateFormat($item->invoice->issue_date) }}</td>
    <td>{{ \Auth::user()->priceFormat($item->amount) }}</td>
    <td>MASUK</td>
</tr>
