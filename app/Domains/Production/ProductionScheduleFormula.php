<?php

namespace App\Domains\Production;

class ProductionScheduleFormula
{
    const FORMULA_PRODUCTION_SH = 't * l * p * 7.85 / 1000000 * pieces';
    const FORMULA_PRODUCTION_SL = 'l / 1200 * quantity';
}
