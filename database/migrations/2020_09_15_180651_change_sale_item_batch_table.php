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

class ChangeSaleItemBatchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_in_item', function (Blueprint $table) {
            $table->dropColumn(['position_id', 'batch_no']);
        });

        Schema::table('sale_out_item', function (Blueprint $table) {
            $table->dropColumn(['position_id', 'batch_no']);
        });

        Schema::create('sale_out_batch', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->unsignedInteger('item_id')->default(0)->comment('订单明细id');
            $table->unsignedInteger('actual_num')->default(0)->comment('出库数量');
            $table->decimal('cost_price', 10, 2)->default(0)->comment('成本价格');
            $table->unsignedInteger('position_id')->default(0)->comment('位置id');
            $table->string('batch_no', 32)->default('')->comment('批次号');
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
        //
    }
}
