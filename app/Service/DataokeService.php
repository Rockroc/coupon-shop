<?php
namespace App\Service;

class DataokeService
{

    public function getGoodsList($page=1,$type,$sort)
    {
        $uri = 'https://openapi.dataoke.com/api/goods/get-goods-list';


        $params = [
            "pageId"=>$page,
            "pageSize"=>50,
            "sort" => $sort
        ];

        if($type){
            $typeParam = [];
            switch ($type){
                case "juHuaSuan":
                    $typeParam = ["juHuaSuan"=>1];
                    break;
                case "taoQiangGou":
                    $typeParam = ["taoQiangGou"=>1];
                    break;
                case "tchaoshi":
                    $typeParam = ["tchaoshi"=>1];
                    break;
                case "haitao":
                    $typeParam = ["haitao"=>1];
                    break;
                case "niceToNice":
//                    $typeParam = ["taoQiangGou"=>1];
                    break;

            }

            $params = array_merge($params,$typeParam);
        }


        $data = $this->request($uri,$params);
        return $data['data']['list'];
    }

    public function getGoodsDetail($id)
    {
        $uri = 'https://openapi.dataoke.com/api/goods/get-goods-details';

        $params = [
            "id"=>$id
        ];

        $data = $this->request($uri,$params);

        return $data['data'];
    }

    public function searchGoods($keyword)
    {
        $uri = 'https://openapi.dataoke.com/api/goods/list-super-goods';

        $params = [
            "type"=>0,
            "keyWords" => $keyword,
            "pageSize" =>10
        ];

        $data = $this->request($uri,$params);

        return $data['data']['list'];
    }

    public function categories()
    {
        $uri = 'https://openapi.dataoke.com/api/category/get-super-category';

        $params = [];

        $data = $this->request($uri,$params);

        return $data['data'];
    }

    public function makeTkl($text,$url)
    {
        $uri = 'https://openapi.dataoke.com/api/tb-service/creat-taokouling';

        $params = [
            "text"=>$text,
            "url" => $url,
        ];

//        dd($p);
        $data = $this->request($uri,$params);

        return $data['data']['model'];
    }


    private function request($uri,$params = [])
    {
        $appKey = '5eb284cb619af';//应用的key
        $appSecret = 'b27df5008647a2d190b01216c009869f';//应用的Secret
        //默认必传参数
        $data = [
            'appKey' => $appKey,
            'version' => 'v1.3.0',

        ];

        $data = array_merge($data,$params);

        //加密的参数

        $data['sign'] = $this->makeSign($data,$appSecret);

        //拼接请求地址
        $url = $uri .'?'. http_build_query($data);

//        dd($url);
        $client = new \GuzzleHttp\Client();
        $response = $client->get($url);

        $res = json_decode((string)$response->getBody(), true);

        return $res;
    }

    private function makeSign($data, $appSecret)
    {
        ksort($data);
        $str = '';
        foreach ($data as $k => $v) {

            $str .= '&' . $k . '=' . $v;
        }
        $str  = trim($str, '&');
        $sign = strtoupper(md5($str . '&key=' . $appSecret));
        return $sign;
    }



}