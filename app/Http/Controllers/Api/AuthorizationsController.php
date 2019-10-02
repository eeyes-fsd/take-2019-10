<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;

class AuthorizationsController extends Controller
{
    /**
     * 通过 Code 获取 Open ID 并登录
     *
     * @param Request $request
     * @return mixed|void
     */
    public function socialStore(Request $request)
    {
        $code = $request->code;

        $miniProgram = \EasyWeChat::miniProgram();

        $response = $miniProgram->auth()->session($code);

        if (isset($data['errcode'])) {
            return $this->response->errorUnauthorized('code 错误');
        }

        if (!$user = User::where('weixin_openid', $response['openid'])->first()) {
            $user = User::create([
                'weapp_openid' => $response['openid'],
                'weixin_session_key' => $response['session_key'],
            ]);
        }

        $token = Auth::guard('api')->fromUser($user);
        return $this->responseWithToken($token);
    }

    /**
     * 刷新认证 Token
     *
     * @return mixed
     */
    public function update()
    {
        $token = Auth::guard('api')->refresh();
        return $this->responseWithToken($token);
    }

    /**
     * 返回 Access Token 与相关信息
     *
     * @param $token
     * @return mixed
     */
    protected function responseWithToken($token)
    {
        return $this->response->array([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60
        ]);
    }
}
