<div class="row p-4">
    <div class="col-md-12">
        <div class="row">
            <div class="col-8">
                <div class="row">
                    <div class="col-4">
                        <img src="@if (!empty($vehicle->image)) {{ asset('storage/uploads/tms/vehicle/' . $vehicle->image) }} @else {{ asset('assets/images/vehicle_placeholder.jpg') }} @endif" class="rounded" style="max-width: 100%; max-height: 180px;" />
                    </div>
                    <div class="col-8">
                        <div class="row">
                            <div class="col-6">
                                <h1>{{ $vehicle->license_plate }}</h1>
                            </div>
                            <div class="col-6">
                                @if ($vehicle->active)
                                <div class="ms-2 border-0">
                                    {!! Form::open([
                                        'method' => 'POST',
                                        'route' => ['tms.vehicle.deactivate', $vehicle->id],
                                        'id' => 'deactivate-form-' . $vehicle->id,
                                    ]) !!}

                                    <a href="#" class="mx-3 btn btn-sm btn-warning align-items-center bs-pass-para text-white"
                                        style="float: right"
                                        title="{{ __('Deactivate') }}" data-bs-toggle="tooltip"
                                        data-original-title="{{ __('Deactivate') }}"
                                        data-confirm="{{ __('Are You Sure?') . '|' . __('This action can not be undone. Do you want to continue?') }}"
                                        data-confirm-yes="document.getElementById('deactivate-form-{{ $vehicle->id }}').submit();">
                                        <i class="fas fa-toggle-on"></i> Non-aktifkan Kendaraan </a>
                                    {!! Form::close() !!}
                                </div>
                                @else
                                <div class="ms-2 border-0">
                                    {!! Form::open([
                                        'method' => 'POST',
                                        'route' => ['tms.vehicle.activate', $vehicle->id],
                                        'id' => 'activate-form-' . $vehicle->id,
                                    ]) !!}

                                    <a href="#" class="mx-3 btn btn-sm btn-success align-items-center bs-pass-para text-white"
                                        style="float: right"
                                        title="{{ __('Activate') }}" data-bs-toggle="tooltip"
                                        data-original-title="{{ __('Activate') }}"
                                        data-confirm="{{ __('Are You Sure?') . '|' . __('This action can not be undone. Do you want to continue?') }}"
                                        data-confirm-yes="document.getElementById('activate-form-{{ $vehicle->id }}').submit();">
                                        <i class="fas fa-toggle-off"></i> Aktifkan Kendaraan </a>
                                    {!! Form::close() !!}
                                </div>
                                @endif
                            </div>
                        </div>
                        <hr />
                        <div class="row mb-1">
                            <div class="col-4">Branch</div>
                            <div class="col-8">{{ $vehicle?->branch?->name }}</div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-4">Tgl Entri</div>
                            <div class="col-8">{{ \Auth::user()->dateFormat($vehicle->created_at) }}</div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-4">Pemilik</div>
                            <div class="col-8">{{ $vehicle?->owner?->name }}</div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-4">Part</div>
                            <div class="col-8"></div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-4">Model</div>
                            <div class="col-8">{{ $vehiclePhysical->model }}</div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-4">No. Sassis / No. Mesin</div>
                            <div class="col-8">{{ $vehiclePhysical->chassis_number }} / {{ $vehiclePhysical->engine_number }}</div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-4">Aktif</div>
                            <div class="col-8">
                                @if ($vehicle->active)
                                    <span class="badge bg-primary p-2 px-3 rounded">Aktif</span>
                                @else
                                    <span class="badge bg-danger p-2 px-3 rounded">Non-aktif</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="row mb-3">
                    <h5>Riwayat Perawatan Terakhir</h5>
                    <hr />
                    <div class="row mb-1">
                        <div class="col-4">Jenis Perawatan</div>
                        <div class="col-8">{{ $vehicleMaintenances->name }}</div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-4">Tanggal</div>
                        <div class="col-8">{{ \Auth::user()->dateFormat($vehicleMaintenances->planned_at) }}</div>
                    </div>
                </div>

                <div class="row">
                    <h5>Vehicle Job Summary</h5>
                    <hr />
                    <div class="row mb-1">
                        <div class="col-6">TOTAL JOB ONGOING</div>
                        <div class="col-6">{{ $assignments->whereNull('ended_at')->where('ended_at', '')->count() }}</div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-6">TOTAL JOB FINISHED</div>
                        <div class="col-6">{{ $assignments->whereNotNull('ended_at')->count() }}</div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-6">TOTAL JOB</div>
                        <div class="col-6">{{ $assignments->count() }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <h5>Delivery Job List</h5>

            <div class="table-responsive">
                <table class="table datatable">
                    <thead>
                        <tr>
                            <th>No. Surat Jalan</th>
                            <th>No. Manifest</th>
                            <th>Driver</th>
                            <th>Route</th>
                            <th>Status Pengiriman</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($assignments as $item)
                            <tr>
                                <td>{{ $item->delivery_order_number }}</td>
                                <td>MANIFEST/{{ Str::substr($item->delivery_order_number, -3) }}</td>
                                <td>{{ $item?->driver->name }}</td>
                                <td>{{ $item?->details->groupBy('customer_id')->map(function ($detail) {
                                        // dd($detail);
                                        return $detail->first()?->customer->shippingAddresses->map(function ($customer) {
                                            return $customer->name;
                                        })->join('');
                                    })->join(', ') }}</td>
                                <td>
                                    @if (!empty($item->ended_at))
                                        FINISHED
                                    @endif
                                    @if (empty($item->ended_at))
                                        @if (now()->gte($item->started_at))
                                            ON DELIVERY
                                        @else
                                            SCHEDULED
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if (!empty($item->ended_at))
                                        FINISHED
                                    @endif
                                    @if (empty($item->ended_at))
                                        @if (now()->gte($item->started_at))
                                            ON PROCESS
                                        @else
                                            SCHEDULED
                                        @endif
                                    @endif
                                </td>
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
        </div>
    </div>
</div>
