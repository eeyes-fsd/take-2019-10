<?php

namespace App\Http\Controllers\Api;

use App\Models\Commodity;
use App\Transformers\CommodityTransformer;
use Illuminate\Http\Request;

class CommoditiesController extends Controller
{
    /**
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {
        $commodities = Commodity::all();
        return $this->response->collection($commodities, new CommodityTransformer());
    }

    /**
     * @param Commodity $commodity
     * @return \Dingo\Api\Http\Response
     */
    public function show(Commodity $commodity)
    {
        return $this->response->item($commodity, new CommodityTransformer());
    }
}
