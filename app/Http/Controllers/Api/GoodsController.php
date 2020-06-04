<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Resources\Goods\GoodsDetailResource;
use App\Models\Goods;
use App\Service\DataokeService;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class GoodsController extends BaseController
{

    public function index(Request $request)
    {
        $params = $request->all();

        $cid = $params['cid'] ?? 0;
        $subcid = $params['subcid'] ?? 0;

        $builder = Goods::query();

        if($cid != 0){
            $builder->where('cid',$cid);
        }

        if($subcid != 0){
            $builder->where('subcid',$subcid);
        }

        $goods = $builder->offset(get_offset(10))->take(10)->get();

        return $this->normalResponse(compact('goods'));
    }

    public function show($id)
    {
        $goods = Goods::query()->with('imgs','pics')->find($id);
//        dd($goods);
        $goods = new GoodsDetailResource($goods);
        return $this->normalResponse(compact('goods'));
    }

    public function search(Request $request)
    {
        $params = $request->all();

        $keyword = $params['keyword'] ?? '';


        $dataoke = new DataokeService();
        $goods = $dataoke->searchGoods($keyword);

        return $this->normalResponse(compact('goods'));
    }


    public function getTkl(Request $request)
    {
        $params = $request->all();
        $dataoke = new DataokeService();

        $pid = 'mm_26887704_1642950055_110356700272';

        $goods = $dataoke->makeTkl($params['goodsId'],$params['couponId'],$pid);

    }


}
