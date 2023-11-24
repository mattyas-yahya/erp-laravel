<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>Job Order</th>
                                    <th>No. Coil</th>
                                    <th>Spec</th>
                                    <th>T</th>
                                    <th>L</th>
                                    <th>P</th>
                                    <th>Total Pcs</th>
                                    <th>Total Produksi (kg mill)</th>
                                    <th>Pack</th>
                                    <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($scheduleDetails as $item)
                            <tr>
                                <td>{{ $schedule->job_order_number }}</td>
                                <td>{{ $schedule->salesOrderLine->no_coil }}</td>
                                <td>{{ $schedule->salesOrderLine->gr_from_so->name }}</td>
                                <td>{{ $item->dimension_t }}</td>
                                <td>{{ $item->dimension_l }}</td>
                                <td>{{ $item->dimension_p }}</td>
                                <td>{{ $item->pieces }}</td>
                                <td>{{ $item->production_total }}</td>
                                <td>{{ $item->pack }}</td>
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
