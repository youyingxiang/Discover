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

class CreateInitStockItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('init_stock_item', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order_id')->default('0')->comment('订单id');
            $table->unsignedInteger('sku_id')->default('0')->comment('skuId');
            $table->decimal('percent')->default('0')->comment('含绒量');
            $table->unsignedTinyInteger('standard')->default('0')->comment('检验标准');
            $table->unsignedInteger('actual_num')->default('0')->comment('期初库存');
            $table->decimal('cost_price')->default('0')->comment('成本价格');
            $table->unsignedInteger('position_id')->default('0')->comment('库位');
            $table->string('batch_no')->default('')->comment('批次号');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('init_stock_item');
    }
}
