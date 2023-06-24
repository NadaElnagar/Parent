<?php

namespace App\Http\Repositories;

use App\Models\DataProviderX;
use App\Models\DataProviderY;
use App\Models\User;
use DateTime;

class ImportRepositories
{
    public function importX($data)
    {

        $this->addOrGetUserID($data['parentEmail'], 'provider_x');
        DataProviderX::updateOrCreate(['parentAmount' => $data['parentAmount'],
            'currency' => $data['Currency'],
            'parentEmail' => $data['parentEmail'],
            'statusCode' => $data['statusCode'],
            'registerationDate' => $data['registerationDate'],
            'parentIdentification' => $data['parentIdentification'],
        ]);


    }

    private function addOrGetUserID($email, $provider)
    {
        return User::updateOrCreate(['email' => $email], ['name' => $provider]);
    }

    public function importY($data)
    {
        $date = str_replace('/', '-', $data['created_at']);
        $newDate = date('Y-m-d', strtotime($date));
        $this->addOrGetUserID($data['email'], 'provider_y');
        DataProviderY::updateOrCreate(['balance' => $data['balance'],
            'currency' => $data['currency'],
            'email' => $data['email'],
            'status' => $data['status'],
            'created_at' => $newDate,
            'id' => $data['id'],
        ]);

    }
}
