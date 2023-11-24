<div class="table-responsive">
    <table class="table datatable">
        <thead>
            @include('accounting.petty-cash.cash-in-hand._components.header-content-table')
        </thead>

        <tbody>
            @each('accounting.petty-cash.cash-in-hand._components.body-content-table', $cashInHands, 'item', 'accounting.petty-cash.cash-in-hand._components.body-empty-content-table')
        </tbody>
    </table>
</div>
