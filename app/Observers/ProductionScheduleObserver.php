<?php

namespace App\Observers;

use App\Models\ProductionSchedule;

class ProductionScheduleObserver
{
    /**
     * Handle the ProductionSchedule "created" event.
     *
     * @param  \App\Models\ProductionSchedule  $productionSchedule
     * @return void
     */
    public function created(ProductionSchedule $productionSchedule)
    {
        //
    }

    /**
     * Handle the ProductionSchedule "updated" event.
     *
     * @param  \App\Models\ProductionSchedule  $productionSchedule
     * @return void
     */
    public function updated(ProductionSchedule $productionSchedule)
    {
        //
    }

    /**
     * Handle the ProductionSchedule "deleted" event.
     *
     * @param  \App\Models\ProductionSchedule  $productionSchedule
     * @return void
     */
    public function deleted(ProductionSchedule $productionSchedule)
    {
        //
    }

    /**
     * Handle the ProductionSchedule "restored" event.
     *
     * @param  \App\Models\ProductionSchedule  $productionSchedule
     * @return void
     */
    public function restored(ProductionSchedule $productionSchedule)
    {
        //
    }

    /**
     * Handle the ProductionSchedule "force deleted" event.
     *
     * @param  \App\Models\ProductionSchedule  $productionSchedule
     * @return void
     */
    public function forceDeleted(ProductionSchedule $productionSchedule)
    {
        //
    }
}
