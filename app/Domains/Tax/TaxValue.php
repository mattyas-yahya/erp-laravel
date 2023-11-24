<?php

namespace App\Domains\Tax;

class TaxValue
{
    const TAX_PPN_NAME = 'PPN';
    const TAX_PPN_RATE = '11%';
    const TAX_PPN_VALUE = 11 / 100;
    const TAX_PPH_NAME = 'PPh';
    const TAX_PPH_RATE = '0.3%';
    const TAX_PPH_VALUE = 0.3 / 100;

    public static function get() {
        return
            (object) [
                'tax_ppn' => (object) [
                    'name' => self::TAX_PPN_NAME,
                    'rate' => self::TAX_PPN_RATE,
                    'value' => self::TAX_PPN_VALUE,
                ],
                'tax_pph' => (object) [
                    'name' => self::TAX_PPH_NAME,
                    'rate' => self::TAX_PPH_RATE,
                    'value' => self::TAX_PPH_VALUE,
                ]
            ];
    }
}
