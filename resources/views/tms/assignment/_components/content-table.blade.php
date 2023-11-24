<div class="table-responsive">
    <table class="table datatable">
        <thead>
            @include('tms.assignment._components.header-table')
        </thead>

        <tbody>
            @forelse($assignments as $item)
                <tr>
                    <td>{{ $item->delivery_order_number }}</td>
                    <td>{{ $item?->vehicle?->license_plate }}</td>
                    <td>{{ $item->driver->name }}</td>
                    <td>{{ \Auth::user()->dateFormat($item->started_at) }}</td>
                    <td>{{ $item->ended_at ? \Auth::user()->dateFormat($item->ended_at) : '' }}</td>
                    <td>{{ $item->starting_odometer }}</td>
                    <td>{{ $item->last_odometer }}</td>
                    <td>{{ $item->comment }}</td>
                    {{-- @canany('manage production') --}}
                    <td>
                        <div class="action-btn bg-success ms-2">
                            <a href="{{ route('tms.assignment.detail.index', $item->id) }}"
                                title="{{ __('Assignment Line') }}"
                                class="mx-3 btn btn-sm align-items-center"
                                data-title="{{ __('Assignment Line') }}"
                                data-original-title="{{ __('Assignment Line') }}"
                                data-bs-toggle="tooltip">
                                <i class="ti ti-plus text-white"></i></a>
                        </div>
                        <div class="action-btn bg-primary ms-2">
                            <a href="#" title="{{ __('Edit') }}" class="mx-3 btn btn-sm align-items-center"
                                data-title="{{ __('Edit') }}" data-original-title="{{ __('Edit') }}"
                                data-url="{{ route('tms.assignment.edit', $item->id) }}" data-size="lg"
                                data-ajax-popup="true" data-bs-toggle="tooltip">
                                <i class="ti ti-pencil text-white"></i></a>
                        </div>
                        <div class="action-btn bg-danger ms-2">
                            {!! Form::open([
                                'method' => 'DELETE',
                                'route' => ['tms.assignment.destroy', $item->id],
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
