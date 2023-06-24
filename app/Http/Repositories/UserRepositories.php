<?php

namespace App\Http\Repositories;

use App\Http\Resources\Transaction;
use App\Http\Resources\TransactionProviderX;
use App\Http\Resources\TransactionProviderY;
use App\Models\User;

class UserRepositories
{

    public function user($request)
    {
        $users = User::query();

        // Filter by payment provider
        if ($request->has('provider')) {
            $provider = $request->input('provider');
            if($provider=="DataProviderX"){
                $users->wherehas('dataProviderX')->with('dataProviderX');
            }
            if($provider=="DataProviderY"){
                $users->wherehas('dataProviderY')->with('dataProviderY');
            }
        }else{
            $users->with(['dataProviderX', 'dataProviderY']) ;
        }

        // Filter by status code
        if ($request->has('statusCode')) {
            $statusCode = $this->getStatusCode($request->input('statusCode'));

            $users->whereHas('dataProviderX', function ($query) use ($statusCode) {
                $query->wherein('statusCode',$statusCode );
            })->orWhereHas('dataProviderY', function ($query) use ($statusCode) {
                $query->wherein('status', $statusCode);
            });
        }

        // Filter by amount range
        if ($request->has('balanceMin') && $request->has('balanceMax')) {
            $balanceMin = $request->input('balanceMin');
            $balanceMax = $request->input('balanceMax');
            $users->whereHas('dataProviderX', function ($query) use ($balanceMin, $balanceMax) {
                $query->whereBetween('parentAmount', [$balanceMin, $balanceMax]);
            })->orWhereHas('dataProviderY', function ($query) use ($balanceMin, $balanceMax) {
                $query->whereBetween('balance', [$balanceMin, $balanceMax]);
            });
        }

        // Filter by currency
        if ($request->has('currency')) {
            $currency = $request->input('currency');
            $users->whereHas('dataProviderX', function ($query) use ($currency) {
                $query->where('currency', $currency);
            })->orWhereHas('dataProviderY', function ($query) use ($currency) {
                $query->where('currency', $currency);
            });
        }




        return $users->get();
     }


    private function getStatusCode($status)
    {
        switch ($status) {
            case 'authorised':
                return [1,100];
            case 'decline':
                return [2,200];
            case 'refunded':
                return [3,300];
            default:
                return null;
        }
    }

    private function getStatusName($statusCode)
    {
        switch ($statusCode) {
            case 1:
                return 'authorised';
            case 2:
                return 'decline';
            case 3:
                return 'refunded';
            case 100:
                return 'authorised';
            case 200:
                return 'decline';
            case 300:
                return 'refunded';
            default:
                return null;
        }
    }
}
