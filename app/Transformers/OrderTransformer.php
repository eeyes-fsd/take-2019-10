<?php


namespace App\Transformers;


use App\Models\Order;
use League\Fractal\TransformerAbstract;

class OrderTransformer extends TransformerAbstract
{
    private $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function transform(Order $order)
    {
        switch ($this->type)
        {
            case 'item':
                return [
                    'id' => $order->id,
                    'no' => $order->no,
                    'status' => $order->status,
                    'details' => $order->details,
                    'address' => $order->address,
                    'created_at'=> $order->created_at->toDateString(),
                    'updated_at' => $order->updated_at->toDateString(),
                ];

            case 'collection':
                return [
                    'id' => $order->id,
                    'status' => $order->status,
                    'created_at'=> $order->created_at->toDateString(),
                ];

            default:
                return [];
        }
    }
}
