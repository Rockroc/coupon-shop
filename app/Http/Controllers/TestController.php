<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Category;
use App\Models\Goods;
use App\Models\GoodsDetailPic;
use App\Models\GoodsImg;
use App\Service\DataokeService;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use QL\QueryList;

class TestController extends Controller
{
    public function index()
    {
//        $url = 'https://uland.taobao.com/quan/detail?sellerId=2181576422&activityId=c5051b65a56a49aabef7481fc89663a8';
//
//        $param = parse_url($url)['query'];
//        $array = explode('=',$param);
//        $activityId = end($array);
//
//        dd($activityId);

//        $dataoke = new DataokeService();
//        $categories = $dataoke->categories();
//
//        foreach($categories as $category){
//            Category::query()->forceCreate([
//               'id' =>  $category['cid'],
//               'parent_id' => 0,
//               'name' => $category['cname'],
//               'icon' => $category['cpic'],
//            ]);
//
//            foreach($category['subcategories'] as $row){
//                Category::query()->forceCreate([
//                    'id' =>  $row['subcid'],
//                    'parent_id' => $category['cid'],
//                    'name' => $row['subcname'],
//                    'icon' => $row['scpic'],
//                ]);
//            }
//        }


        $page = 5;

        $dataoke = new DataokeService();
        $rows = $dataoke->getGoodsList($page,null,0);


        foreach($rows as $row){

            //请求详情页
            $dataoke = new DataokeService();
            $record = $dataoke->getGoodsDetail($row['id']);

            $param = parse_url($record['couponLink'])['query'];
            $array = explode('=',$param);
            $activityId = end($array);

//            dd($record);

            $goods = Goods::query()->forceCreate([
                'id' => $record['id'],
                'tb_goods_id' => $record['goodsId'],
                'shop_type' => $record['shopType'],
                'title' => $record['title'],
                'desc' => $record['desc'],
                'cid' => $record['cid'],
                'activity_type' => $record['activityType'],
                'haitao' => $record['haitao'],
                'subcid' => $record['subcid'][0] ?? 0,
                'main_pic' => $record['mainPic'],
                'origin_price' => $record['originalPrice'],
                'coupon_price' => $record['couponPrice'],
                'actual_price' => $record['actualPrice'],
                'coupon_id' => $activityId,
                'sales' => $record['monthSales'],
                'create_time' => $record['createTime'],
            ]);

            $imgs = explode(',',$record['imgs']);
            foreach($imgs as $img){
                GoodsImg::query()->forceCreate([
                    'goods_id' => $record['id'],
                    'img' => $img
                ]);
            }

            $pics = explode(',',$record['detailPics']);

            foreach($pics as $pic){
                GoodsDetailPic::query()->forceCreate([
                    'goods_id' => $record['id'],
                    'pic' => $pic
                ]);
            }
        }


    }


}
