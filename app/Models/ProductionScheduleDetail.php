<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Domains\Production\ProductionScheduleConst;
use App\Traits\Eloquent\EloquentSetCreatedBy;

class ProductionScheduleDetail extends Model
{
    use HasFactory, EloquentSetCreatedBy;

    protected $fillable = [
        'production_schedule_id',
        'dimension_t',
        'dimension_l',
        'dimension_p',
        'pieces',
        'pack',
        'production_total',
        'description',
        'type',
        'created_by',
    ];

    /**
     * Calculate Production Total for SH
     * Formula : (T x L x P x 7,85 / 1000000) x Total Pcs
     *
     * @return void
     */
    public function calculateShStatusProductionTotal()
    {
        return round(
            (
                $this->dimension_t
                * $this->dimension_l
                * $this->dimension_p
                * ProductionScheduleConst::CONST_SH_FORMULA_MULTIPLIER
                / ProductionScheduleConst::CONST_SH_FORMULA_DIVIDER
            ) * $this->pieces
        );
    }
}
