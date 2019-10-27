<?php

namespace App\Handlers;

use App\Models\Order;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use App\Exceptions\ResponseUnverifiedException;

class PrePayHandler
{
    /**
     * @param Order $order
     * @param User $user
     * @return bool|array
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws ResponseUnverifiedException;
     */
    public function pay(Order $order, User $user)
    {
        $client = new Client();

        $params = [
            'appid' => config('wechat.payment.default.app_id'),
            'body' => "eTake 交大外卖订单",
            'mch_id' => config('wechat.payment.default.mch_id'),
            'nonce_str' => Str::random(16),
            'notify_url' => route('api.orders.callback'),
            'openid' => $user->openid,
            'out_trade_no' => $this->order->no,
            'spbill_create_ip' => config('app.ip'),
            'total_fee' => $this->order->fee,
            'trade_type' => 'JSAPI'
        ];

        $params = http_build_query($params);

        $params = $params . '&sign=' . md5($params);

        $response = $client->request(config('wechat.payment.default.request_url'), $params);

        $data = json_decode($response->getBody());

        if ($data['return_code'] !== 'SUCCESS')
        {
            return false;
        }

        if (!verify_response($data)) {
            throw new ResponseUnverifiedException();
        }

        if ($data['result_code'] !== 'SUCCESS')
        {
            return false;
        }

        $res = [
            'appId' => config('wechat.payment.default.app_id'),
            'nonceStr' => Str::random(16),
            'package' => ['prepay_id' => $data['prepay_id']],
            'signType' => 'MD5',
            'timeStamp' => time(),
        ];

        $res_clause = http_build_query($res);
        $res['paySign'] = md5($res_clause);

        return $res;
    }
}
