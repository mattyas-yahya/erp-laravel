<table class="table table-hover mb-0">
    <thead>
        @include('accounting.petty-cash.report._components.header-content-table')
    </thead>

    <tbody>
        @forelse($pettyCashes->filter(function ($item) use ($weeks) {
                return Carbon\Carbon::parse($item->first()->petty_cash_date)
                    ->between($weeks->start->format('Y-m-d'), $weeks->end->format('Y-m-d'));
            }) as $item)
            @include('accounting.petty-cash.report._components.body-content-table')
        @empty
            @include('accounting.petty-cash.report._components.body-empty-content-table')
        @endforelse
    </tbody>
</table>

