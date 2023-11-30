@extends('layouts.admin')
@section('page-title')
    TMS Detail Perawatan Kendaraan
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">TMS</li>
    <li class="breadcrumb-item"><a href="{{ route('tms.vehicle.index') }}">{{ __('Kendaraan') }}</a></li>
    <li class="breadcrumb-item">Detail</li>
    <li class="breadcrumb-item">Perawatan</li>
@endsection

@push('script-page')
@endpush

@section('content')
    <div class="p-3 card">
        @include('tms.vehicle.detail._components.tabs')

        <div class="tab-content">
            <div class="tab-pane fade show active" id="tab-document" role="tabpanel" aria-labelledby="pills-tab-document">
                <div class="row p-4">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-lg-2 col-md-12">
                                @include('tms.vehicle.detail.document._components.tabs')
                            </div>
                            <div class="col-lg-10 col-md-12 p-4">
                                <div class="tab-content">
                                    <div class="tab-pane fade show active">
                                        <div class="row mb-5">
                                            <h6 class="mb-3">Detail Perawatan</h6>

                                            <div class="col-6">
                                                <div class="row mb-1">
                                                    <div class="col-4">Internal / Eksternal</div>
                                                    <div class="col-8">{{ $vehicleMaintenance->context_type_text }}</div>
                                                </div>
                                                <div class="row mb-1">
                                                    <div class="col-4">Nama Perawatan</div>
                                                    <div class="col-8">{{ $vehicleMaintenance->name }}</div>
                                                </div>
                                                <div class="row mb-1">
                                                    <div class="col-4">Tgl Rencana</div>
                                                    <div class="col-8">{{ \Auth::user()->dateFormat($vehicleMaintenance->planned_at) }}</div>
                                                </div>
                                                <div class="row mb-1">
                                                    <div class="col-4">Status</div>
                                                    <div class="col-8"><span class="badge bg-primary p-2 px-3 rounded">{{ $vehicleMaintenance->status_text }}</span></div>
                                                </div>
                                                <div class="row mb-1">
                                                    <div class="col-4">Tgl Pengajuan</div>
                                                    <div class="col-8">{{ \Auth::user()->dateFormat($vehicleMaintenance->created_at) }}</div>
                                                </div>
                                                <div class="row mb-1">
                                                    <div class="col-4">Rencana Biaya Jasa</div>
                                                    <div class="col-8">{{ \Auth::user()->priceFormat($vehicleMaintenance->planned_cost) }}</div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="row mb-1">
                                                    <div class="col-4">Vendor</div>
                                                    <div class="col-8">{{ $vehicleMaintenance->vendor }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div class="row">
                                            <h6 class="mb-3">Detail Barang</h6>

                                            <div class="table-responsive">
                                                <table class="table datatable">
                                                    <thead>
                                                        <tr>
                                                            <th>Nama Item</th>
                                                            <th>Part Number</th>
                                                            <th>Kategori</th>
                                                            <th>Tipe Kegiatan</th>
                                                            <th>Qty Rencana</th>
                                                            <th>Harga Rencana</th>
                                                            <th>Total Rencana</th>
                                                            <th>Qty Realisasi</th>
                                                            <th>Harga Realisasi</th>
                                                            <th>Total Realisasi</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @forelse($vehicleMaintenanceDetails as $item)
                                                            <tr>
                                                                <td>{{ $item->name }}</td>
                                                                <td>{{ $item->part_number }}</td>
                                                                <td>{{ $item->category }}</td>
                                                                <td>{{ $item->activity_type }}</td>
                                                                <td>{{ $item->planned_quantity }}</td>
                                                                <td>{{ $item->planned_cost }}</td>
                                                                <td>{{ $item->planned_cost_total }}</td>
                                                                <td>{{ $item->realized_quantity }}</td>
                                                                <td>{{ $item->realized_cost }}</td>
                                                                <td>{{ $item->realized_cost_total }}</td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="13" class="text-center text-dark">
                                                                    <p>{{ __('No Data Found') }}</p>
                                                                </td>
                                                                <td colspan="2">
                                                                </td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
