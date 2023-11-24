<div class="table-responsive">
    <table class="table datatable">
        <thead>
            @include('tms.assignment.detail._components.header-table')
        </thead>

        <tbody>
            @forelse($assignment->details as $item)
                <tr>
                    <td>{{ 'MANIFEST/' . Str::substr($assignment->delivery_order_number, -3) }}</td>
                    <td>{{ Auth::user()->customerNumberFormat($item->customer_id) ?? '<undefined>' }}</td>
                    <td>{{ $item?->salesOrderDetail?->so_number }}</td>
                    <td>{{ $item?->salesOrderDetail?->gr_from_so?->product_name }}</td>
                    <td>{{ $item?->salesOrderDetail?->qty }}</td>
                    <td>{{ $item?->salesOrderDetail?->unit }}</td>
                    <td>{{ $item?->salesOrderDetail?->productionSchedule?->details()?->sum('production_total') }}</td>
                    {{-- @canany('manage production') --}}
                    <td>
                        {{-- <div class="action-btn bg-primary ms-2">
                            <a href="#" title="{{ __('Edit') }}" class="mx-3 btn btn-sm align-items-center"
                                data-title="{{ __('Edit') }}" data-original-title="{{ __('Edit') }}"
                                data-url="{{ route('tms.assignment.detail.edit', ['id' => $assignment->id, 'detailId' => $item->id]) }}" data-size="lg"
                                data-ajax-popup="true" data-bs-toggle="tooltip">
                                <i class="ti ti-pencil text-white"></i></a>
                        </div> --}}
                        <div class="action-btn bg-danger ms-2">
                            {!! Form::open([
                                'method' => 'DELETE',
                                'route' => ['tms.assignment.detail.destroy', ['id' => $assignment->id, 'detailId' => $item->id]],
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
