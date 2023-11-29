<div class="card" style="top:30px">
    <div class="list-group list-group-flush">
        <a href="{{ route('tms.vehicle.show.detail.files', ['id' => $vehicle->id]) }}"
            class="list-group-item list-group-item-action border-0 {{ Request::route()->getName() == 'tms.vehicle.show.detail.files' ? ' active' : '' }}">Berkas
        </a>
    </div>
</div>
