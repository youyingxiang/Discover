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

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_history', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->unsignedInteger('sku_id')->default(0)->comment('sku_id');
            $table->unsignedInteger('in_position_id')->default(0)->comment('入库位置');
            $table->unsignedInteger('out_position_id')->default(0)->comment('出库位置');
            $table->decimal('cost_price', 10, 2)->default(0.00)->comment('成本价格');
            $table->unsignedTinyInteger('type')->default(0)->comment('业务类型');
            $table->unsignedTinyInteger('flag')->default(0)->comment('出入库标志');
            $table->string('with_order_no')->default('')->comment('相关单号');
            $table->integer('init_num')->default(0)->comment('期初库存');
            $table->integer('in_num')->default(0)->comment('入库数量');
            $table->decimal('in_price', 10, 2)->default(0.00)->comment('入库价格');
            $table->integer('out_num')->default(0)->comment('出库数量');
            $table->decimal('out_price', 10, 2)->default(0.00)->comment('出库价格');
            $table->integer('balance_num')->default(0)->comment('结余库存');
            $table->integer('user_id')->default(0)->comment('操作用户');
            $table->string('batch_no')->default('')->comment('批次号');
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
        Schema::dropIfExists('stock_history');
    }
}
