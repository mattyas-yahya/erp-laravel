<div class="row p-4">
    <div class="col-md-12">
        <div class="row">
            <div class="col-lg-2 col-md-12">
                @include('tms.vehicle.detail.maintenance._components.tabs')
            </div>
            <div class="col-lg-10 col-md-12 p-4">
                <div class="tab-content">
                    <div class="tab-pane fade show active">
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table datatable">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>KM Rencana</th>
                                            <th>Tgl Rencana</th>
                                            <th>Status</th>
                                            <th>Rencana Biaya</th>
                                            <th>Tgl Realisasi</th>
                                            <th>Biaya Realisasi</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse($vehicleMaintenances as $item)
                                            <tr>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->planned_kilometers }}</td>
                                                <td>{{ \Auth::user()->dateFormat($item->planned_at) }}</td>
                                                <td>{{ $item->status_text }}</td>
                                                <td>{{ \Auth::user()->priceFormat($item->planned_cost) }}</td>
                                                <td>{{ !empty($item->realized_at) ? \Auth::user()->dateFormat($item->realized_at) : '-' }}
                                                </td>
                                                <td>{{ !empty($item->realized_cost) ? \Auth::user()->priceFormat($item->realized_cost) : '-' }}</td>
                                                <td>
                                                    <div class="action-btn bg-warning ms-2">
                                                        <a href="{{ route('tms.vehicle.show.maintenance.show', ['id' => $vehicle->id, 'maintenanceId' => $item->id]) }}"
                                                            title="{{ __('Detail') }}"
                                                            class="mx-3 btn btn-sm align-items-center"
                                                            data-bs-toggle="tooltip">
                                                            <i class="ti ti-eye text-black"></i></a>
                                                    </div>
                                                    <div class="action-btn bg-primary ms-2">
                                                        <a href="#" title="{{ __('Update Status') }}"
                                                            class="mx-3 btn btn-sm align-items-center"
                                                            data-title="{{ __('Update Status') }}"
                                                            data-original-title="{{ __('Update Status') }}"
                                                            data-url="{{ route('tms.vehicle.show.maintenance.status.edit', ['id' => $vehicle->id, 'maintenanceId' => $item->id]) }}"
                                                            data-size="sm" data-ajax-popup="true"
                                                            data-bs-toggle="tooltip">
                                                            <i class="ti ti-status-change text-white"></i>
                                                        </a>
                                                    </div>
                                                    <div class="action-btn bg-primary ms-2">
                                                        <a href="{{ route('tms.vehicle.show.maintenance.realization', ['id' => $vehicle->id, 'maintenanceId' => $item->id]) }}"
                                                            title="{{ __('Input Realisasi') }}"
                                                            class="mx-3 btn btn-sm align-items-center"
                                                            data-bs-toggle="tooltip">
                                                            <i class="ti ti-pencil text-white"></i>
                                                    </div>
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
            </div>
        </div>
    </div>
</div>
