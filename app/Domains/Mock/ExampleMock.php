<?php

namespace App\Domains\Mock;

class ExampleMock
{
    public static function all() {
        return collect([
            (object) [
                'id' => 1,
                'name' => 'Name',
            ],
        ]);
    }
}
