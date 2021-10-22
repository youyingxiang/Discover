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

class CreateMakeProductOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('make_product_order', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('with_id')->default(0)->comment('相关单据id');
            $table->string('order_no')->default('')->unique()->comment('单号');
            $table->unsignedInteger('user_id')->default(0)->comment('创建人');
            $table->unsignedInteger('apply_id')->default(0)->comment('审核人');
            $table->text('other')->comment('备注');
            $table->unsignedTinyInteger('review_status')->default(0)->comment('状态');
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
        Schema::dropIfExists('make_product_order');
    }
}
