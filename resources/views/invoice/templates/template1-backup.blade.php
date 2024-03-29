@php
    $settings_data = \App\Models\Utility::settingsById($invoice->created_by);

@endphp
<!DOCTYPE html>
<html lang="en" dir="{{ $settings_data['SITE_RTL'] == 'on' ? 'rtl' : '' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Lato&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style type="text/css">
        body {
            font-size: 12px;
        }

        .resize-observer[data-v-b329ee4c] {
            position: absolute;
            top: 0;
            left: 0;
            z-index: -1;
            width: 100%;
            height: 100%;
            border: none;
            background-color: transparent;
            pointer-events: none;
            display: block;
            overflow: hidden;
            opacity: 0
        }

        .resize-observer[data-v-b329ee4c] object {
            display: block;
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            overflow: hidden;
            pointer-events: none;
            z-index: -1
        }
    </style>
    <style type="text/css">
        p[data-v-f2a183a6] {
            line-height: 1.2em;
            margin: 0 0 2px 0;
        }

        pre[data-v-f2a183a6] {
            margin: 0;
        }

        .d-table[data-v-f2a183a6] {
            margin-top: 20px;
        }

        .d-table-footer[data-v-f2a183a6] {
            display: -webkit-box;
            display: flex;
        }

        .d-table-controls[data-v-f2a183a6] {
            -webkit-box-flex: 2;
            flex: 2;
        }

        .d-table-summary[data-v-f2a183a6] {
            -webkit-box-flex: 1;
            flex: 1;
        }

        .d-table-summary-item[data-v-f2a183a6] {
            width: 100%;
            display: -webkit-box;
            display: flex;
        }

        .d-table-label[data-v-f2a183a6] {
            -webkit-box-flex: 1;
            flex: 1;
            display: -webkit-box;
            display: flex;
            -webkit-box-pack: end;
            justify-content: flex-end;
            padding-top: 9px;
            padding-bottom: 9px;
        }

        .d-table-label .form-input[data-v-f2a183a6] {
            margin-left: 10px;
            width: 80px;
            height: 24px;
        }

        .d-table-label .form-input-mask-text[data-v-f2a183a6] {
            top: 3px;
        }

        .d-table-value[data-v-f2a183a6] {
            -webkit-box-flex: 1;
            flex: 1;
            text-align: right;
            padding-top: 9px;
            padding-bottom: 9px;
            padding-right: 10px;
        }

        .d-table-spacer[data-v-f2a183a6] {
            margin-top: 5px;
        }

        .d-table-tr[data-v-f2a183a6] {
            display: -webkit-box;
            display: flex;
            flex-wrap: wrap;
        }

        .d-table-td[data-v-f2a183a6] {
            padding: 10px 10px 10px 10px;
        }

        .d-table-th[data-v-f2a183a6] {
            padding: 10px 10px 10px 10px;
            font-weight: bold;
        }

        .d-body[data-v-f2a183a6] {
            padding: 50px;
        }

        .d[data-v-f2a183a6] {
            font-size: 0.9em !important;
            color: black;
            background: white;
            min-height: 1000px;
        }

        .d-right[data-v-f2a183a6] {
            text-align: right;
        }

        .d-title[data-v-f2a183a6] {
            font-size: 50px;
            line-height: 50px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .d-header-50[data-v-f2a183a6] {
            -webkit-box-flex: 1;
            flex: 1;
        }

        .d-header-inner[data-v-f2a183a6] {
            display: -webkit-box;
            display: flex;
            padding: 50px;
        }

        .d-header-brand[data-v-f2a183a6] {
            width: 200px;
        }

        .d-logo[data-v-f2a183a6] {
            max-width: 100%;
        }
    </style>
    <style type="text/css">
        p[data-v-37eeda86] {
            line-height: 1.2em;
            margin: 0 0 2px 0;
        }

        pre[data-v-37eeda86] {
            margin: 0;
        }

        img[data-v-37eeda86] {
            max-width: 100%;
        }

        .d-table-value[data-v-37eeda86] {
            padding-right: 0;
        }

        .d-table-controls[data-v-37eeda86] {
            -webkit-box-flex: 5;
            flex: 5;
        }

        .d-table-summary[data-v-37eeda86] {
            -webkit-box-flex: 4;
            flex: 4;
        }
    </style>
    <style type="text/css">
        p[data-v-e95a8a8c] {
            line-height: 1.2em;
            margin: 0 0 2px 0;
        }

        pre[data-v-e95a8a8c] {
            margin: 0;
        }

        img[data-v-e95a8a8c] {
            max-width: 100%;
        }

        .d[data-v-e95a8a8c] {
            font-family: monospace;
        }

        .fancy-title[data-v-e95a8a8c] {
            margin-top: 0;
            padding-top: 0;
        }

        .d-table-value[data-v-e95a8a8c] {
            padding-right: 0;
        }

        .d-table-controls[data-v-e95a8a8c] {
            -webkit-box-flex: 5;
            flex: 5;
        }

        .d-table-summary[data-v-e95a8a8c] {
            -webkit-box-flex: 4;
            flex: 4;
        }
    </style>
    <style type="text/css">
        p[data-v-363339a0] {
            line-height: 1.2em;
            margin: 0 0 2px 0;
        }

        pre[data-v-363339a0] {
            margin: 0;
        }

        img[data-v-363339a0] {
            max-width: 100%;
        }

        .fancy-title[data-v-363339a0] {
            margin-top: 0;
            font-size: 30px;
            line-height: 1.2em;
            padding-top: 0;
        }

        .f-b[data-v-363339a0] {
            font-size: 17px;
            line-height: 1.2em;
        }

        .thank[data-v-363339a0] {
            font-size: 45px;
            line-height: 1.2em;
            text-align: right;
            font-style: italic;
            padding-right: 25px;
        }

        .f-remarks[data-v-363339a0] {
            padding-left: 25px;
        }

        .d-table-value[data-v-363339a0] {
            padding-right: 0;
        }

        .d-table-controls[data-v-363339a0] {
            -webkit-box-flex: 5;
            flex: 5;
        }

        .d-table-summary[data-v-363339a0] {
            -webkit-box-flex: 4;
            flex: 4;
        }
    </style>
    <style type="text/css">
        p[data-v-e23d9750] {
            line-height: 1.2em;
            margin: 0 0 2px 0;
        }

        pre[data-v-e23d9750] {
            margin: 0;
        }

        img[data-v-e23d9750] {
            max-width: 100%;
        }

        .fancy-title[data-v-e23d9750] {
            margin-top: 0;
            font-size: 40px;
            line-height: 1.2em;
            font-weight: bold;
            padding: 25px;
            margin-right: 25px;
        }

        .f-b[data-v-e23d9750] {
            font-size: 17px;
            line-height: 1.2em;
        }

        .thank[data-v-e23d9750] {
            font-size: 45px;
            line-height: 1.2em;
            text-align: right;
            font-style: italic;
            padding-right: 25px;
        }

        .f-remarks[data-v-e23d9750] {
            padding: 25px;
        }

        .d-table-value[data-v-e23d9750] {
            padding-right: 0;
        }

        .d-table-controls[data-v-e23d9750] {
            -webkit-box-flex: 5;
            flex: 5;
        }

        .d-table-summary[data-v-e23d9750] {
            -webkit-box-flex: 4;
            flex: 4;
        }
    </style>
    <style type="text/css">
        p[data-v-4b3dcb8a] {
            line-height: 1.2em;
            margin: 0 0 2px 0;
        }

        pre[data-v-4b3dcb8a] {
            margin: 0;
        }

        img[data-v-4b3dcb8a] {
            max-width: 100%;
        }

        .fancy-title[data-v-4b3dcb8a] {
            margin-top: 0;
            padding-top: 0;
        }

        .sub-title[data-v-4b3dcb8a] {
            margin: 5px 0 3px 0;
            display: block;
        }

        .d-table-value[data-v-4b3dcb8a] {
            padding-right: 0;
        }

        .d-table-controls[data-v-4b3dcb8a] {
            -webkit-box-flex: 5;
            flex: 5;
        }

        .d-table-summary[data-v-4b3dcb8a] {
            -webkit-box-flex: 4;
            flex: 4;
        }
    </style>
    <style type="text/css">
        p[data-v-1ad6e3b9] {
            line-height: 1.2em;
            margin: 0 0 2px 0;
        }

        pre[data-v-1ad6e3b9] {
            margin: 0;
        }

        img[data-v-1ad6e3b9] {
            max-width: 100%;
        }

        .fancy-title[data-v-1ad6e3b9] {
            margin-top: 0;
            padding-top: 0;
        }

        .sub-title[data-v-1ad6e3b9] {
            margin: 5px 0 3px 0;
            display: block;
        }

        .d-no-pad[data-v-1ad6e3b9] {
            padding: 0px;
        }

        .grey-box[data-v-1ad6e3b9] {
            padding: 50px;
            background: #f8f8f8;
        }

        .d-inner-2[data-v-1ad6e3b9] {
            padding: 50px;
        }
    </style>
    <style type="text/css">
        p[data-v-136bf9b5] {
            line-height: 1.2em;
            margin: 0 0 2px 0;
        }

        pre[data-v-136bf9b5] {
            margin: 0;
        }

        img[data-v-136bf9b5] {
            max-width: 100%;
        }

        .fancy-title[data-v-136bf9b5] {
            margin-top: 0;
            padding-top: 0;
        }

        .d-table-value[data-v-136bf9b5] {
            padding-right: 0px;
        }
    </style>
    <style type="text/css">
        p[data-v-7d9d14b5] {
            line-height: 1.2em;
            margin: 0 0 2px 0;
        }

        pre[data-v-7d9d14b5] {
            margin: 0;
        }

        img[data-v-7d9d14b5] {
            max-width: 100%;
        }

        .fancy-title[data-v-7d9d14b5] {
            margin-top: 0;
            padding-top: 0;
        }

        .sub-title[data-v-7d9d14b5] {
            margin: 0 0 5px 0;
        }

        .padd[data-v-7d9d14b5] {
            margin-left: 5px;
            padding-left: 5px;
            border-left: 1px solid #f8f8f8;
            margin-right: 5px;
            padding-right: 5px;
            border-right: 1px solid #f8f8f8;
        }

        .d-inner[data-v-7d9d14b5] {
            padding-right: 0px;
        }

        .d-table-value[data-v-7d9d14b5] {
            padding-right: 5px;
        }

        .d-table-controls[data-v-7d9d14b5] {
            -webkit-box-flex: 5;
            flex: 5;
        }

        .d-table-summary[data-v-7d9d14b5] {
            -webkit-box-flex: 4;
            flex: 4;
        }
    </style>
    <style type="text/css">
        p[data-v-b8f60a0c] {
            line-height: 1.2em;
            margin: 0 0 2px 0;
        }

        pre[data-v-b8f60a0c] {
            margin: 0;
        }

        img[data-v-b8f60a0c] {
            max-width: 100%;
        }

        .fancy-title[data-v-b8f60a0c] {
            margin-top: 0;
            padding-top: 10px;
        }

        .d-table-value[data-v-b8f60a0c] {
            padding-right: 0;
        }

        .d-table-controls[data-v-b8f60a0c] {
            -webkit-box-flex: 5;
            flex: 5;
        }

        .d-table-summary[data-v-b8f60a0c] {
            -webkit-box-flex: 4;
            flex: 4;
        }

        .overflow-x-hidden {
            overflow-x: hidden !important;
        }

        .float-right {
            float: right;
        }

        .mb-5 {
            margin-bottom: 10px;
        }
    </style>
    @if ($settings_data['SITE_RTL'] == 'on')
        <link rel="stylesheet" href="{{ asset('css/bootstrap-rtl.css') }}">
    @endif
</head>

<body class="">
    <div class="container">
        <div id="app" class="content">
            <div class="editor">
                <div class="invoice-preview-inner">
                    <div class="editor-content">
                        <div class="preview-main client-preview">
                            <div data-v-f2a183a6="" class="d" id="boxes"
                                style="width:710px;margin-left: auto;margin-right: auto;">
                                <div data-v-f2a183a6="" class="d-body">
                                    <div data-v-f2a183a6="" style="margin-bottom: 16px;">
                                        <div style="display: flex; flex-direction: column;">
                                            <div>
                                                <strong data-v-f2a183a6="">PT. SAMPOERNA JAYA BAJA</strong>
                                            </div>
                                            <div>
                                                Jl. Margomulyo III No 18, Telp (031) 7495504-06 Fax (031) 7494213
                                            </div>
                                        </div>
                                    </div>
                                    <div data-v-f2a183a6="" style="margin-bottom: 16px;">
                                        <div class="row" style="text-align: center; flex-direction: column;">
                                            <strong data-v-f2a183a6="">INVOICE</strong>
                                        </div>
                                    </div>
                                    <div data-v-f2a183a6="" class="d-bill-to">
                                        <div class="row">
                                            <div class="bill_to">
                                                <p>
                                                <div style="display: flex; flex-direction: row">
                                                    <div style="width: 120px;">
                                                        No. Invoice
                                                    </div>
                                                    <div style="width: 10px;">
                                                        :
                                                    </div>
                                                    <div style="width: 120px;">
                                                        {{ Auth::user()->invoiceNumberFormat($invoice->invoice_id) }}
                                                    </div>
                                                </div>
                                                <div style="display: flex; flex-direction: row">
                                                    <div style="width: 120px;">
                                                        No. SJ
                                                    </div>
                                                    <div style="width: 10px;">
                                                        :
                                                    </div>
                                                    <div style="width: 120px;">
                                                        {{ $invoice->delivery_order_number }}
                                                    </div>
                                                </div>
                                                <div style="display: flex; flex-direction: row">
                                                    <div style="width: 120px;">
                                                        No. FP
                                                    </div>
                                                    <div style="width: 10px;">
                                                        :
                                                    </div>
                                                    <div style="width: 120px;">
                                                        {{ $invoice->faktur_penjualan_number }}
                                                    </div>
                                                </div>
                                                <div style="display: flex; flex-direction: row">
                                                    <div style="width: 120px;">
                                                        Tgl. Jatuh Tempo
                                                    </div>
                                                    <div style="width: 10px;">
                                                        :
                                                    </div>
                                                    <div style="width: 120px;">
                                                        {{ date_format(date_create($invoice->due_date), 'd-M-Y') }}
                                                    </div>
                                                </div>
                                                </p>
                                            </div>
                                            @if ($settings['shipping_display'] == 'on')
                                                <div class="ship_to">
                                                    <p>
                                                        Surabaya, {{ date('d M Y') }}
                                                    </p>
                                                    <p>
                                                        Kepada Yth, {{ $customer->name }}
                                                    </p>
                                                    @foreach ($customerShippingAddress as $shippingAddress)
                                                        <p>
                                                            {{ $shippingAddress->address }}<br>
                                                            {{ $shippingAddress->city . ', ' . $shippingAddress->state . ', ' . $shippingAddress->country }}<br>
                                                            {{ $shippingAddress->zip }}<br>
                                                        </p>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                        <div data-v-f2a183a6="" class="d-table">
                                            <div data-v-f2a183a6="" class="d-table">
                                                <div data-v-f2a183a6="" class="d-table-tr"
                                                    style="background: {{ $color }};color:{{ $font_color }}; border: 1px solid black; border-left: none; border-right: none; ">
                                                    <div class="d-table-th w-4">{{ __('Spec') }}</div>
                                                    <div class="d-table-th w-3">{{ __('Ukuran') }} (mm)</div>
                                                    <div class="d-table-th w-3">{{ __('Weight') }} (kg/lbr)</div>
                                                    <div class="d-table-th w-6" style="text-align: right;">
                                                        {{ __('Price') }} (Rp)</div>
                                                    <div class="d-table-th w-6" style="text-align: right;">
                                                        {{ __('Total Harga') }}</div>
                                                </div>

                                                <div class="d-table-body">
                                                    @if (isset($invoice->items) && count($invoice->items) > 0)
                                                        @foreach ($invoice->items as $key => $item)
                                                            <div class="d-table-tr"
                                                                style="border-bottom:1px solid {{ $color }};">
                                                                <div class="d-table-td w-4">
                                                                    <pre data-v-f2a183a6="">{{ $item?->gr_from_so?->product_name }}</pre>
                                                                </div>
                                                                <div class="d-table-td w-3">
                                                                    <pre data-v-f2a183a6="">{{ $item?->gr_from_so?->dimensions }}</pre>
                                                                </div>
                                                                <div class="d-table-td w-3">
                                                                    <pre data-v-f2a183a6="">{{ $item?->gr_from_so?->weight }}</pre>
                                                                </div>
                                                                <div class="d-table-td w-6" style="text-align: right;">
                                                                    <pre data-v-f2a183a6="">{{ Utility::priceFormat($settings, $item->sale_price) }}</pre>
                                                                </div>
                                                                <div class="d-table-td w-6" style="text-align: right;">
                                                                    @if ($item?->gr_from_so?->unit()->name === 'Kg')
                                                                        Rp{{ number_format($item->sale_price * $item?->gr_from_so?->weight, 2, ',', '.') }}
                                                                    @elseif ($item?->gr_from_so?->unit()->name === 'Pcs')
                                                                        Rp{{ number_format($item->sale_price * $item->qty, 2, ',', '.') }}
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <div class="d-table-tr"
                                                            style="border-bottom:1px solid {{ $color }};">
                                                            <div class="d-table-td w-2"><span>-</span></div>
                                                            <div class="d-table-td w-7">
                                                                <pre data-v-f2a183a6="">-</pre>
                                                            </div>
                                                            <div class="d-table-td w-5">
                                                                <pre data-v-f2a183a6="">-</pre>
                                                            </div>
                                                            <div class="d-table-td w-5">
                                                                <pre data-v-f2a183a6="">-</pre>
                                                            </div>
                                                            <div class="d-table-td w-4 text-right"><span>-</span></div>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="d-table-tr"
                                                    style="border-bottom:1px solid {{ $color }};">
                                                    <div class="d-table-td w-6 text-left">
                                                        Terbilang :
                                                        @php
                                                            function terbilang($x)
                                                            {
                                                                $angka = ['', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas'];

                                                                if ($x < 12) {
                                                                    return ' ' . $angka[$x];
                                                                } elseif ($x < 20) {
                                                                    return terbilang($x - 10) . ' belas';
                                                                } elseif ($x < 100) {
                                                                    return terbilang($x / 10) . ' puluh' . terbilang($x % 10);
                                                                } elseif ($x < 200) {
                                                                    return 'seratus' . terbilang($x - 100);
                                                                } elseif ($x < 1000) {
                                                                    return terbilang($x / 100) . ' ratus' . terbilang($x % 100);
                                                                } elseif ($x < 2000) {
                                                                    return 'seribu' . terbilang($x - 1000);
                                                                } elseif ($x < 1000000) {
                                                                    return terbilang($x / 1000) . ' ribu' . terbilang($x % 1000);
                                                                } elseif ($x < 1000000000) {
                                                                    return terbilang($x / 1000000) . ' juta' . terbilang($x % 1000000);
                                                                } elseif ($x < 1000000000000) {
                                                                    return terbilang($x / 1000000000) . ' milyar' . terbilang($x % 1000000000);
                                                                }
                                                            }
                                                        @endphp
                                                        {{ terbilang($invoice->getTotal()) }} rupiah
                                                    </div>
                                                    <div class="d-table-td w-6 text-right">
                                                    </div>
                                                    <div class="d-table-td w-10 text-right">
                                                        <div class="d-table-tr">
                                                            <div class="d-table-td w-12 text-right">
                                                                Sub Total
                                                            </div>
                                                            <div class="d-table-td w-12 text-right">
                                                                <span>{{ Utility::priceFormat($settings, $invoice->getSubTotal()) }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="d-table-tr">
                                                            <div class="d-table-td w-12 text-right">
                                                                PPN 11%
                                                            </div>
                                                            <div class="d-table-td w-12 text-right">
                                                                <span>{{ Utility::priceFormat($settings, $invoice->getTotalPpnTax()) }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="d-table-tr">
                                                            <div class="d-table-td w-12 text-right">
                                                                Total
                                                            </div>
                                                            <div class="d-table-td w-12 text-right">
                                                                <span>{{ Utility::priceFormat($settings, $invoice->getTotal()) }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-table-td w-30 text-left">
                                                    <div class="d-table-tr">
                                                        <div class="d-table-td w-12 text-left">
                                                            <p>Hormat kami,</p>
                                                            <br />
                                                            <br />
                                                            <br />
                                                            <br />
                                                            <p>MARMI</p>
                                                        </div>
                                                        <div class="d-table-td w-12 text-left">
                                                            @if ($invoice->note)
                                                                <p>Note :</p>
                                                                <p>{!! nl2br(e($invoice->note)) !!}</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    @if (!isset($preview))
        {{-- @include('invoice.script'); --}}
    @endif
</body>

</html>