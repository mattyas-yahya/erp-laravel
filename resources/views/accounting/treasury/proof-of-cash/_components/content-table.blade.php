<div class="table-responsive">
    <table class="table datatable">
        <thead>
            @include('accounting.treasury.proof-of-cash._components.header-content-table')
        </thead>

        <tbody>
            @each('accounting.treasury.proof-of-cash._components.invoice-body-content-table', $invoicePayments, 'item')
            @each('accounting.treasury.proof-of-cash._components.bill-body-content-table', $billPayments, 'item')
        </tbody>
    </table>
</div>
