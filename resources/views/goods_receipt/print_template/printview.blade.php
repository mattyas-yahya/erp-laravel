@php
// $settings_data = \App\Models\Utility::settingsById($invoice->created_by);

@endphp
<!DOCTYPE html>
{{-- <html lang="en" dir="{{ $settings_data['SITE_RTL'] == 'on' ? 'rtl' : '' }}"> --}}

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
            margin-top: 0px;
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
            padding: 20px;
        }

        .d[data-v-f2a183a6] {
            font-size: 1.2em !important;
            color: black;
            background: white;
            min-height: 100px;
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
    {{-- @if ($settings_data['SITE_RTL'] == 'on')
    <link rel="stylesheet" href="{{ asset('css/bootstrap-rtl.css') }}">
    @endif --}}
</head>

<body class="custom">
    <section class="sheet">
        <div class="container">
            <div id="app" class="content">
                <div class="editor">
                    <div class="invoice-preview-inner">
                        <div class="editor-content">
                            <div class="preview-main client-preview">
                                <div data-v-f2a183a6="" class="d" id="boxes"
                                    style="width:1000px;margin-left: auto;margin-right: auto;">
                                    <div data-v-f2a183a6="" class="d-body">
                                        <div data-v-f2a183a6=""
                                            style="margin-bottom: 5px;border-bottom:1px solid #000;">
                                            <div class="row">
                                                <div style="display: flex; flex-direction: column;">
                                                    <div>
                                                        <strong data-v-f2a183a6="">PT. SAMPOERNA JAYA BAJA</strong>
                                                    </div>
                                                    <div>
                                                        Jl. Margomulyo III No 18, Telp (031) 7495504-06 Fax (031)
                                                        7494213
                                                    </div>
                                                </div>
                                                <div class="ship_to" style="padding-top: 10px">
                                                    <strong data-v-f2a183a6="">Surat Jalan Gudang</strong>
                                                </div>
                                            </div>
                                        </div>
                                        <div data-v-f2a183a6="" class="d-bill-to">
                                            <div class="row">
                                                <div class="bill_to">
                                                    <div style="display: flex; flex-direction: row">
                                                        <div style="width: 120px;">
                                                            Pembeli
                                                        </div>
                                                        <div style="width: 10px;">
                                                            :
                                                        </div>
                                                        <div style="width: 120px;">
                                                            PT. Lion Star
                                                        </div>
                                                    </div>
                                                    <div style="display: flex; flex-direction: row">
                                                        <div style="width: 120px;">
                                                            Nopol
                                                        </div>
                                                        <div style="width: 10px;">
                                                            :
                                                        </div>
                                                        <div style="width: 120px;">
                                                            L 694 HH
                                                        </div>
                                                    </div>
                                                    <div style="display: flex; flex-direction: row">
                                                        <div style="width: 120px;">
                                                            Sopir
                                                        </div>
                                                        <div style="width: 10px;">
                                                            :
                                                        </div>
                                                        <div style="width: 120px;">
                                                            Joko
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- @if ($settings['shipping_display'] == 'on') --}}
                                                <div class="ship_to">
                                                    <div>
                                                        No.SJG & Tgl &nbsp;&nbsp; 23.10 G23/10/253 &nbsp;&nbsp; {{ date('d-m-Y') }}
                                                    </div>
                                                    <div>
                                                        Gudang &nbsp;&nbsp; PT.SJB
                                                    </div>
                                                    {{-- @foreach ($customerShippingAddress as $shippingAddress) --}}
                                                    <div>
                                                        <b>PO.NO</b>&nbsp;&nbsp; {{ $data_gr->po->po_number }}
                                                    </div>
                                                    {{-- @endforeach --}}
                                                </div>
                                                {{-- @endif --}}
                                            </div>
                                            <div data-v-f2a183a6="" class="d-table">
                                                <div data-v-f2a183a6="" class="d-table">
                                                    <div data-v-f2a183a6="" class="d-table-tr"
                                                        style="background: #ffffff;color:black; border: 1px solid black; border-left: none; border-right: none; ">
                                                        <div class="d-table-th w-3">Mesin</div>
                                                        <div class="d-table-th w-2">SPEC</div>
                                                        <div class="d-table-th w-3">Ukuran</div>
                                                        <div class="d-table-th w-2">ID_SBJ</div>
                                                        <div class="d-table-th w-3">No.Coil</div>
                                                        <div class="d-table-th w-2">PCS</div>
                                                        <div class="d-table-th w-2">Kg/Pack</div>
                                                        <div class="d-table-th w-3">No_ID_PRO</div>
                                                        <div class="d-table-th w-3">Keterangan</div>
                                                    </div>

                                                    <div class="d-table-body">
                                                        @foreach ($datadetail_gr as $key => $item)
                                                        <div class="d-table-tr"
                                                            style="border-bottom:1px solid #fff;">
                                                            <div class="d-table-td w-3">
                                                                Blm
                                                            </div>
                                                            <div class="d-table-td w-2">
                                                                {{ $item->sku_number }}
                                                            </div>
                                                            <div class="d-table-td w-3">
                                                                {{ $item->dimensions }}
                                                            </div>
                                                            <div class="d-table-td w-2">
                                                                {{ $item->sku_number }}
                                                            </div>
                                                            <div class="d-table-td w-3">
                                                                {{ $item->no_coil }}
                                                            </div>
                                                            <div class="d-table-td w-2">
                                                                {{ $item->qty }}
                                                            </div>
                                                            <div class="d-table-td w-2">
                                                                {{ $item->weight }}
                                                            </div>
                                                            <div class="d-table-td w-3">
                                                                Blm
                                                            </div>
                                                            <div class="d-table-td w-2">
                                                                {{ $item->description }}
                                                            </div>
                                                            
                                                        </div>
                                                        @endforeach
                                                    </div>

                                                    <div class="d-table-tr" style="border-top:1px solid #000;padding-bottom:5px">
                                                        <div class=" w-5 text-left">
                                                            Jumlah
                                                        </div>
                                                        <div class=" text-right" style="width: 34.200003%;">
                                                            <span>{{ $datadetail_gr->sum('qty') }}</span>                                                            
                                                        </div>
                                                    </div>
                                                    <div class=" w-30 text-left">
                                                        <div class="d-table-tr">
                                                            <div class="w-4 text-left">
                                                                <div>Admin Gudang,</div>
                                                                <br />
                                                                <br />
                                                                <p>..........</p>
                                                            </div>
                                                            <div class="w-4 text-left">
                                                                <div>Kepala Gudang,</div>
                                                                <br />
                                                                <br />
                                                                <p>..........</p>
                                                            </div>
                                                            <div class="w-4 text-left">
                                                                <div>OPR 1,</div>
                                                                <br />
                                                                <br />
                                                                <p>..........</p>
                                                            </div>
                                                            <div class="w-4 text-left">
                                                                <div>OPR 2,</div>
                                                                <br />
                                                                <br />
                                                                <p>..........</p>
                                                            </div>
                                                            <div class="w-4 text-left">
                                                                <div>Sopir,</div>
                                                                <br />
                                                                <br />
                                                                <p>..........</p>
                                                            </div>
                                                            <div class="w-4 text-left">
                                                                <div>Penerima,</div>
                                                                <br />
                                                                <br />
                                                                <p>..........</p>
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
    </section>
    @if (!isset($preview))
    {{-- @include('invoice.script'); --}}
    @endif
</body>

</html>