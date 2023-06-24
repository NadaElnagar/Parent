<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Transaction extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

            $provider = request()->input('provider');

            if($provider == "DataProviderX"){
                return TransactionProviderX::collection($this->dataProviderX);

            }
            if($provider=="DataProviderY"){
                return
                       TransactionProviderY::collection($this->dataProviderY);
            }else{
                return  [
                   'provider_x'=> TransactionProviderX::collection($this->dataProviderX),
                    'provider_y'=>  TransactionProviderY::collection($this->dataProviderY)
                ];

            }



    }
}
