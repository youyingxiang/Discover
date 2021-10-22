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

class CreateSaleOrderAmountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_order_amount', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order_id')->default(0)->comment('订单id');
            $table->unsignedInteger('customer_id')->default(0)->comment('客户id');
            $table->unsignedTinyInteger('status')->default(0)->comment('结算状态');
            $table->unsignedDecimal('should_amount')->default(0)->comment('费用金额');
            $table->unsignedDecimal('actual_amount')->default(0)->comment('结算金额');
            $table->unsignedInteger('accountant_id')->default(0)->comment('结算年月');
            $table->timestamp('settlement_at')->nullable()->comment('结算日期');
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
        Schema::dropIfExists('sale_order_amount');
    }
}
