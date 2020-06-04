<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    public function index()
    {

    }

    public function children($id)
    {
        $categories = Category::query()->where('parent_id',$id)->get();

        return $this->normalResponse(compact('categories'));
    }


}
