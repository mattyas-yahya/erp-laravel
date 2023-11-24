<div class="table-responsive">
    <table class="table datatable">
        <thead>
            @include('tms.vehicle._components.header-table')
        </thead>

        <tbody>
            @forelse($vehicles as $item)
                <tr>
                    <td>{{ $item->license_plate }}</td>
                    <td>{{ $item?->branch->name ?? 'Semua Cabang' }}</td>
                    <td>{{ $item->hull_number }}</td>
                    <td>{{ $item->active ? 'Aktif' : 'Tidak Aktif' }}</td>
                    <td>
                        <div class="action-btn bg-primary ms-2">
                            <a href="#" title="{{ __('Edit') }}"
                                class="mx-3 btn btn-sm align-items-center" data-title="{{ __('Edit Vehicle') }}"
                                data-original-title="{{ __('Edit') }}"
                                data-url="{{ route('tms.vehicle.edit', $item->id) }}" data-size="lg"
                                data-ajax-popup="true" data-bs-toggle="tooltip">
                                <i class="ti ti-pencil text-white"></i></a>
                        </div>
                        <div class="action-btn bg-success ms-2">
                            <a href="{{ route('tms.vehicle.show', $item->id) }}"
                                title="{{ __('Detail') }}"
                                class="mx-3 btn btn-sm align-items-center"
                                data-bs-toggle="tooltip">
                                <i class="ti ti-plus text-white"></i></a>
                        </div>
                        <div class="action-btn bg-danger ms-2">
                            {!! Form::open([
                                'method' => 'DELETE',
                                'route' => ['tms.vehicle.destroy', $item->id],
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
