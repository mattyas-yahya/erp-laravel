<?php

namespace App\Domains\Helpers;

use Carbon\Carbon;

class DateHelper
{
    public static function months()
    {
        return [
            __('January'),
            __('February'),
            __('March'),
            __('April'),
            __('May'),
            __('June'),
            __('July'),
            __('August'),
            __('September'),
            __('October'),
            __('November'),
            __('December')
        ];
    }

    public static function monthsOption()
    {
        foreach(self::months() as $key => $month) {
            $months[str_pad($key + 1, 2, '0', STR_PAD_LEFT)] = $month;
        }

        return $months;
    }

    public static function years()
    {
        $startingYear = date('Y', strtotime('-5 year'));
        $endingYear = date('Y');

        return range($startingYear, $endingYear);
    }

    public static function yearsOption()
    {
        foreach(self::years() as $year) {
            $years[$year] = $year;
        }

        return $years;
    }

    public static function getMonthWeeks($date = null)
    {
        if (empty($date)) {
            $date = Carbon::now();
        }

        $date = $date->copy()->firstOfMonth(Carbon::MONDAY)->startOfDay();
        $eom = $date->copy()->endOfMonth(Carbon::MONDAY)->startOfDay();

        $dates = collect([]);

        for ($i = 1; $date->lte($eom); $i++) {
            $dates->push((object) [
                'start' => clone $date->startOfWeek(Carbon::MONDAY),
                'end' => clone $date->endOfWeek(Carbon::SUNDAY)
            ]);
            $date->addDays(1);
        }

        return $dates;
    }

}


