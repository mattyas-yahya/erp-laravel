<?php

namespace App\Domains\Helpers;

class ModelHelper
{
    public static function getLastId($model, $idField)
    {
        $lastRow = $model::orderBy($idField, 'desc')->first();
        $lastId = $lastRow ? $lastRow->id + 1 : 1;

        return $lastId;
    }

    public static function getLastNumberCode($model, $numberCodeColumn, $numberCode): string | bool
    {
        $numberCodeFormat = NumberCodeHelper::getNumberCodeFormat($numberCode);

        $lastNumberCode = $model::where($numberCodeColumn, 'like', "{$numberCodeFormat}%")
                        ->orderBy($numberCodeColumn, 'desc')
                        ->select($numberCodeColumn)
                        ->first()
                        ?->$numberCodeColumn;

        return $lastNumberCode ?: false;
    }
}
