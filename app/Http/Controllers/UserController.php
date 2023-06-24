<?php

namespace App\Http\Controllers;

use App\Http\Repositories\UserRepositories;
use App\Http\Requests\UserFilterRequest;
use App\Http\Services\ImportServices;
use App\Http\Services\UserServices;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(UserFilterRequest $request)
    {
      return   (new UserServices())->filter($request);

    }


    public function import()
    {
        (new ImportServices())->import();
    }

}
