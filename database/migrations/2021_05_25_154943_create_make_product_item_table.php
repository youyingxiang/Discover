<?php

/*
 * // +----------------------------------------------------------------------
 * // | erp
 * // +----------------------------------------------------------------------
 * // | Copyright (c) 2006~2020 erp All rights reserved.
 * // +----------------------------------------------------------------------
 * // | Licensed ( LICENSE-1.0.0 )
 * // +----------------------------------------------------------------------
 * // | Author: yxx <1365831278@qq.com>
 * // +----------------------------------------------------------------------
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMakeProductItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('make_product_item', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order_id')->index()->default(0)->comment('关联单据');
            $table->unsignedInteger('sku_id')->default(0)->comment('生产入库商品的skuid');
            $table->unsignedDecimal('should_num')->default(0)->comment('计划入库数量');
            $table->unsignedDecimal('actual_num')->default(0)->comment('实际入库数量');
            $table->unsignedDecimal('cost_price')->default(0)->comment('成本价格');
            $table->unsignedInteger('position_id')->default(0)->comment('位置id');
            $table->string('batch_no')->default('')->comment('批次号');
            $table->unsignedDecimal('percent')->default(0.00)->comment('含绒量');
            $table->unsignedTinyInteger('standard')->default(0)->comment('检验标准');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('make_product_item');
    }
}
