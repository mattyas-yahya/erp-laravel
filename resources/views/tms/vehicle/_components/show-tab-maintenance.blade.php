<div class="row p-4">
    <div class="col-md-12">
        <div class="row">
            <div class="col-2">
                <a href="#"
                    title="{{ __('Tambah Perawatan') }}"
                    data-title="Tambah Perawatan"
                    data-url="#"
                    data-size="lg"
                    data-bs-toggle="tooltip"
                    data-ajax-popup="true"
                    class="btn btn-sm btn-primary"
                >
                    <i class="ti ti-plus"></i> Tambah Perawatan
                </a>

                <ul class="nav nav-pills nav-fill flex-column mt-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button
                            class="nav-link text-start active"
                            id="nav-tab-maintenance-tab-request"
                            data-bs-toggle="pill"
                            data-bs-target="#tab-maintenance-tab-request"
                            type="button"
                        >
                            <span class="float-start">Pengajuan</span>
                            <span class="badge bg-dark float-end">0</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button
                            class="nav-link text-start"
                            id="nav-tab-maintenance-tab-plan"
                            data-bs-toggle="pill"
                            data-bs-target="#tab-maintenance-tab-plan"
                            type="button"
                        >
                            <span class="float-start">Rencana</span>
                            <span class="badge bg-dark float-end">0</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button
                            class="nav-link text-start"
                            id="nav-tab-maintenance-tab-maintenance"
                            data-bs-toggle="pill"
                            data-bs-target="#tab-maintenance-tab-maintenance"
                            type="button"
                        >
                            <span class="float-start">Perawatan</span>
                            <span class="badge bg-dark float-end">0</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button
                            class="nav-link"
                            id="nav-tab-maintenance-tab-finished"
                            data-bs-toggle="pill"
                            data-bs-target="#tab-maintenance-tab-finished"
                            type="button"
                        >
                            <span class="float-start">Selesai</span>
                            <span class="badge bg-dark float-end">0</span>
                        </button>
                    </li>
                </ul>
            </div>
            <div class="col-10 p-4">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab-maintenance-tab-request" role="tabpanel" aria-labelledby="nav-tab-maintenance-tab-request">
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table datatable-maintenance-request">
                                    <thead>
                                        <tr>
                                            <th>Deskripsi</th>
                                            <th>KM Rencana</th>
                                            <th>Tgl Rencana</th>
                                            <th>Status</th>
                                            <th>Rencana Biaya</th>
                                            <th>Tgl Realisasi</th>
                                            <th>Biaya Realisasi</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse([] as $item)
                                            <tr>
                                                <td>Deskripsi</td>
                                                <td>KM Rencana</td>
                                                <td>Tgl Rencana</td>
                                                <td>Status</td>
                                                <td>Rencana Biaya</td>
                                                <td>Tgl Realisasi</td>
                                                <td>Biaya Realisasi</td>
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
                        <div class="tab-pane fade show" id="tab-maintenance-tab-plan" role="tabpanel" aria-labelledby="nav-tab-maintenance-tab-plan">
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table datatable-maintenance-plan">
                                        <thead>
                                            <tr>
                                                <th>Deskripsi</th>
                                                <th>KM Rencana</th>
                                                <th>Tgl Rencana</th>
                                                <th>Status</th>
                                                <th>Rencana Biaya</th>
                                                <th>Tgl Realisasi</th>
                                                <th>Biaya Realisasi</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @forelse([] as $item)
                                                <tr>
                                                    <td>Deskripsi</td>
                                                    <td>KM Rencana</td>
                                                    <td>Tgl Rencana</td>
                                                    <td>Status</td>
                                                    <td>Rencana Biaya</td>
                                                    <td>Tgl Realisasi</td>
                                                    <td>Biaya Realisasi</td>
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
</div>
