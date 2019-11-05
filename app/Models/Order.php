<?php

namespace App\Models;

/**
 * Class Order
 * @package App\Models
 *
 * @property int $id
 * @property int $user_id
 * @property int $address_id
 * @property array $details
 * @property int $status
 * @property int $fee
 * @property string $no
 * @property User $user
 * @property Address $address
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Order extends Model
{
    /**
     * 定义订单与用户关系
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    /**
     * 定义订单送货地址
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function address()
    {
        return $this->belongsTo('App\Models\Address', 'address_id');
    }

    /**
     * @param string $details
     * @return mixed
     */
    public function getDetailsAttribute(string $details)
    {
        return unserialize($details);
    }

    /**
     * @param array $details
     * @return string
     */
    public function setDetailsAttribute(array $details)
    {
        return serialize($details);
    }
}
