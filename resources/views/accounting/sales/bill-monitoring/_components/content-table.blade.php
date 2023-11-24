<div class="tab-pane fade show active">
    <div class="table-responsive">
        <table class="table datatable">
            <thead>
                @include('accounting.sales.bill-monitoring._components.header-content-table')
            </thead>

            <tbody>
                @each('accounting.sales.bill-monitoring._components.body-content-table', $invoicePayments, 'item', 'accounting.sales.bill-monitoring._components.body-empty-content-table')
            </tbody>
        </table>
    </div>
</div>
