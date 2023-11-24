@foreach ($salesOrders as $item)
    <tr>
        <td>
            @if (!empty($item->cust))
                <a href="#" data-url="{{ route('purchase-request.show', $item->cust->customer_id) }}" data-size="lg"
                    data-bs-toggle="tooltip" title="{{ __('Show') }}" data-ajax-popup="true"
                    data-title="{{ __('Show') }}" class="mx-3 btn btn-sm btn-outline-primary align-items-center">
                    {{ Auth::user()->customerNumberFormat($item->cust->customer_id) }}
                </a>
            @endif
        </td>
        <td>{{ $item?->cust->billing_address ?? '' }}</td>
        <td>{{ $item->reff_po_cust }}</td>
        <td>{{ date('d-m-Y', strtotime($item->date_order)) }}</td>
        <td>{{ $item->so_number }}</td>
        <td>{{ $item?->employees->name ?? '' }}</td>
        <td>{{ $item?->terms->name ?? '' }}</td>
        <td>{{ $item->delivery }}</td>
        <td>{{ $item?->category->name ?? '' }}</td>
        <td>{{ $item->status }}</td>
        @if (Gate::check('manage sales order') || Gate::check('manage sales order'))
            <td>
                <div class="action-btn bg-dark ms-2">
                    <a href="#" data-url="{{ route('sales-order.show', $item->id) }}" data-size="lg"
                        data-bs-toggle="tooltip" title="{{ __('Print') }}" data-ajax-popup="true"
                        data-title="{{ __('Print') }} - {{ $item->so_number }}"
                        class="mx-3 btn btn-sm align-items-center">
                        <i class="ti ti-printer text-white"></i>
                    </a>
                </div>
                <div class="action-btn bg-warning ms-2">
                    <a href="#" data-url="{{ route('sales-order.show', $item->id) }}"` data-size="lg"
                        data-bs-toggle="tooltip" title="{{ __('Show') }}" data-ajax-popup="true"
                        data-title="{{ __('Show') }} - {{ $item->so_number }}"
                        class="mx-3 btn btn-sm align-items-center">
                        <i class="ti ti-eye text-white"></i>
                    </a>
                </div>
                <div class="action-btn bg-success ms-2">
                    <a href="{{ route('sales-order.index_detail', $item->id) }}"
                        data-title="{{ __('Sales Order Line') }}" class="mx-3 btn btn-sm align-items-center"
                        data-bs-toggle="tooltip" title="{{ __('Sales Order Line') }}"
                        data-original-title="{{ __('Sales Order Line') }}">
                        <i class="ti ti-plus text-white"></i></a>
                </div>
                <div class="action-btn bg-primary ms-2">
                    <a href="#" data-url="{{ URL::to('sales-order/' . $item->id . '/edit') }}" data-size="lg"
                        data-ajax-popup="true" data-title="{{ __('Edit Purchase') }}"
                        class="mx-3 btn btn-sm align-items-center" data-bs-toggle="tooltip" title="{{ __('Edit') }}"
                        data-original-title="{{ __('Edit') }}">
                        <i class="ti ti-pencil text-white"></i></a>
                </div>
                @can('delete sales order')
                    <div class="action-btn bg-danger ms-2">
                        {!! Form::open([
                            'method' => 'DELETE',
                            'route' => ['sales-order.destroy', $item->id],
                            'id' => 'delete-form-' . $item->id,
                        ]) !!}

                        <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para" data-bs-toggle="tooltip"
                            title="{{ __('Delete') }}" data-original-title="{{ __('Delete') }}"
                            data-confirm="{{ __('Are You Sure?') . '|' . __('This action can not be undone. Do you want to continue?') }}"
                            data-confirm-yes="document.getElementById('delete-form-{{ $item->id }}').submit();">
                            <i class="ti ti-trash text-white"></i></a>
                        {!! Form::close() !!}
                    </div>
                @endcan
            </td>
        @endif
    </tr>
@endforeach
