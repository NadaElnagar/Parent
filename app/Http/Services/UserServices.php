<?php

namespace App\Http\Services;

use App\Http\Repositories\UserRepositories;
use App\Http\Resources\Transaction;
use App\Http\Resources\TransactionProviderX;

class UserServices
{
    public function __construct()
    {
        $this->user = new UserRepositories();
    }

    public function filter($request)
    {
       $data =  $this->user->user($request);
        return Transaction::collection($data);
    }
}
