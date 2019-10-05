<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel
{
    /**
     * 定义保护的字段
     * 这些字段不允许批量赋值
     *
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];
}
