<?php

namespace App\Models;

/**
 * Class Address
 * @package App\Models
 *
 * @property int $id
 * @property int $user_id
 * @property int $unit_id
 * @property string $name
 * @property string $phone
 * @property string $details
 * @property string $gender
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \App\Models\User $user
 * @property \App\Models\Unit $unit
 */
class Address extends Model
{
    /**
     * 定义收货地址与用户关系
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    /**
     * 定义收货地址与区块关系
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unit()
    {
        return $this->belongsTo('App\Models\Unit', 'unit_id');
    }
}
