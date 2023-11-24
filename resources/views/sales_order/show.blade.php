<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>{{__('SO Number')}}</th>
                                <th>{{__('ID_SJB')}}</th>
                                <th>{{__('No. Coil')}}</th>
                                <th>{{__('SPEC')}}</th>
                                <th>{{__('Dimensions')}}</th>
                                <th>{{__('Sale Price')}}</th>
                                <th>{{__('Qty')}}</th>
                                <th>{{__('Unit')}}</th>
                                <th>{{__('Production')}}</th>
                                <th>{{__('TAX')}}</th>
                                <th>{{__('Discount')}}</th>
                                <th>{{__('Total')}}</th>
                                <th>{{__('Description')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($so_det as $item)
                            <tr>
                                <td>{{ $item->so_number }}</td>
                                <td>{{ (!empty($item->gr_from_so)?$item->gr_from_so->sku_number:'') }}</td>
                                <td>{{ (!empty($item->gr_from_so)?$item->gr_from_so->no_coil:'') }}</td>
                                <td>{{ $item->gr_from_so->product_name }}</td>
                                <td>{{ $item->gr_from_so->dimensions }}</td>
                                <td>{{ \Auth::user()->priceFormat($item->sale_price) }}</td>
                                <td>{{ $item->qty }}</td>
                                <td>{{ $item->unit }}</td>
                                <td>{{ $item->production }}</td>
                                <td>
                                    @if(!empty($item->gr_from_so->tax_id))
                                            @php
                                                $taxes=\App\Models\Utility::tax($item->gr_from_so->tax_id);
                                            @endphp

                                            @foreach($taxes as $tax)
                                                <span class="">{{$tax->name .' ('.$tax->rate .'%)'}}</span><br>

                                            @endforeach
                                        @else
                                            -
                                        @endif
                                </td>
                                <td>{{ \Auth::user()->priceFormat($item->discount) }}</td>
                                <td>{{ \Auth::user()->priceFormat(($item->qty*$item->sale_price)-$item->discount) }}</td>
                                <td>{{ $item->description }}</td>                            
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>