<div class="tab-pane fade show active" id="tab-machine-all" role="tabpanel" aria-labelledby="pills-user-tab-all">
    <div class="table-responsive">
        <table class="table datatable-all">
            <thead>
                @include('production.schedule._components.header-table')
            </thead>

            <tbody>
                @forelse($schedules as $item)
                    <tr>
                        <td><input type="checkbox" class="form-check-input print-bulk" name="id"
                            value="{{ $item->id }}" /></td>
                        <td>{{ $item->job_order_number }}</td>
                        <td>{{ $item->salesOrderLine?->so_number ?? '<SO is missing>' }}</td>
                        <td>{{ Auth::user()->customerNumberFormat($item->customer->customer_id) ?? '<undefined>' }}</td>
                        <td>{{ Auth::user()->dateFormat($item->production_date) }}</td>
                        <td>{{ $item->machine->name ?? '<undefined>' }}</td>
                        <td>{{ $item->salesOrderLine?->gr_from_so?->sku_number ?? '<undefined>' }}</td>
                        <td>{{ $item->salesOrderLine?->gr_from_so?->no_coil ?? '<undefined>' }}</td>
                        <td>{{ $item->salesOrderLine?->gr_from_so?->weight ?? '<undefined>' }}</td>
                        <td>{{ $item->product_name ?? '<undefined>' }}</td>
                        <td>{{ $item->salesOrderLine?->gr_from_so?->dimensions ?? '<undefined>' }}</td>
                        <td>{{ $item->salesOrderLine?->qty ?? '<undefined>' }}</td>
                        <td>{{ $item->salesOrderLine?->gr_from_so?->unit()->name ?? '<undefined>' }}</td>
                        <td>{{ $item->status ?? '<undefined>' }}</td>
                        <td>{{ $item->production_status ?? '<undefined>' }}</td>
                        <td>{{ $item->details_sum_production_total ?? '' }}</td>
                        <td>{{ $item->production_remaining ?? '<undefined>' }}</td>
                        @canany('manage production')
                            <td>
                                <div class="action-btn bg-dark ms-2">
                                    <a href="{{ route('production.schedule.generate-pdf', $item->id) }}"
                                        class="btn btn-sm btn-icon m-1" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="{{ __('Print') }} - {{ $item->job_order_number }}" target="_blanks">
                                        <i class="ti ti-printer text-white"></i>
                                    </a>
                                </div>

                                <div class="action-btn bg-warning ms-2">
                                    <a href="#" title="{{ __('Show') }}"
                                        class="mx-3 btn btn-sm align-items-center"
                                        data-title="{{ __('Show') }} - {{ $item->job_order_number }}"
                                        data-url="{{ route('production.schedule.show', $item->id) }}" data-size="lg"
                                        data-bs-toggle="tooltip" data-ajax-popup="true">
                                        <i class="ti ti-eye text-black"></i>
                                    </a>
                                </div>

                                <div class="action-btn bg-success ms-2">
                                    <a href="{{ route('production.schedule.detail.index', $item->id) }}"
                                        title="{{ __('Production Schedule Line') }}"
                                        class="mx-3 btn btn-sm align-items-center"
                                        data-title="{{ __('Production Schedule Line') }}"
                                        data-original-title="{{ __('Production Schedule Line') }}"
                                        data-bs-toggle="tooltip">
                                        <i class="ti ti-plus text-white"></i></a>
                                </div>

                                @if ($item?->details()->where('type', App\Domains\Production\ProductionScheduleDetailTypeValue::TYPE_PRODUCTION_REMAINING)->count() > 0)
                                <div class="action-btn bg-secondary ms-2">
                                    <a href="{{ route('production.schedule.production-remaining.index', $item->id) }}"
                                        title="{{ __('Production Schedule Production Remaining') }}"
                                        class="mx-3 btn btn-sm align-items-center"
                                        data-title="{{ __('Production Schedule Production Remaining') }}"
                                        data-original-title="{{ __('Production Schedule Production Remaining') }}"
                                        data-bs-toggle="tooltip">
                                        <i class="ti ti-plus text-white"></i></a>
                                </div>

                                <div class="action-btn bg-secondary ms-2">
                                    <a href="#" title="{{ __('Edit Production Remaining') }}"
                                        class="mx-3 btn btn-sm align-items-center"
                                        data-title="{{ __('Edit Production Remaining') }}"
                                        data-original-title="{{ __('Edit Production Remaining') }}"
                                        data-url="{{ route('production.schedule.production-remaining.edit', [
                                            'id' => $item->id,
                                            'detailId' => $item
                                                ?->details()
                                                ->where('type', App\Domains\Production\ProductionScheduleDetailTypeValue::TYPE_PRODUCTION_REMAINING)
                                                ?->first()
                                                ?->id
                                        ]) }}" data-size="lg"
                                        data-ajax-popup="true" data-bs-toggle="tooltip">
                                        <i class="ti ti-pencil text-white"></i></a>
                                </div>
                                @endif

                                @can('manage production')
                                    <div class="action-btn bg-primary ms-2">
                                        <a href="#" title="{{ __('Edit') }}"
                                            class="mx-3 btn btn-sm align-items-center"
                                            data-title="{{ __('Edit Production Schedule') }}"
                                            data-original-title="{{ __('Edit') }}"
                                            data-url="{{ route('production.schedule.edit', $item->id) }}" data-size="lg"
                                            data-ajax-popup="true" data-bs-toggle="tooltip">
                                            <i class="ti ti-pencil text-white"></i></a>
                                    </div>

                                    <div class="action-btn bg-danger ms-2">
                                        {!! Form::open([
                                            'method' => 'DELETE',
                                            'route' => ['production.schedule.destroy', $item->id],
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
                                @endcan
                            </td>
                        @endcan
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
