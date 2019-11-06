<?php

namespace App\Transformers;

use App\Models\Commodity;
use League\Fractal\TransformerAbstract;

class CommodityTransformer extends TransformerAbstract
{
    public function transform(Commodity $commodity)
    {
        return [
            'id' => $commodity->id,
            'name' => $commodity->name,
            'price' => $commodity->price,
            'photo' => $commodity->photo,
            'description' => $commodity->description,
        ];
    }
}
