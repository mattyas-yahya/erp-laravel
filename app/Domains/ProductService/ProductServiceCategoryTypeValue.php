<?php

namespace App\Domains\ProductService;

class ProductServiceCategoryTypeValue
{
    const TYPE_PRODUCT_AND_SERVICE = 'Product & Service';
    const TYPE_INCOME = 'Income';
    const TYPE_EXPENSE = 'Expense';

    public static function findByIndex($index = null) {
        if (empty($index)) {
            return '';
        }

        switch ($index) {
            case 0:
                return self::TYPE_PRODUCT_AND_SERVICE;
                break;
            case 1:
                return self::TYPE_INCOME;
                break;
            case 2:
                return self::TYPE_EXPENSE;
                break;
            default:
                return '';
                break;
        }
    }

    public static function getIndex($type = null) {
        if (empty($type)) {
            return null;
        }

        switch ($type) {
            case self::TYPE_PRODUCT_AND_SERVICE:
                return 0;
                break;
            case self::TYPE_INCOME:
                return 1;
                break;
            case self::TYPE_EXPENSE:
                return 2;
                break;
            default:
                return null;
                break;
        }
    }
}
