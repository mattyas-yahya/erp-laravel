<?php

namespace App\Domains\Production;

class ProductionScheduleStatusValue
{
    const STATUS_SH = 'SH';
    const STATUS_SL = 'SL';
    const STATUS_SL_AND_SH = 'SL+SH';
    const STATUS_PACKING = 'Packing';

    public static function join() {
        return implode(',', [
            ProductionScheduleStatusValue::STATUS_SH,
            ProductionScheduleStatusValue::STATUS_SL,
            ProductionScheduleStatusValue::STATUS_SL_AND_SH,
            ProductionScheduleStatusValue::STATUS_PACKING,
        ]);
    }
}
