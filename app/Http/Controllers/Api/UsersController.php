<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Transformers\UserTransformer;
use App\Http\Requests\Api\UserRequest;

class UsersController extends Controller
{
    /**
     * 获取当前用户信息
     *
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function show(Request $request)
    {
        $user = $request->user();

        return $this->response->item($user, new UserTransformer());
    }

    /**
     * 更新用户信息
     *
     * @param UserRequest $request
     * @return \Dingo\Api\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UserRequest $request)
    {
        $user = $request->user();

        $this->authorize('update', $user);

        $attributes = $request->all([
            'name',
            'phone',
            'password'
        ]);

        $user->update($attributes);

        return $this->response->noContent()->setStatusCode(200);
    }

    /**
     * 删除用户
     *
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Request $request)
    {
        $user = $request->user();

        $this->authorize('update', $user);

        $user->delete();

        return $this->response->noContent()->setStatusCode(200);
    }
}
