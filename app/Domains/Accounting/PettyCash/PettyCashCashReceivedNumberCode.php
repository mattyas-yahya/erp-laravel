<?php

namespace App\Domains\Accounting\PettyCash;

use App\Domains\Helpers\CompanyProfile;
use App\Domains\Helpers\ModelHelper;
use App\Domains\Helpers\NumberCodeHelper;
use App\Models\PettyCash;

class PettyCashCashReceivedNumberCode
{
    const CASH_RECEIVED_CODE = 'CR';
    const SEQUENCE_LENGTH = 3;

    /**
     *
     *
     * @param string $newSequence
     * @return string
     */
    public static function generate($newSequence): string
    {
        $numberCode = '';

        $numberCode .= self::CASH_RECEIVED_CODE;
        $numberCode .= '/' . CompanyProfile::get();
        $numberCode .= '/' . date("y/m");
        $numberCode .= '/' . str_pad($newSequence, self::SEQUENCE_LENGTH, '0', STR_PAD_LEFT);

        return $numberCode;
    }

    /**
     * Generate example number code
     *
     * @return string
     */
    public static function formatExample(): string
    {
        return self::generate(1);
    }

    /**
     * New generate number code
     *
     * @param string $newSequence
     * @return string
     */
    public static function create(): string
    {
        $cashReceivedNumberCode = ModelHelper::getLastNumberCode(PettyCash::class, 'petty_cash_number', self::formatExample());
        $newCashReceivedNumberCodeSequence = NumberCodeHelper::nextSequence($cashReceivedNumberCode);

        return self::generate($newCashReceivedNumberCodeSequence);
    }
}
