<?php

namespace App\Domains\Helpers;

class CompanyProfile
{
    const COMPANY_NAME = 'PT. Sampoerna Jaya Baja';
    const COMPANY_BRANCH = 'Surabaya';
    const COMPANY_CODE = 'SJB';
    const COMPANY_BRANCH_CODE = 'S';

    public static function get()
    {
        return self::COMPANY_CODE . self::COMPANY_BRANCH_CODE;
    }
}
