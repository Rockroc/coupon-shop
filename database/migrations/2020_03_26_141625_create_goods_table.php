<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->unsignedInteger('id');
            $table->string('tb_goods_id')->comment('淘宝商品ID');
            $table->unsignedTinyInteger('shop_type')->comment('店铺类型，1-天猫，0-淘宝');


            $table->string('title')->comment('商品标题');
            $table->string('desc')->nullable()->comment('商品简介');
            $table->unsignedTinyInteger('cid')->comment('淘宝客分类ID');
            $table->unsignedMediumInteger('subcid')->comment('淘宝客子分类ID');
            $table->unsignedTinyInteger('activity_type')->default(1)->comment('活动类型，1-无活动，2-淘抢购，3-聚划算');
            $table->unsignedTinyInteger('haitao')->default(1)->comment('是否海淘，1-海淘商品，0-非海淘商品');
            $table->string('main_pic')->comment('主图');
            $table->decimal('origin_price',8,2)->comment('原价格');
            $table->decimal('coupon_price',6,2)->comment('券价格');
            $table->decimal('actual_price',8,2)->comment('券后格');
            $table->string('coupon_id')->comment('优惠券ID');
            $table->unsignedMediumInteger('sales')->default(0)->comment('销量');
            $table->string('tkl')->nullable()->comment('淘口令');

            $table->unsignedTinyInteger('is_reommend')->default(0)->comment('是否推荐');

            $table->timestamp('create_time')->nullable()->comment('上架时间');

            $table->softDeletes();
            $table->timestamps();

            $table->index('cid');
            $table->index('subcid');
            $table->index('sales');
            $table->index('actual_price');
            $table->index('create_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goods');
    }
}
