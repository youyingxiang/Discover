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

class AddCostPriceIntoSaleOutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_out_batch', function (Blueprint $table) {
            $table->unsignedDecimal("cost_price")->default(0.00)->comment('成本单价');
        });

        Schema::table('sale_out_item', function (Blueprint $table) {
            $table->unsignedDecimal("sum_cost_price")->default(0.00)->comment('成本单价');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sale_out_item', function (Blueprint $table) {
            $table->dropColumn("sum_cost_price");
        });
        Schema::table('sale_out_batch', function (Blueprint $table) {
            $table->dropColumn("cost_price");
        });
    }
}
