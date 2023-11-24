<div class="p-3 card">
    <ul class="nav nav-pills nav-fill scrollable" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pills-user-tab-all" data-bs-toggle="pill"
                data-bs-target="#tab-machine-all" type="button">
                All
            </button>
        </li>
        @foreach ($machines as $machine)
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-user-tab-{{ $machine->id }}" data-bs-toggle="pill"
                    data-bs-target="#tab-machine-{{ $machine->id }}" type="button">
                    {{ $machine->name }}
                </button>
            </li>
        @endforeach
    </ul>
</div>
