<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    /**
     * 成功请求返回
     * @param $message
     * @return array
     */
    protected function success($message, $code = 0)
    {
        return [
            'code'    => $code,
            'message' => $message
        ];
    }

    /**
     * @param $array
     * @param $code
     * @return array
     */
    protected function normalResponse($array, $code = 0)
    {
        $response = ['code' => $code];
        return array_merge($response, $array);
    }
}
