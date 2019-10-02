<?php

$api = app('Dingo\Api\Routing\Router');

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Api',
    'middleware' => ['binds']
], function ($api) {
    $api->group([
        'middleware' => 'api.throttle',
        'limit' => config('api.rate_limits.sign.limit'),
        'expires' => config('api.rate_limits.sign.expires')
    ], function ($api) {
        $api->put('authorizations/current', 'AuthorizationsController@refresh')
            ->name('api.authorizations.refresh');

        $api->post('weapp/authorizations', 'AuthorizationsController@socialStore')
            ->name('api.weapp.authorizations.store');
    });
});
