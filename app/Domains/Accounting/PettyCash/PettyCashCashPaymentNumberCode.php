<?php

namespace App\Domains\Accounting\PettyCash;

use App\Domains\Helpers\CompanyProfile;
use App\Domains\Helpers\ModelHelper;
use App\Domains\Helpers\NumberCodeHelper;
use App\Models\PettyCash;

class PettyCashCashPaymentNumberCode
{
    const CASH_PAYMENT_CODE = 'CP';
    const SEQUENCE_LENGTH = 3;

    /**
     * Generate number code
     *
     * @param string $newSequence
     * @return string
     */
    public static function generate($newSequence): string
    {
        $codeSequence = '';

        $codeSequence .= self::CASH_PAYMENT_CODE;
        $codeSequence .= '/' . CompanyProfile::get();
        $codeSequence .= '/' . date("y/m");
        $codeSequence .= '/' . str_pad($newSequence, self::SEQUENCE_LENGTH, '0', STR_PAD_LEFT);

        return $codeSequence;
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
        $cashPaymentNumberCode = ModelHelper::getLastNumberCode(PettyCash::class, 'petty_cash_number', self::formatExample());
        $newCashPaymentNumberCodeSequence = NumberCodeHelper::nextSequence($cashPaymentNumberCode);

        return self::generate($newCashPaymentNumberCodeSequence);
    }
}
