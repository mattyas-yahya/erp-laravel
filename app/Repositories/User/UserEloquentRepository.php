<?php

namespace App\Repositories\User;

use App\Models\User;

class UserEloquentRepository
{
    public function findCreator($userId)
    {
        $creator = User::where('id', $userId)
            ->first()
            ?->created_by;

        return $creator;
    }
}
