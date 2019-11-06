<?php

namespace App\Models;


/**
 * Class Unit
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Database\Eloquent\Collection $addresses
 * @property \Illuminate\Database\Eloquent\Collection $users
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Unit extends Model
{
    /**
     * 定义区块与地址的关系
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function addresses()
    {
        return $this->hasMany('App\Models\Address', 'unit_id');
    }

    /**
     * 定义区块与用户关系
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany('App\Models\User', 'unit_id');
    }
}
