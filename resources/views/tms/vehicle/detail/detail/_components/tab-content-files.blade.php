<div class="row p-4">
    <div class="col-md-12">
        <div class="row">
            <div class="col-lg-2 col-md-12">
                @include('tms.vehicle.detail.detail._components.tabs')
            </div>
            <div class="col-lg-10 col-md-12 p-4">
                <div class="tab-content">
                    <div class="tab-pane fade show active">
                        <div class="row align-items-center mb-3">
                            <div class="col-auto">
                                <h6 class="mb-3">Berkas Kendaraan</h6>
                            </div>
                            <div class="col">
                                <div class="float-end">
                                    {{-- @can('manage production') --}}
                                    <a href="#" title="{{ __('Tambah Berkas') }}" data-title="Tambah Berkas" data-url="{{ route('tms.vehicle.show.detail.files.create', $vehicle->id) }}"
                                        data-size="lg" data-bs-toggle="tooltip" data-ajax-popup="true" class="btn btn-sm btn-primary">
                                        <i class="ti ti-plus"></i> Tambah Berkas
                                    </a>
                                    {{-- @endcan --}}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table datatable">
                                    <thead>
                                        <tr>
                                            <th>File</th>
                                            <th>Jenis</th>
                                            <th>Tanggal Upload</th>
                                            <th>Expired</th>
                                            <th>Sisa Waktu</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse($vehicleFiles as $item)
                                            <tr>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->type }}</td>
                                                <td>{{ $item->created_at }}</td>
                                                <td>{{ $item->expired_at }}</td>
                                                <td>{{ $item->remaining_time }}</td>
                                                <td>{{ $item->active ? 'Aktif' : 'Non-aktif' }}</td>
                                                <td>
                                                    @if (!empty($item->file))
                                                        <div class="action-btn bg-primary ms-2">
                                                            <a href="{{ asset('storage/uploads/tms/vehicle/files/' . $item->file) }}"
                                                                target="_blank"
                                                                title="{{ __('Download') }}"
                                                                class="mx-3 btn btn-sm align-items-center"
                                                                data-bs-toggle="tooltip">
                                                                <i class="ti ti-download text-white"></i></a>
                                                        </div>
                                                    @endif
                                                    <div class="action-btn bg-primary ms-2">
                                                        <a href="#" title="{{ __('Edit') }}"
                                                            class="mx-3 btn btn-sm align-items-center" data-title="{{ __('Edit Vehicle') }}"
                                                            data-original-title="{{ __('Edit') }}"
                                                            data-url="{{ route('tms.vehicle.show.detail.files.edit', ['id' => $vehicle->id, 'fileId' => $item->id]) }}" data-size="lg"
                                                            data-ajax-popup="true" data-bs-toggle="tooltip">
                                                            <i class="ti ti-pencil text-white"></i></a>
                                                    </div>
                                                    <div class="action-btn bg-danger ms-2">
                                                        {!! Form::open([
                                                            'method' => 'DELETE',
                                                            'route' => ['tms.vehicle.show.detail.files.destroy', ['id' => $vehicle->id, 'fileId' => $item->id]],
                                                            'id' => 'delete-form-' . $item->id,
                                                        ]) !!}

                                                        <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para"
                                                            title="{{ __('Delete') }}" data-bs-toggle="tooltip"
                                                            data-original-title="{{ __('Delete') }}"
                                                            data-confirm="{{ __('Are You Sure?') . '|' . __('This action can not be undone. Do you want to continue?') }}"
                                                            data-confirm-yes="document.getElementById('delete-form-{{ $item->id }}').submit();">
                                                            <i class="ti ti-trash text-white"></i></a>
                                                        {!! Form::close() !!}
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
