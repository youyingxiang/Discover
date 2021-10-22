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

class CreateInitStockOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('init_stock_order', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_no')->unique()->default('')->comment('单号');
            $table->unsignedInteger('user_id')->default('0')->comment('创建人');
            $table->unsignedInteger('apply_id')->default('0')->comment('审核人');
            $table->text('other')->nullable()->comment('备注');
            $table->unsignedTinyInteger('review_status')->default('0')->comment('状态');
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
        Schema::dropIfExists('init_stock_order');
    }
}
