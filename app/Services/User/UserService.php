<?php

namespace App\Services\User;

use App\Repositories\User\UserEloquentRepository;

class UserService
{
    protected $userRepo;

    public function __construct(
        UserEloquentRepository $userRepo,
    )
    {
        $this->userRepo = $userRepo;
    }

    public function findCreator($userId)
    {
        return $this->userRepo->findCreator($userId);
    }
}
