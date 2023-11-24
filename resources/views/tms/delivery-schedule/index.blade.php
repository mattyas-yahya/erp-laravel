@extends('layouts.admin')
@section('page-title')
    {{ __('TMS Jadwal Kirim') }}
@endsection

@section('breadcrumb')
    @include ('partials.admin.breadcrumbs', [
        'item' => __('TMS'),
    ])
@endsection

@push('css-page')
    <link href="
    https://cdn.jsdelivr.net/npm/jquery-sked-tape@2.5.0/dist/jquery.skedTape.min.css
    " rel="stylesheet">
@endpush

@section('action-btn')
    {{-- <div class="float-end">
        <a href="#" title="{{ __('Create') }}" data-title="Tambah Jadwal Kirim"
            data-url="{{ route('tms.assignment.create') }}" data-size="lg" data-bs-toggle="tooltip" data-ajax-popup="true"
            class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i>
        </a>
    </div> --}}
@endsection

@section('content')
    {{-- @include('production.schedule._components.filter') --}}

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="mb-4">
                        <div class="mb-2" id="sked1"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-page')
    <script src="https://cdn.jsdelivr.net/npm/jquery-sked-tape@2.5.0/dist/jquery.skedTape.min.js"></script>

    <script>
        // --------------------------- Data --------------------------------
        var locations = {!! $vehicles->map(function ($item) {
            return (object) [
                'id' => $item->id,
                'license_plate' => $item->license_plate,
                'tzOffset' => 7 * 60,
            ];
        })->toJson() !!};

        // var events = [
        //     {
        //         name: 'Meeting 1',
        //         location: '1',
        //         start: new Date('2023-11-02'),
        //         end: new Date('2023-11-03')
        //     },
        // ];

        var events = {!! $assignments->whereNotNull('ended_at')->map(function ($item) {
            return (object) [
                'name' => $item->started_at .
                    " - " .
                    $item->ended_at .
                    " | " .
                    $item->details->map(function ($detail) {
                        return $detail->salesOrderDetail->so_number . " ({$detail->customer->name})";
                    })->join(', '),
                'location' => $item->tms_vehicle_id ?? '',
                'start' => $item->started_at,
                'end' => $item->ended_at,
            ];
        })->toJson() !!};

        // -------------------------- Main ------------------------------
        var $sked1 = $('#sked1').skedTape({
            caption: 'Vehicle',
            start: new Date('2023-11-01'),
            end: new Date('2023-11-30'),
            scrollWithYWheel: true,
            locations: locations.slice(),
            events: events.slice(),
            formatters: {
                date: function (date) {
                    return $.fn.skedTape.format.date(date, 'l', '.');
                },
            },
            postRenderLocation: function($el, location, canAdd) {
                this.constructor.prototype.postRenderLocation($el, location, canAdd);
                $el.prepend('<i class="ti ti-car"></i> ');
                $el.append(' - ' + (locations.find(item => item.id == location.id).license_plate ?? '(plat nomor kosong)'));
            }
        });
        $sked1.on('event:dragEnded.skedtape', function(e) {
            console.log(e.detail.event);
        });
        $sked1.on('event:click.skedtape', function(e) {
            $sked1.skedTape('removeEvent', e.detail.event.id);
        });
        $sked1.on('timeline:click.skedtape', function(e, api) {
            try {
                $sked1.skedTape('startAdding', {
                    name: 'New meeting',
                    duration: 60 * 60 * 1000
                });
            }
            catch (e) {
                if (e.name !== 'SkedTape.CollisionError') throw e;
                //alert('Already exists');
            }
        });
    </script>
@endpush
