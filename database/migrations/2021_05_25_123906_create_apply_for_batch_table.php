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

class CreateApplyForBatchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apply_for_batch', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('item_id')->default(0)->comment('订单明细id');
            $table->unsignedDecimal('actual_num')->default(0)->comment('实领数量');
            $table->unsignedInteger('stock_batch_id')->comment('出库批次库存id');
            $table->unsignedTinyInteger('standard')->default(0)->comment('检验标准');
            $table->unsignedDecimal('percent')->default(0.00)->comment('含绒量');
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
        Schema::dropIfExists('apply_for_batch');
    }
}
