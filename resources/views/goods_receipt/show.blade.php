<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>{{__('PO Number')}}</th>
                                <th>{{__('No Kontrak')}}</th>
                                <th>{{__('ID_SJB')}}</th>
                                <th>{{__('No. Coil')}}</th>
                                <th>{{__('SPEC')}}</th>
                                <th>{{__('Dimensions')}}</th>
                                <th>{{__('Actual Thick')}}</th>
                                <th>{{__('Goods Location')}}</th>
                                <th>{{__('Quantity')}}</th>
                                <th>{{__('Weigth')}}(KG)</th>
                                <th>{{__('Description')}}</th>
                                <th>{{__('Certificate')}}</th>
                                <th>{{__('Approval')}}</th>
                                <th>{{__('Status')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($gr_det as $item)
                            <tr>
                                <td>{{ $item->po->po_number }}</td>
                                <td>{{ $item->no_kontrak }}</td>
                                <td>{{ $item->sku_number }}</td>
                                <td>{{ $item->no_coil }}</td>
                                <td>{{ $item->product_name }}</td>
                                <td>{{ $item->dimensions }}</td>
                                <td>{{ $item->actual_thick }}</td>
                                <td>{{ $item->goods_location }}</td>
                                <td>{{ $item->qty }}</td>
                                <td>{{ $item->weight }}</td>
                                <td>{{ $item->description }}</td>
                                <td>
                                    @if($item->upload_certificate)
                                    <a href="{{ Storage::url('uploads/goods_receipt_certificate/' . $item->upload_certificate) }}">{{ __('See certificate') }}</a>
                                    @endif
                                </td>
                                <td>{{ $item->approval }}</td>
                                <td>{{ $item->status }}</td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
