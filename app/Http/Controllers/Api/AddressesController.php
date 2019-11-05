<?php

namespace App\Http\Controllers\Api;

use App\Models\Address;
use Illuminate\Http\Request;
use App\Transformers\AddressTransformer;
use App\Http\Requests\Api\AddressRequest;

class AddressesController extends Controller
{
    /**
     * 返回当前用户全部送货地址
     *
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user('api');
        $addresses = $user->addresses;

        $this->authorize('show', $addresses->first());

        return $this->response->collection($addresses, new AddressTransformer());
    }

    /**
     * 获取某个收货地址信息
     *
     * @param Address $address
     * @return \Dingo\Api\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Address $address)
    {
        $this->authorize('show', $address);

        return $this->response->item($address, new AddressTransformer());
    }

    /**
     * 创建新的收货地址
     *
     * @param AddressRequest $request
     * @return \Dingo\Api\Http\Response
     */
    public function store(AddressRequest $request)
    {
        $attributes = $request->all();
        $attributes['user_id'] = $request->user()->id;

        Address::create($attributes);

        return $this->response->created();
    }

    /**
     * 修改收货信息
     *
     * @param Address $address
     * @param AddressRequest $request
     * @return \Dingo\Api\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Address $address, AddressRequest $request)
    {
        $this->authorize('update', $address);

        $address->update($request->all());
        return $this->response->noContent()->setStatusCode(200);
    }

    /**
     * 删除某个收货信息
     *
     * @param Address $address
     * @return \Dingo\Api\Http\Response
     * @throws \Exception
     */
    public function destroy(Address $address)
    {
        $this->authorize('delete', $address);

        $address->delete();
        return $this->response->noContent()->setStatusCode(200);
    }
}
