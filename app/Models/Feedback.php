<?php

namespace App\Models;

class Feedback extends Model
{
    /**
     * 定义用户与反馈的对应关系
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
