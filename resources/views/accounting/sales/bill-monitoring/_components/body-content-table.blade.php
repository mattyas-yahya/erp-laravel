<tr>
    <td>umur piutang</td>
    <td>@isset ($item->giro_date) {{ \Auth::user()->dateFormat($item->giro_date) }} @endisset</td>
    <td>{{ $item->marketing_name }}</td>
    <td>{{ $item->customer_name }}</td>
    <td>{{ \Auth::user()->invoiceNumberFormat($item->invoice_number) }}</td>
    <td>Tgl_SJ</td>
    <td>{{ $item->payment_term_days }}</td>
    <td>J/T SJ</td>
    <td>{{ $item->giro_number }}</td>
    <td>{{ \Auth::user()->priceFormat($item->invoice_amount) }}</td>
</tr>
