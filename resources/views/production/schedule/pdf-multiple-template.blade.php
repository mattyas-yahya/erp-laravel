@php
    $SITE_RTL = Utility::getValByName('SITE_RTL');
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ $SITE_RTL == 'on' ? 'rtl' : '' }}">

<head>
    <title>{{ Auth::user()->type === 'company' ? Auth::user()->name : '' }} JOB
        ORDER</title>
    <!-- Meta -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- font css -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}"id="main-style-link">
    <style>
        .print-header,
        .print-body,
        body .print-body .table thead th,
        .print-footer,
        .print-footer p {
            font-size: 10px;
        }

        .print-page {
            margin: 64px;
        }

        @media print {
            .print-page { page-break-after: always; }
        }
    </style>
</head>

<body>
    @foreach ($scheduleData as $data)
    @php
        $schedule = $data['schedule'];
        $scheduleDetails = $data['scheduleDetails'];
        $sumProductionTotal = $data['sumProductionTotal'];
        $sumPieces = $data['sumPieces'];
    @endphp
    <div class="mt-5 print-page">
        <div id="boxes">
            <div class="row mt-2">
                <div class="col-10">
                    <p>
                        <h6 class="d-block m-0 text-uppercase">
                            {{ Auth::user()->type === 'company' ? Auth::user()->name : '' }} Job Order</h6>
                    </p>
                    <p>
                        <h5 class="d-block m-0">SEBELUM PROSES PEMOTONGAN HARAP DIPERHATIKAN UKURAN PANJANG
                        </h5>
                    </p>
                </div>
                <div class="col-2 text-end">
                    <h3 class="invoice-number">{{ $schedule->job_order_number_numeric }}</h3>
                </div>
            </div>
            <div class="print-header row mb-4 ">
                <div class="col-6 mb-sm-0 mt-3">
                    <div class="row mb-2">
                        <div class="col-5">
                            <strong class="d-inline-block m-0">{{ __('NO PRODUKSI') }}</strong>
                        </div>
                        <div class="col-3">
                            <strong class="d-inline-block m-0">{{ $schedule->job_order_number }}</strong>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5">
                            <strong class="d-inline-block m-0">{{ __('KONSUMEN') }}</strong>
                        </div>
                        <div class="col-3">
                            <strong class="d-inline-block m-0">{{ Auth::user()->customerNumberFormat($schedule->customer_id) }}</strong>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5">
                            <strong class="d-inline-block m-0">{{ __('REF SO') }}</strong>
                        </div>
                        <div class="col-3">
                        <strong class="d-inline-block m-0">{{ $schedule?->salesOrderLine?->so_number }}</strong>
                        </div>
                    </div>
                </div>
                <div class="col-6 mb-sm-0 mt-3">
                    <div class="row mb-2">
                        <div class="col-5">
                            <strong class="d-inline-block m-0">{{ __('SPEC') }}</strong>
                        </div>
                        <div class="col-5">
                            <strong class="d-inline-block m-0">{{ $schedule->product_name }}</strong>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5">
                            <strong class="d-inline-block m-0">{{ __('ID SJB') }}</strong>
                        </div>
                        <div class="col-5">
                            <strong class="d-inline-block m-0">
                                {{ $schedule->salesOrderLine?->gr_from_so?->sku_number ?? '<undefined>' }}</strong>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5">
                            <strong class="d-inline-block m-0">{{ __('ID MILL') }}</strong>
                        </div>
                        <div class="col-5">
                            <strong class="d-inline-block m-0">
                                {{ $schedule->salesOrderLine?->no_coil ?? '<undefined>' }}</strong>
                        </div>
                    </div>
                </div>
            </div>
            <div class="print-body table-border-style mb-4 ">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Mesin</th>
                            <th>Spec</th>
                            <th>T</th>
                            <th>L</th>
                            <th>P</th>
                            <th>Pcs</th>
                            <th>Kg Mill</th>
                            <th>Pack</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($scheduleDetails->where('type', 'line') as $item)
                            <tr>
                                <td>{{ $schedule->machine->name ?? '-' }}</td>
                                <td>{{ $schedule->product_name ?? '-' }}</td>
                                <td>{{ $item->dimension_t }}</td>
                                <td>{{ $item->dimension_l }}</td>
                                <td>{{ $item->dimension_p }}</td>
                                <td>{{ $item->pieces }}</td>
                                <td>{{ $item->production_total }}</td>
                                <td>{{ $item->pack }}</td>
                                <td>{{ $item->description }}</td>
                            </tr>
                        @endforeach
                        @foreach ($scheduleDetails->where('type', 'production_remaining')->where('production_total', '>', 0) as $item)
                            <tr>
                                <td>{{ $schedule->machine->name ?? '-' }}</td>
                                <td>{{ $schedule->product_name ?? '-' }}</td>
                                <td>{{ $item->dimension_t }}</td>
                                <td>{{ $item->dimension_l }}</td>
                                <td>{{ $item->dimension_p }}</td>
                                <td>{{ $item->pieces }}</td>
                                <td>{{ $item->production_total }}</td>
                                <td>{{ $item->pack }}</td>
                                <td>{{ $item->description }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>{{ $sumPieces }}</th>
                            <th>{{ number_format($sumProductionTotal ?? 0, 2, ',', '.') }}</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
                <div class="row mt-2">
                    <div class="col-2 p-2">
                        Sipo
                    </div>
                    <div class="col-4 p-2">
                        <strong class="p-2" style="background-color: #efd242;">{{ $schedule->production_remaining }}</strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2 p-2">
                        Jika ada Rewind, harap ditimbang
                    </div>
                    <div class="col-4 p-2">
                    </div>
                </div>
            </div>
            <br />
            <br />
            <br />
            <br />
            <div class="print-footer row ">
                <div class="col-2">
                    <div>
                        <p class="mt-auto">{{ __('PPIC') }}</p>
                    </div>
                    <div>
                        <br />
                        <br />
                        <br />
                        <br />
                    </div>
                    <div>
                        <p class="mt-auto"><strong>Ireng Prasetyo</strong></p>
                    </div>
                </div>
                <div class="col-2">
                    <div>
                        <p class="mt-auto">{{ __('SALES/M.MKT') }}</p>
                    </div>
                    <div>
                        <br />
                        <br />
                        <br />
                        <br />
                    </div>
                    <div>
                        <p class="mt-auto"><strong>(............................)</strong></p>
                    </div>
                </div>
                <div class="col-2">
                    <div>
                        <p class="mt-auto">{{ __('OPERATOR 1') }}</p>
                    </div>
                    <div>
                        <br />
                        <br />
                        <br />
                        <br />
                    </div>
                    <div>
                        <p class="mt-auto"><strong>(............................)</strong></p>
                    </div>
                </div>
                <div class="col-2">
                    <div>
                        <p class="mt-auto">{{ __('OPERATOR 2') }}</p>
                    </div>
                    <div>
                        <br />
                        <br />
                        <br />
                        <br />
                    </div>
                    <div>
                        <p class="mt-auto"><strong>(............................)</strong></p>
                    </div>
                </div>
                <div class="col-2">
                    <div>
                        <p class="mt-auto">{{ __('CHECKER') }}</p>
                    </div>
                    <div>
                        <br />
                        <br />
                        <br />
                        <br />
                    </div>
                    <div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            window.print();
        })
    </script>
</body>

</html>
