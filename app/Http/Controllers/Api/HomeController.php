<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends BaseController
{

    public function index()
    {
        $banners = [];

        $categories = Category::query()->where('parent_id',0)->where('is_show',1)->get();

        return $this->normalResponse(compact('categories'));
    }


}
