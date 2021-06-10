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
use ETaobao\Factory;
class TestController extends Controller
{
    public function index()
    {


        $config = [
            'appkey' => '31278286',
            'secretKey' => '903850883679fac986e5051f343b6335',
            'format' => 'json',
            'session' => '6101c02c471567e2b6f2ba7a494e850381e3c5640ad462b676969015',//授权接口（sc类的接口）需要带上
            'sandbox' => false,
        ];

        $app = Factory::Tbk($config);

        //获取分享标识
//        $param = [
//            'relation_app' => 'common',
//            'code_type' => '3',
//        ];
//        $res = $app->sc->getInviteCode($param);
//        dd($res);


        //获取授权链接
//        $param = [
//            'inviter_code' => '6ZEMWJ',
//            'info_type' => '1',
//        ];
//        $res = $app->sc->savePublisherInfo($param);

        $param = [
            'inviter_code' => '6ZEMWJ',
            'info_type' => '1',
        ];
        $res = $app->rebate->getAuth();

        dd($res);
        print_r($res);

        die('ffe');

//
//        $goods = Goods::query()->whereNull('tkl')->get();
//
//        $dataoke = new DataokeService();
//
//        $text = 'test';
//        $pid = 'mm_26887704_1642950055_110356700272';
//        foreach($goods as $item){
//            $url = 'https://uland.taobao.com/coupon/edetail?activityId='.$item->coupon_id.'&itemId='.$item->tb_goods_id.'&pid='.$pid;
//
//            $tkl = $dataoke->makeTkl($text,$url);
//            $item->update([
//               'tkl' => $tkl
//            ]);
//        }
//        die('test');


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


        $page = 7;

        $dataoke = new DataokeService();
        $rows = $dataoke->getGoodsList($page,null,0);

//        dd($rows);
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


            $pics = json_decode($record['detailPics']);

            if(is_array($pics)){
                foreach($pics as $pic){

                    GoodsDetailPic::query()->forceCreate([
                        'goods_id' => $record['id'],
                        'pic' => $pic->img
                    ]);
                }
            }

        }


    }


}
