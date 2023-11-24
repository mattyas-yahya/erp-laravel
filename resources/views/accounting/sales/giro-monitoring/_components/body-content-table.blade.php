<tr>
    <td>{{ \Auth::user()->dateFormat($item->invoice_issue_date) }}</td>
    <td>{{ $item->marketing_name }}</td>
    <td>{{ $item->customer_name }}</td>
    <td>{{ \Auth::user()->invoiceNumberFormat($item->invoice_number) }}</td>
    <td>{{ $item->invoice_faktur_penjualan_number }}</td>
    <td>{{ \Auth::user()->priceFormat($item->invoice_amount) }}</td>
    <td>Tgl_SJ</td>
    <td>@php preg_match_all('/\d+(\.\d+)?/', $item->payment_term_name, $matches) @endphp {{ $matches[0][0] ?? '' }}</td>
    <td>J/T SJ</td>
    <td>STATUS</td>
    <td>{{ $item->giro_number }}</td>
    <td>@isset ($item->giro_date) {{ \Auth::user()->dateFormat($item->giro_date) }} @endisset</td>
    <td>{{ \Auth::user()->priceFormat($item->giro_amount) }}</td>
    <td>lama pembayaran</td>
    <td>No Memo giro</td>
    <td>Tgl Titip Bank</td>
    <td>Keterangan </td>
</tr>
