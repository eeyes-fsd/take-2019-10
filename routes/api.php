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
    'middleware' => 'bindings'
], function ($api) {
    $api->group([
        'middleware' => 'api.throttle',
        'limit' => config('api.rate_limits.sign.limit'),
        'expires' => config('api.rate_limits.sign.expires')
    ], function ($api) {
        $api->put('authorizations/current', 'AuthorizationsController@update')
            ->name('api.authorizations.update');

        $api->post('weapp/authorizations', 'AuthorizationsController@socialStore')
            ->name('api.weapp.authorizations.store');
    });

    $api->group([
        'middleware' => 'api.throttle',
        'limit' => config('api.rate_limits.access.limit'),
        'expires' => config('api.rate_limits.access.expires')
    ], function ($api) {
        /** 无需登录认证的接口 */


        $api->group([
            'middleware' => 'api.auth'
        ], function ($api) {
            /** 需要登录认证的API */

            $api->get('addresses', 'AddressesController@index')
                ->name('api.addresses.index');
            $api->get('addresses/{address}', 'AddressesController@show')
                ->name('api.addresses.show');
            $api->post('addresses', 'AddressesController@store')
                ->name('api.addresses.store');
            $api->put('addresses/{address}', 'AddressesController@update')
                ->name('api.addresses.update');
            $api->delete('addresses/{address}', 'AddressesController@destroy')
                ->name('api.addresses.destroy');

            $api->get('user', 'UsersController@show')
                ->name('api.user.show');
            $api->put('user', 'UsersController@update')
                ->name('api.user.update');
            $api->delete('user', 'UsersController@destroy')
                ->name('api.user.destroy');
        });
    });
});
