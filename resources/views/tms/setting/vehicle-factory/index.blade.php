@extends('layouts.admin')
@section('page-title')
    {{ __('Pengaturan TMS') }}
@endsection

@section('breadcrumb')
    @include ('partials.admin.breadcrumbs', [
        'item' => __('Master Pabrikan Kendaraan'),
    ])
@endsection

@push('css-page')
    <link rel="stylesheet" href="{{ asset('css/datatable/buttons.dataTables.min.css') }}">
@endpush

@section('action-btn')
    <div class="float-end">
        @can('manage production')
            <a href="#" title="{{ __('Create') }}" data-title="Tambah Pabrikan Kendaraan"
                data-url="{{ route('tms.setting.vehicle-factory.create') }}" data-size="lg" data-bs-toggle="tooltip" data-ajax-popup="true"
                class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i>
            </a>
        @endcan
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-3">
            @include('tms.setting.layout')
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($factories as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        {{-- @canany('manage production') --}}
                                            <td>
                                                <div class="action-btn bg-primary ms-2">
                                                    <a href="#" title="{{ __('Edit') }}"
                                                        class="mx-3 btn btn-sm align-items-center"
                                                        data-title="{{ __('Edit Item') }}"
                                                        data-original-title="{{ __('Edit') }}"
                                                        data-url="{{ route('tms.setting.vehicle-factory.edit', $item->id) }}"
                                                        data-size="lg" data-ajax-popup="true"
                                                        data-bs-toggle="tooltip">
                                                        <i class="ti ti-pencil text-white"></i></a>
                                                </div>
                                                {{-- @can('manage production') --}}
                                                    <div class="action-btn bg-danger ms-2">
                                                        {!! Form::open([
                                                            'method' => 'DELETE',
                                                            'route' => ['tms.setting.vehicle-factory.destroy', $item->id],
                                                            'id' => 'delete-form-' . $item->id,
                                                        ]) !!}

                                                        <a href="#"
                                                            class="mx-3 btn btn-sm align-items-center bs-pass-para"
                                                            data-bs-toggle="tooltip" title="{{ __('Delete') }}"
                                                            data-original-title="{{ __('Delete') }}"
                                                            data-confirm="{{ __('Are You Sure?') . '|' . __('This action can not be undone. Do you want to continue?') }}"
                                                            data-confirm-yes="document.getElementById('delete-form-{{ $item->id }}').submit();">
                                                            <i class="ti ti-trash text-white"></i></a>
                                                        {!! Form::close() !!}
                                                    </div>
                                                {{-- @endcan --}}
                                            </td>
                                        {{-- @endcan --}}
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
@endsection
