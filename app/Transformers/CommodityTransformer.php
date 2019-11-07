<?php

namespace App\Transformers;

use App\Models\Commodity;
use League\Fractal\TransformerAbstract;

class CommodityTransformer extends TransformerAbstract
{
    private $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function transform(Commodity $commodity)
    {
        switch ($this->type){
            case 'collection':
                return [
                    'id' => $commodity->id,
                    'name' => $commodity->name,
                    'price' => $commodity->price,
                    'photo' => $commodity->photo,
                ];

            case 'item':
                return [
                    'id' => $commodity->id,
                    'name' => $commodity->name,
                    'price' => $commodity->price,
                    'photo' => $commodity->photo,
                    'description' => $commodity->description,
                ];

            default:
                return [
                    'id' => $commodity->id,
                    'name' => $commodity->name,
                ];
        }
    }
}
