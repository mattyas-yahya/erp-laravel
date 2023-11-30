@extends('layouts.admin')
@section('page-title')
    TMS Detail - Dokumen
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">TMS</li>
    <li class="breadcrumb-item"><a href="{{ route('tms.vehicle.index') }}">{{ __('Kendaraan') }}</a></li>
    <li class="breadcrumb-item">Detail</li>
    <li class="breadcrumb-item">Dokumen</li>
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
                                        <div class="row">
                                            <div class="table-responsive">
                                                <table class="table datatable">
                                                    <thead>
                                                        <tr>
                                                            <th>Deskripsi</th>
                                                            <th>Tgl Rencana</th>
                                                            <th>Status</th>
                                                            <th>Rencana Biaya</th>
                                                            <th>Tgl Realisasi</th>
                                                            <th>Biaya Realisasi</th>
                                                            <th>Vendor</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @forelse($vehicleOtherDocuments as $item)
                                                            <tr>
                                                                <td>{{ $item->name }}</td>
                                                                <td>{{ \Auth::user()->dateFormat($item->planned_at) }}</td>
                                                                <td>{{ $item->status_text }}</td>
                                                                <td>{{ \Auth::user()->priceFormat($item->planned_cost) }}</td>
                                                                <td>{{ !empty($item->realized_at) ? \Auth::user()->dateFormat($item->realized_at) : '-' }}
                                                                </td>
                                                                <td>{{ !empty($item->realized_cost) ? \Auth::user()->priceFormat($item->realized_cost) : '-' }}</td>
                                                                <td>{{ $item->vendor }}</td>
                                                                <td>
                                                                    {{-- <div class="action-btn bg-warning ms-2">
                                                                        <a href="{{ route('tms.vehicle.show.document.show', ['id' => $vehicle->id, 'documentId' => $item->id]) }}"
                                                                            title="{{ __('Detail') }}"
                                                                            class="mx-3 btn btn-sm align-items-center"
                                                                            data-bs-toggle="tooltip">
                                                                            <i class="ti ti-eye text-black"></i></a>
                                                                    </div> --}}
                                                                    <div class="action-btn bg-primary ms-2">
                                                                        <a href="#" title="{{ __('Update Status') }}"
                                                                            class="mx-3 btn btn-sm align-items-center"
                                                                            data-title="{{ __('Update Status') }}"
                                                                            data-original-title="{{ __('Update Status') }}"
                                                                            data-url="{{ route('tms.vehicle.show.document.status.edit', ['id' => $vehicle->id, 'documentId' => $item->id]) }}"
                                                                            data-size="sm" data-ajax-popup="true"
                                                                            data-bs-toggle="tooltip">
                                                                            <i class="ti ti-status-change text-white"></i>
                                                                        </a>
                                                                    </div>
                                                                    {{-- <div class="action-btn bg-primary ms-2">
                                                                        <a href="{{ route('tms.vehicle.show.document.realization', ['id' => $vehicle->id, 'documentId' => $item->id]) }}"
                                                                            title="{{ __('Input Realisasi') }}"
                                                                            class="mx-3 btn btn-sm align-items-center"
                                                                            data-bs-toggle="tooltip">
                                                                            <i class="ti ti-plus text-white"></i>
                                                                        </a>
                                                                    </div> --}}
                                                                    <div class="action-btn bg-primary ms-2">
                                                                        <a href="{{ route('tms.vehicle.show.document.edit', ['id' => $vehicle->id, 'documentId' => $item->id]) }}"
                                                                            title="{{ __('Edit') }}"
                                                                            class="mx-3 btn btn-sm align-items-center"
                                                                            data-bs-toggle="tooltip">
                                                                            <i class="ti ti-pencil text-white"></i></a>
                                                                    </div>
                                                                    <div class="action-btn bg-danger ms-2">
                                                                        {!! Form::open([
                                                                            'method' => 'DELETE',
                                                                            'route' => ['tms.vehicle.show.document.destroy', ['id' => $vehicle->id, 'documentId' => $item->id]],
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
            </div>
        </div>
    </div>
@endsection
