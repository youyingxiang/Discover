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

class CreateCostItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cost_item', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order_id')->default(0)->comment('订单id');
            $table->unsignedTinyInteger('cost_type')->default(0)->comment('费用类型');
            $table->unsignedTinyInteger('pay_type')->default(0)->comment('支付类型');
            $table->unsignedDecimal('should_amount')->default(0)->comment('应付金额');
            $table->unsignedDecimal('actual_amount')->default(0)->comment('实付金额');
            $table->unsignedInteger('with_id')->default(0)->comment('相关订单');
            $table->string('other')->default('')->comment('备注');
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
        Schema::dropIfExists('cost_item');
    }
}
