<?php

namespace App\Domains\Tms;

use App\Domains\Helpers\CompanyProfile;
use App\Domains\Helpers\ModelHelper;
use App\Domains\Helpers\NumberCodeHelper;
use App\Models\Tms\Assignment as TmsAssignment;

class DeliveryWaybillNumberCode
{
    const DELIVERY_WAYBILL_CODE = 'SJP';
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

        $numberCode .= self::DELIVERY_WAYBILL_CODE;
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
        $deliveryWaybillNumberCode = ModelHelper::getLastNumberCode(
            TmsAssignment::class,
            'delivery_order_number',
            self::formatExample()
        );
        $newDeliveryWaybillNumberCodeSequence = NumberCodeHelper::nextSequence($deliveryWaybillNumberCode);

        return self::generate($newDeliveryWaybillNumberCodeSequence);
    }
}
