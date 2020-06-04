<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CacheController extends BaseController
{
    public function categories()
    {
        $categories = Category::query()->with('children')->where('parent_id',0)->where('is_show',1)->get();

        return $this->normalResponse(compact('categories'));
    }




}
