<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Models\Commodity;
use Illuminate\Http\Request;
use App\Handlers\PrePayHandler;
use App\Transformers\OrderTransformer;
use App\Http\Requests\Api\OrderRequest;
use App\Exceptions\ResponseUnverifiedException;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class OrdersController extends Controller
{
    /**
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $orders = $request->user()->orders;

        $this->authorize('show', $orders->first());

        return $this->response->collection($orders, new OrderTransformer('collection'));
    }

    /**
     * @param Order $order
     * @return \Dingo\Api\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Order $order)
    {
        $this->authorize('show', $order);

        return $this->response->item($order, new OrderTransformer('item'));
    }

    /**
     * @param OrderRequest $request
     * @param PrePayHandler $handler
     * @return \Dingo\Api\Http\Response
     * @throws \App\Exceptions\ResponseUnverifiedException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Exception
     */
    public function store(OrderRequest $request, PrePayHandler $handler)
    {
        $details = [];
        $fee = 0;
        foreach ($request->details as $commodity => $amount)
        {
            $commodity = Commodity::find($commodity);
            $commodity->sales += $amount;
            $commodity->save();
            $subtotal = $amount * $commodity->price;
            $temp = [
                'id' => $commodity->id,
                'price' => $commodity->price,
                'amount' => $amount,
                'subtotal' => $subtotal,
            ];
            $fee += $subtotal;
            $details[] = $temp;
        }

        $attributes = $request->all();
        $attributes['user_id'] = $request->user()->id;
        $attributes['details'] = $details;
        $attributes['status'] = 0;
        $attributes['fee'] = $fee;
        $attributes['no'] = Uuid::uuid1();

        $order = Order::create($attributes);

        if (!$response = $handler->pay($order, $request->user('api')))
        {
            abort(500);
        }

        $order->update(['status' => 1]);

        return $this->response->created(route('api.orders.show', $order->id))->array([
            $response
        ]);
    }

    /**
     * @param Order $order
     * @param OrderRequest $request
     * @return \Dingo\Api\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Order $order, OrderRequest $request)
    {
        $this->authorize('update', $order);

        if ($order->status === 3)
        {
            abort(400, '已配送无法更改地址');
        }

        $order->update([
            'address_id' => $request->address_id,
        ]);

        return $this->response->noContent()->setStatusCode(200);
    }

    /**
     * @param Order $order
     * @return \Dingo\Api\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Order $order)
    {
        $this->authorize('delete', $order);

        if ($order->status === 2)
        {
            throw new BadRequestHttpException('已支付订单不可删除');
        }

        $order->delete();
        return $this->response->noContent()->setStatusCode(200);
    }

    /**
     * @param Order $order
     * @param Request $request
     * @return mixed
     */
    public function callback(Order $order, Request $request)
    {
        if ($request->return_code !== 'SUCCESS')
        {
            return $this->response->array([
                'return_code' => 'FAIL',
                'return_msg' => 'return_code 为 FAIL',
            ]);
        }

        if (!verify_response($request->all()))
        {
            $e = new ResponseUnverifiedException();
            report($e);
            return $this->response->array([
                'return_code' => 'FAIL',
                'return_msg' => '签名不一致',
            ]);
        }

        if ($order->fee != $request->fee)
        {
            $e = new ResponseUnverifiedException();
            report($e);
            return $this->response->array([
                'return_code' => 'FAIL',
                'return_msg' => '金额不一致',
            ]);
        }

        if ($request->result_code !== 'SUCCESS')
        {
            return $this->response->array(['return_code' => 'SUCCESS']);
        }

        $order->update(['status' => 2]);
        return $this->response->array(['return_code' => 'SUCCESS']);
    }
}
