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

class ChangeStockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_item', function (Blueprint $table) {
            $table->dropColumn(['position_id', 'batch_no']);
        });

        Schema::table('sale_out_batch', function (Blueprint $table) {
            $table->dropColumn(['cost_price', 'position_id', 'batch_no']);
            $table->unsignedInteger('stock_batch_id')->default(0)->comment('出库产品批次id');
        });

        Schema::table('sku_stock_batch', function (Blueprint $table) {
            $table->unsignedDecimal('cost_price', 10, 2)->default(0.00)->comment('成本价');
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
