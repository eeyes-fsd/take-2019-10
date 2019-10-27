<?php

use Illuminate\Support\Arr;

/*
|--------------------------------------------------------------------------
| Custom Helpers | 自定义助手函数
|--------------------------------------------------------------------------
|
| Add your custom helpers functions here to call them everywhere in the
| application.
|
| 将自定义助手函数添加在这个文件中，即可在应用各处使用这些函数。
|
*/

/**
 * @param array $response
 *
 * @return bool
 */
function verify_response(array $response)
{
    $sign = $response['sign'];
    unset($response['sign']);

    Arr::sort($response);
    $param = http_build_query($response);

    return $sign === md5($param);
}
