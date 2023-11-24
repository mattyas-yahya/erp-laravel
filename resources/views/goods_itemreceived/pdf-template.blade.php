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
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}"id="main-style-link">
    <style>
        table tr td, table tr th {
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
                            <th>{{ __('Arrival') }}</th>
                            <th>{{ __('PO Number') }}</th>
                            <th>{{ __('No Kontrak') }}</th>
                            <th>{{ __('ID_SJB') }}</th>
                            <th>{{ __('No. Coil') }}</th>
                            <th>{{ __('SPEC') }}</th>
                            <th>{{ __('Dimensions') }}</th>
                            <th>{{ __('Actual Thick') }}</th>
                            <th>{{ __('Goods Location') }}</th>
                            <th>{{ __('Quantity') }}</th>
                            <th>{{ __('Weigth') }}(KG)</th>
                            <th>{{ __('Description') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($gr as $item)
                            <tr>
                                <td>
                                    {{ isset($item->gr->date_goodscome) ? date('d-m-Y', strtotime($item->gr?->date_goodscome)) : '<GR not found>' }}
                                </td>
                                <td>{{ $item->po?->po_number ?? '<PO not found>' }}</td>
                                <td>{{ $item->no_kontrak }}</td>
                                <td>{{ $item->sku_number }}</td>
                                <td>{{ $item->no_coil }}</td>
                                <td>{{ $item->product_name }}</td>
                                <td>{{ $item->dimensions }}</td>
                                <td>{{ $item->actual_thick }}</td>
                                <td>{{ $item->goods_location }}</td>
                                <td>{{ $item->qty }}</td>
                                <td>{{ $item->weight }}</td>
                                <td>{{ $item->description }}</td>
                            </tr>
                        @endforeach
                    </tbody>
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
                filename: 'PRINT-RECEIVED-GOODS',
                image: {type: 'jpeg', quality: 1},
                html2canvas: {scale: 4, dpi: 72, letterRendering: true},
                jsPDF: {unit: 'in', format: 'letter', orientation: 'landscape'}
            };

            html2pdf().set(opt).from(element).save();
        });
    </script>
</body>

</html>
