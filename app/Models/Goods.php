<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    protected $table  = 'goods';

    protected $guarded = [];

    public function imgs()
    {
        return $this->hasMany(GoodsImg::class,'goods_id','id');
    }

    public function pics(){
        return $this->hasMany(GoodsDetailPic::class,'goods_id','id');
    }

}
