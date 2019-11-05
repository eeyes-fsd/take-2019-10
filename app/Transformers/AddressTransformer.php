<?php

namespace App\Transformers;

use App\Models\Address;
use League\Fractal\TransformerAbstract;

class AddressTransformer extends TransformerAbstract
{
    public function transform(Address $address)
    {
        return [
            'id' => $address->id,
            'name' => $address->name,
            'phone' => $address->phone,
            'details' => $address->details,
        ];
    }
}
