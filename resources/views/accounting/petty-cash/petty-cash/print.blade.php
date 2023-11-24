@php
$color = '#000';
$font_color = '#fff';
@endphp
<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Lato&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet"
        id="bootstrap-css">
    <script src="https://netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <style>
        .invoice-title h1 {
            display: inline-block;
            color: blue;
            font-weight: 700;
        }

        .invoice-title h3 {
            display: inline-block;
        }

        .invoice-title h5 {
            font-weight: 700;
            margin-left: 80px;
        }

        .table>tbody>tr>.no-line {
            border-top: none;
        }

        .table>thead>tr {
            border-bottom: none;
        }

        .table>tbody>tr>.thick-line {
            border-top: 2px solid;
        }

        #h1-custom {
            color: blue;
            font-weight: 700;
            font-size: 30px;
            padding-top: 30px;
        }
    </style>
    <style>
        @page {
            margin: 0
        }

        body {
            margin: 0
        }

        .sheet {
            margin: 0;
            overflow: hidden;
            position: relative;
            box-sizing: border-box;
            page-break-after: always;
        }

        /** Paper sizes **/
        body.custom.landscape .sheet {
            width: 130mm;
            height: 200mm
        }

        body.A3 .sheet {
            width: 297mm;
            height: 419mm
        }

        body.A3.landscape .sheet {
            width: 420mm;
            height: 296mm
        }

        body.A4 .sheet {
            width: 210mm;
            height: 296mm
        }

        body.A4.landscape .sheet {
            width: 297mm;
            height: 209mm
        }

        body.A5 .sheet {
            width: 148mm;
            height: 209mm
        }

        body.A5.landscape .sheet {
            width: 210mm;
            height: 147mm
        }

        /** Padding area **/
        .sheet.padding-10mm {
            padding: 10mm
        }

        .sheet.padding-15mm {
            padding: 15mm
        }

        .sheet.padding-20mm {
            padding: 20mm
        }

        .sheet.padding-25mm {
            padding: 25mm
        }

        /** For screen preview **/
        @media screen {
            body {
                background: #e0e0e0
            }

            .sheet {
                background: white;
                box-shadow: 0 .5mm 2mm rgba(0, 0, 0, .3);
                margin: 5mm;
            }
        }

        /** Fix for Chrome issue #273306 **/
        @media print {
            body.A3.landscape {
                width: 420mm
            }

            body.A3,
            body.A4.landscape {
                width: 297mm
            }

            body.A4,
            body.A5.landscape {
                width: 210mm
            }

            body.A5 {
                width: 148mm
            }
        }
    </style>
    <style type="text/css" media="print">
        @page { size: landscape; }
    </style>
</head>

<body class="custom">
    <section class="sheet">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="invoice-title">
                        <table>
                            <tr width="100%">
                                <th class="text-right"><img src="{{ asset('assets/images/2-logo-light.png') }}"
                                        style="max-width: 100px" />
                                </th>
                                <th class="text-center">
                                    <div id="h1-custom">PT. SAMPOERNA JAYA BAJA</div>
                                    <div>Coil Service Center Hot & Cold Rolled Steel</div>
                                    <div>Jl. Raya Narogong TPA Pangkalan V, No. 09</div>
                                    <div>Bantargebang - Bekasi 17310</div>
                                    <div>Telp. (021) 82604608-09, 29566841</div>
                                    <div>Fax. (021) 8250886</div>
                                </th>
                                <th style="padding-top: 80px;">
                                    <input type="checkbox" class="custom-control-input" @if ($pettyCash->type === App\Domains\Accounting\PettyCash\PettyCashTypeValue::TYPE_CASH_PAYMENT) checked @endif><h5>Cash Payment</h5>
                                    <input type="checkbox" class="custom-control-input" @if ($pettyCash->type === App\Domains\Accounting\PettyCash\PettyCashTypeValue::TYPE_CASH_RECEIVED) checked @endif><h5>Cash Received</h5>
                                </th>
                            </tr>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                        </div>
                        <div class="col-xs-6 text-right">
                            <div>
                                <strong>No:</strong> {{ $pettyCash->petty_cash_number }}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <address>
                                <strong>Diterima:</strong><br>
                                {{ $pettyCash->received_by }}<br>
                                <strong>Sejumlah Uang:</strong><br>
                                Rp. {{ number_format($pettyCash->getTotal(), 2, ',', '.') }} &nbsp;-&nbsp;
                            </address>
                        </div>
                        <div class="col-xs-6 text-right">
                            <address>
                                <strong>Tanggal Order:</strong><br>
                                {{ \Auth::user()->dateFormat($pettyCash->date) }}<br><br>
                            </address>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td><strong>No</strong></td>
                                <td class="text-center"><strong>Keterangan</strong></td>
                                <td class="text-right"><strong>Total</strong></td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pettyCash->details as $key => $detail)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td class="text-center">{{ $detail->information }}</td>
                                <td class="text-right">Rp. {{ number_format($detail->nominal, 2, ',', '.') }}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td class="thick-line"></td>
                                <td class="thick-line text-center"><strong>Total</strong></td>
                                <td class="thick-line text-right">Rp. {{ number_format($pettyCash->getTotal(), 2,
                                    ',',
                                    '.') }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table style="width:100%">
                        <thead>
                            <tr>
                                <th style="width:40%">Pimpinan,</th>
                                <th style="width:40%">Kasir,</th>
                                <th style="width:40%">Yg. Menerima Pembayaran</th>
                            </tr>
                        </thead>
                    </table>
                    <br><br><br><br>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
