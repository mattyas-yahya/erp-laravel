@php
$SITE_RTL = Utility::getValByName('SITE_RTL');
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ $SITE_RTL == 'on' ? 'rtl' : '' }}">

<head>
    <title></title>
    <!-- Meta -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- font css -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
    <style>
        table tr td,
        table tr th {
            font-size: 0.5rem !important;
        }
    </style>
</head>

<body>
    <div class="card mt-5">
        <div class="card-body" id="boxes">
            <div class="table-border-style mb-4">
                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th>{{ __('#') }}</th>
                            <th>{{ __('Customer') }}</th>
                            <th>{{ __('Marketing') }}</th>
                            @foreach($salesOrderDetails->pluck('gr_from_so.product_name')->unique()->sort()->values()->all() as $productName)
                            <th>{{ $productName }}</th>
                            @endforeach
                            <th>{{ __('Grand Total') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($salesOrders->pluck('customer_id')->unique()->sort()->values()->all() as $customerNumber)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $salesOrders->where('customer_id', $customerNumber)->first()->cust->name }}
                            </td>
                            <td>{{ $salesOrders->where('customer_id', $customerNumber)->first()?->employees->name }}
                            </td>
                            @foreach ($salesOrderDetails->pluck('gr_from_so.product_name')->unique()->sort()->values()->all() as $productName)
                            <td>{{ $salesOrderDetails->whereIn('so_id', $salesOrders->where('customer_id',
                                $customerNumber)->pluck('id'))->where('gr_from_so.product_name',
                                $productName)->sum('gr_from_so.weight') }}
                            </td>
                            @endforeach
                            <td>{{ $salesOrderDetails->whereIn('so_id', $salesOrders->where('customer_id',
                                $customerNumber)->pluck('id'))->sum('gr_from_so.weight') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <thead>
                        <tr>
                            <td></td>
                            <td><strong>Total</strong></td>
                            <td></td>
                            @foreach($salesOrderDetails->pluck('gr_from_so.product_name')->unique()->sort()->values()->all() as $productName)
                            <td>
                                <strong>{{ $salesOrderDetails->where('gr_from_so.product_name',
                                    $productName)->reduce(function ($carry, $detail) {
                                    return $carry + (float) $detail?->gr_from_so?->weight ?? 0;
                                    }, 0.0) > 0
                                    ? number_format(
                                    round(
                                    $salesOrderDetails->where('gr_from_so.product_name', $productName)->reduce(function
                                    ($carry, $detail) {
                                    return $carry + (float) $detail?->gr_from_so?->weight ?? 0;
                                    }, 0.0),
                                    ),
                                    0,
                                    ',',
                                    '.',
                                    )
                                    : '-' }}</strong>
                            </td>
                            @endforeach
                            <td>
                                <strong>{{ $salesOrderDetails->reduce(function ($carry, $detail) {
                                    return $carry + (float) $detail?->gr_from_so?->weight ?? 0;
                                    }, 0.0) > 0
                                    ? number_format(
                                    round(
                                    $salesOrderDetails->reduce(function ($carry, $detail) {
                                    return $carry + (float) $detail?->gr_from_so?->weight ?? 0;
                                    }, 0.0),
                                    ),
                                    0,
                                    ',',
                                    '.',
                                    )
                                    : '-' }}</strong>
                            </td>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/html2pdf.bundle.min.js') }}"></script>
    <script>
        $(window).on('load', function () {
            var element = document.getElementById('boxes');
            var opt = {
                filename: 'PRINT-REPORT-MARKETING',
                image: {type: 'jpeg', quality: 1},
                html2canvas: {scale: 4, dpi: 72, letterRendering: true},
                jsPDF: {unit: 'in', format: 'letter', orientation: 'landscape'}
            };

            html2pdf().set(opt).from(element).save();
        });
    </script>
</body>

</html>