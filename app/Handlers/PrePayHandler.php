<?php

namespace App\Handlers;

use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
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
            'notify_url' => app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('api.orders.callback', $order->id),
            'openid' => $user->openid,
            'out_trade_no' => $order->no->getHex(),
            'spbill_create_ip' => config('app.ip'),
            'total_fee' => $order->fee,
            'trade_type' => 'JSAPI'
        ];

        $query_clause = http_build_query($params) . '&key=' . config('wechat.payment.default.key');
        $params['sign'] = strtoupper(md5($query_clause));

        $xml = '<xml>';
        foreach ($params as $key => $param)
        {
            $xml .= "<" . $key . ">" . $param . "</" . $key . ">";
        }
        $xml .= '</xml>';

        $request = new Request(
            'POST',
            config('wechat.payment.default.request_url'),
            ['Content-Type' => 'text/xml'],
            $xml
        );

        $response = $client->send($request);

        $data = str_replace(['<![CDATA[', ']]>'], '', (string)$response->getBody());
        $data = simplexml_load_string($data);
        $data = json_encode($data);
        $data = json_decode($data, true);

        if ($data['return_code'] !== 'SUCCESS')
        {
            Log::error("预支付接口调用失败 通信错误", [
                'Request' => $params,
                'Response' => $data,
                'Order' => $order->id,
                'User' => $user->id
            ]);
            return false;
        }

        if (!verify_response($data)) {
            throw new ResponseUnverifiedException();
        }

        if ($data['result_code'] !== 'SUCCESS')
        {
            Log::error("预支付接口调用失败 支付错误", [
                'Request' => (string)$request,
                'Response' => (string)$response,
                'Order' => $order->id,
                'User' => $user->id
            ]);
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
