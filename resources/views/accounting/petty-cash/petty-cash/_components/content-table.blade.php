<div class="table-responsive">
    <table class="table datatable">
        <thead>
            @include('accounting.petty-cash.petty-cash._components.header-content-table')
        </thead>

        <tbody>
            @each('accounting.petty-cash.petty-cash._components.body-content-table', $pettyCashes, 'item', 'accounting.petty-cash.petty-cash._components.body-empty-content-table')
        </tbody>
    </table>
</div>
